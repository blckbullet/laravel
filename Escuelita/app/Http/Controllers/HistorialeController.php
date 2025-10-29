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
        // 5. Obtener datos para las listas desplegables
        $alumnos = Alumno::select('matricula', DB::raw("CONCAT(nombre, ' ', apellido_paterno) AS nombre_completo"))
                         ->pluck('nombre_completo', 'matricula');
        $materias = Materia::pluck('nombre', 'id');

        return view('historiale.create', compact('historiale', 'alumnos', 'materias'));
    }

    public function store(HistorialeRequest $request): RedirectResponse
{
    // 1. Obtenemos los datos validados
    $datosValidados = $request->validated();
    $matricula = $datosValidados['alumno_matricula'];

    // --- REGLA 2: NO INSCRIBIR A ALUMNOS DE BAJA ---
    $alumno = Alumno::find($matricula);
    if (!$alumno || !$alumno->esta_activo) {
        return Redirect::back()
            ->with('error', 'Este alumno está dado de baja y no se le pueden añadir inscripciones.')
            ->withInput();
    }
    // --- FIN REGLA 2 ---
    
    $materiaId = $datosValidados['materia_id'];
    $calificacionMinimaAprobatoria = 6.0; 

    // 2. Buscamos el último intento del alumno
    $ultimoIntento = Historiale::where('alumno_matricula', $matricula)
        ->where('materia_id', $materiaId)
        ->whereIn('tipo', ['Ordinario', 'Repite', 'Especial']) 
        ->orderBy('created_at', 'desc')
        ->first();

    $nuevoTipo = 'Ordinario';

    if ($ultimoIntento) {
        if ($ultimoIntento->calificacion === null) {
            return Redirect::back()
                ->with('error', 'El alumno ya está inscrito en esta materia (calificación pendiente).')
                ->withInput();
        } 
        elseif ($ultimoIntento->calificacion < $calificacionMinimaAprobatoria) {
            if ($ultimoIntento->tipo == 'Ordinario') {
                $nuevoTipo = 'Repite';
            } elseif ($ultimoIntento->tipo == 'Repite') {
                $nuevoTipo = 'Especial';
            } elseif ($ultimoIntento->tipo == 'Especial') {
                return Redirect::back()
                    ->with('error', 'El alumno ya ha reprobado esta materia en Especial.')
                    ->withInput();
            }
        } 
        else { 
            return Redirect::back()
                ->with('error', 'El alumno ya tiene esta materia aprobada en su historial.')
                ->withInput();
        }
    }
    
    // 4. Asignamos el tipo y la calificación
    $datosValidados['tipo'] = $nuevoTipo;
    $datosValidados['calificacion'] = $datosValidados['calificacion'] ?? null;
    $calificacionActual = $datosValidados['calificacion'];

    // 5. Creamos el nuevo registro
    Historiale::create($datosValidados);

    // --- REGLA 1: DAR DE BAJA SI REPRUEBA ESPECIAL ---
    $mensaje = "Inscripción en '{$nuevoTipo}' creada exitosamente.";
    if ($nuevoTipo == 'Especial' && $calificacionActual !== null && $calificacionActual < $calificacionMinimaAprobatoria) {
        
        $alumno->esta_activo = false;
        $alumno->save();
        
        $mensaje .= " ¡ATENCIÓN: El alumno ha sido DADO DE BAJA por reprobar Especial!";
    }
    elseif ($calificacionActual === null) {
        $mensaje .= " Calificación pendiente.";
    }
    // --- FIN REGLA 1 ---

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