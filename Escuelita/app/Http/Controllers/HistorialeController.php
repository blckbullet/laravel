<?php

namespace App\Http\Controllers;

use App\Models\Historiale;
use App\Models\Alumno;   // 1. Importar Alumno
use App\Models\Materia;  // 2. Importar Materia
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\HistorialeRequest;
use Illuminate\Support\Facades\DB; // 3. Importar DB para concatenar
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Grupo;
use App\Models\Horario;

class HistorialeController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $historiales = Historiale::with('alumno', 'materia')
            ->when($search, function ($query, $search) {
                return $query->whereHas('alumno', function ($q) use ($search) {
                                 $q->where('matricula', 'like', "%{$search}%")
                                   ->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE ?", ["%{$search}%"]);
                             })
                             ->orWhereHas('materia', function ($q) use ($search) {
                                 $q->where('nombre', 'like', "%{$search}%");
                             });
            })
            ->paginate();

        return view('historiale.index', compact('historiales'))
            ->with('i', ($request->input('page', 1) - 1) * $historiales->perPage());
    }

    public function create(): View
{
    $historiale = new Historiale();
    
    $alumnos = Alumno::where('esta_activo', true) // Asumiendo que implementaste esto
        ->select('matricula', DB::raw("CONCAT(nombre, ' ', apellido_paterno) AS nombre_completo"))
        ->pluck('nombre_completo', 'matricula');
        
    // REEMPLAZAMOS $materias POR $grupos
    $grupos = Grupo::with('materia') // Cargamos la materia relacionada
        ->get()
        ->mapWithKeys(function ($grupo) {
            $nombreMateria = $grupo->materia->nombre ?? 'Sin Materia';
            $key = $grupo->id;
            // El texto del dropdown será: "Cálculo Diferencial - Gpo: 101A"
            $value = $nombreMateria . ' - Gpo: ' . $grupo->nombre; 
            return [$key => $value];
        });

    // Pasamos 'grupos' a la vista en lugar de 'materias'
    return view('historiale.create', compact('historiale', 'alumnos', 'grupos'));
}

    public function store(HistorialeRequest $request): RedirectResponse
{
    // 1. Obtenemos datos validados
    $datosValidados = $request->validated();
    $matricula = $datosValidados['alumno_matricula'];
    $grupoNuevoId = $datosValidados['grupo_id'];
    $semestreActual = $datosValidados['semestre'];
    $añoActual = $datosValidados['año'];

    // 2. Obtenemos la materia_id (la necesitamos para la lógica de Repite)
    $grupoNuevo = Grupo::with('materia')->find($grupoNuevoId);
    $materiaId = $grupoNuevo->materia_id;
    $datosValidados['materia_id'] = $materiaId; // Importante para el create()

    // 3. Verificamos si el alumno está activo
    $alumno = Alumno::find($matricula);
    if (!$alumno || !$alumno->esta_activo) {
        return Redirect::back()->with('error', 'Este alumno está dado de baja.')->withInput();
    }

    // --- INICIO: VERIFICACIÓN DE EMPALME DE HORARIO ---

    // 4. Obtener los horarios del NUEVO grupo que se quiere inscribir
    $horariosNuevos = Horario::where('grupo_id', $grupoNuevoId)->get();

    // 5. Obtener TODAS las OTRAS inscripciones activas (en curso) del alumno 
    //    en el MISMO periodo (semestre y año).
    $otrasInscripciones = Historiale::where('alumno_matricula', $matricula)
        ->where('semestre', $semestreActual)
        ->where('año', $añoActual)
        ->whereNull('calificacion') // <-- Clave: solo materias en curso
        ->where('grupo_id', '!=', $grupoNuevoId) // Excluirse a sí mismo
        ->pluck('grupo_id'); 

    if ($otrasInscripciones->isNotEmpty()) {
        
        // 6. Obtener TODOS los horarios de esas OTRAS inscripciones
        $horariosExistentes = Horario::whereIn('grupo_id', $otrasInscripciones)->get();

        // 7. Comparar CADA horario nuevo con CADA horario existente
        foreach ($horariosNuevos as $horarioNuevo) {
            foreach ($horariosExistentes as $horarioExistente) {
                
                // A. ¿Coinciden en el día?
                if ($horarioNuevo->dia_semana == $horarioExistente->dia_semana) {
                    
                    // B. ¿Hay empalme de hora?
                    // Un empalme existe si (InicioA < FinB) Y (FinA > InicioB)
                    $empalme = ($horarioNuevo->hora_inicio < $horarioExistente->hora_fin) &&
                               ($horarioNuevo->hora_fin > $horarioExistente->hora_inicio);
                    
                    if ($empalme) {
                        // 8. ¡EMPALME! Rechazamos la inscripción
                        $grupoConflicto = Grupo::with('materia')->find($horarioExistente->grupo_id);
                        $materiaConflicto = $grupoConflicto->materia->nombre ?? 'N/A';
                        
                        return Redirect::back()
                            ->with('error', "Empalme de horario: La materia '{$grupoNuevo->materia->nombre}' 
                                            (Día: {$horarioNuevo->dia_semana}, Hora: {$horarioNuevo->hora_inicio}) 
                                            se empalma con '{$materiaConflicto}' 
                                            (Día: {$horarioExistente->dia_semana}, Hora: {$horarioExistente->hora_inicio}).")
                            ->withInput();
                    }
                }
            }
        }
    }
    // --- FIN: VERIFICACIÓN DE EMPALME DE HORARIO ---
    

    // --- INICIO: LÓGICA ORDINARIO/REPITE/ESPECIAL (Tu lógica anterior) ---
    
    $calificacionMinimaAprobatoria = 6.0; 
    $ultimoIntento = Historiale::where('alumno_matricula', $matricula)
        ->where('materia_id', $materiaId) // Usamos $materiaId que obtuvimos del grupo
        ->whereIn('tipo', ['Ordinario', 'Repite', 'Especial']) 
        ->orderBy('created_at', 'desc')
        ->first();

    $nuevoTipo = 'Ordinario'; 

    if ($ultimoIntento) {
        if ($ultimoIntento->calificacion === null) {
            return Redirect::back()->with('error', 'El alumno ya está inscrito en esta materia (calificación pendiente).')->withInput();
        } 
        elseif ($ultimoIntento->calificacion < $calificacionMinimaAprobatoria) {
            if ($ultimoIntento->tipo == 'Ordinario') $nuevoTipo = 'Repite';
            elseif ($ultimoIntento->tipo == 'Repite') $nuevoTipo = 'Especial';
            elseif ($ultimoIntento->tipo == 'Especial') {
                return Redirect::back()->with('error', 'El alumno ya ha reprobado esta materia en Especial.')->withInput();
            }
        } 
        else { 
            return Redirect::back()->with('error', 'El alumno ya tiene esta materia aprobada.')->withInput();
        }
    }
    
    // --- FIN: LÓGICA ORDINARIO/REPITE/ESPECIAL ---

    // 9. Asignar y Guardar
    $datosValidados['tipo'] = $nuevoTipo;
    $datosValidados['calificacion'] = $datosValidados['calificacion'] ?? null;
    $calificacionActual = $datosValidados['calificacion'];

    Historiale::create($datosValidados);

    // 10. Lógica de Baja (Tu lógica anterior)
    $mensaje = "Inscripción en '{$nuevoTipo}' creada exitosamente.";
    if ($nuevoTipo == 'Especial' && $calificacionActual !== null && $calificacionActual < $calificacionMinimaAprobatoria) {
        $alumno->esta_activo = false;
        $alumno->save();
        $mensaje .= " ¡ATENCIÓN: El alumno ha sido DADO DE BAJA por reprobar Especial!";
    }
    elseif ($calificacionActual === null) {
        $mensaje .= " Calificación pendiente.";
    }

    return Redirect::route('historiales.index')->with('success', $mensaje);
}

    public function show(Historiale $historiale): View // 6. Usando Route-Model Binding
    {
        return view('historiale.show', compact('historiale'));
    }

    public function edit(Historiale $historiale): View // 6. Usando Route-Model Binding
    {
        // 7. También se necesitan los datos para las listas al editar
        $alumnos = Alumno::select('matricula', DB::raw("CONCAT(nombre, ' ', apellido_paterno) AS nombre_completo"))
                         ->pluck('nombre_completo', 'matricula');
        $materias = Materia::pluck('nombre', 'id');
        return view('historiale.edit', compact('historiale', 'alumnos', 'materias'));
    }

    public function update(HistorialeRequest $request, Historiale $historiale): RedirectResponse
{
    $datosValidados = $request->validated();
    
    // 1. Actualizamos el registro del historial
    $historiale->update($datosValidados);
    $historiale->refresh(); // Recargamos el modelo con los datos guardados

    // --- INICIO LÓGICA DE BAJA (REGLA 1) ---
    
    $calificacion = $historiale->calificacion;
    $tipo = $historiale->tipo;
    $calificacionMinimaAprobatoria = 6.0;

    // 2. Comprobamos si es 'Especial' y está reprobado
    if ($tipo == 'Especial' && $calificacion !== null && $calificacion < $calificacionMinimaAprobatoria) 
    {
        // 3. Damos de baja al alumno
        $alumno = $historiale->alumno; // Obtenemos el alumno de la relación
        $alumno->esta_activo = false;
        $alumno->save();
        
        // 4. Redirigimos con un mensaje especial
        return Redirect::route('historiales.index')
            ->with('success', 'Calificación de Especial actualizada. ¡ALUMNO DADO DE BAJA por reprobar!');
    }
    
    // --- FIN LÓGICA DE BAJA ---

    return Redirect::route('historiales.index')
        ->with('success', 'Registro de historial actualizado exitosamente.');
}

    public function destroy(Historiale $historiale): RedirectResponse // 6. Usando Route-Model Binding
    {
        $historiale->delete();
        return Redirect::route('historiales.index')
            ->with('success', 'Registro de historial eliminado exitosamente.');
    }
}