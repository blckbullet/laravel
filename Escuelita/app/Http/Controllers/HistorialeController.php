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
    $materiaId = $datosValidados['materia_id'];

    // --- INICIO DE LA LÓGICA AUTOMÁTICA ---
    $calificacionMinimaAprobatoria = 6.0; 

    // 2. Buscamos el último intento del alumno
    $ultimoIntento = Historiale::where('alumno_matricula', $matricula)
        ->where('materia_id', $materiaId)
        ->whereIn('tipo', ['Ordinario', 'Repite', 'Especial']) 
        ->orderBy('created_at', 'desc')
        ->first();

    $nuevoTipo = 'Ordinario'; // Tipo por defecto si no hay historial

    // 3. Revisamos si existe un intento previo
    if ($ultimoIntento) {
        
        // CASO 1: El último intento NO TIENE CALIFICACIÓN (está en curso)
        if ($ultimoIntento->calificacion === null) {
            return Redirect::back()
                ->with('error', 'El alumno ya está inscrito en esta materia (calificación pendiente).')
                ->withInput();
        } 
        
        // CASO 2: El último intento TIENE CALIFICACIÓN y REPROBÓ
        elseif ($ultimoIntento->calificacion < $calificacionMinimaAprobatoria) {
            
            if ($ultimoIntento->tipo == 'Ordinario') {
                $nuevoTipo = 'Repite';
            } elseif ($ultimoIntento->tipo == 'Repite') {
                $nuevoTipo = 'Especial';
            } elseif ($ultimoIntento->tipo == 'Especial') {
                // Ya reprobó 3 veces
                return Redirect::back()
                    ->with('error', 'El alumno ya ha reprobado esta materia en Especial.')
                    ->withInput();
            }
        } 
        
        // CASO 3: El último intento TIENE CALIFICACIÓN y APROBÓ
        else { 
            return Redirect::back()
                ->with('error', 'El alumno ya tiene esta materia aprobada en su historial.')
                ->withInput();
        }
    }
    
    // --- FIN DE LA LÓGICA ---

    // 4. Asignamos el tipo y la calificación
    $datosValidados['tipo'] = $nuevoTipo;
    
    // Aseguramos que si la calificación viene vacía, se guarde como NULL
    $datosValidados['calificacion'] = $datosValidados['calificacion'] ?? null;

    // 5. Creamos el nuevo registro
    Historiale::create($datosValidados);

    // 6. Preparamos el mensaje de éxito
    $mensaje = "Inscripción en '{$nuevoTipo}' creada exitosamente.";
    if ($datosValidados['calificacion'] === null) {
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
        $historiale->update($request->validated());
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