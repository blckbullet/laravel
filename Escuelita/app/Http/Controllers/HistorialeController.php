<?php

namespace App\Http\Controllers;

use App\Models\Historiale;
use App\Models\Alumno;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\Horario;
use App\Models\Profesore; // Asegúrate que este modelo exista
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\HistorialeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class HistorialeController extends Controller
{
    /**
     * Muestra la lista de historiales.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $historiales = Historiale::with([
            'alumno', 
            'materia', 
            // Carga anidada: grupo, sus horarios, y el profesor del grupo
            'grupo.horarios', 
            'grupo.profesor'
        ])
        ->when($search, function ($query, $search) {
            return $query->whereHas('alumno', function ($q) use ($search) {
                $q->where('matricula', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE ?", ["%{$search}%"]);
            })
            ->orWhereHas('materia', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            })
            ->orWhereHas('grupo.profesor', function ($q) use ($search) {
                 $q->whereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE ?", ["%{$search}%"]);
            });
        })
        ->paginate();

        return view('historiale.index', compact('historiales'))
            ->with('i', ($request->input('page', 1) - 1) * $historiales->perPage());
    }

    /**
     * Muestra el formulario para crear un nuevo registro.
     */
    public function create(): View
    {
        $historiale = new Historiale();
        
        // ==========================================================
        // CAMBIO: Filtramos alumnos que NO estén activos O SEAN EGRESADOS
        // ==========================================================
        $alumnos = Alumno::where('esta_activo', true)
            ->where('es_egresado', false) // <-- NUEVA CONDICIÓN
            ->select('matricula', DB::raw("CONCAT(nombre, ' ', apellido_paterno) AS nombre_completo"))
            ->pluck('nombre_completo', 'matricula');
            
        $grupos = Grupo::with('materia')
            ->get()
            ->mapWithKeys(function ($grupo) {
                $nombreMateria = $grupo->materia->nombre ?? 'Sin Materia';
                $key = $grupo->id;
                $value = $nombreMateria . ' - Gpo: ' . $grupo->nombre; 
                return [$key => $value];
            });

        return view('historiale.create', compact('historiale', 'alumnos', 'grupos'));
    }

    /**
     * Guarda el nuevo registro de historial.
     */
    public function store(HistorialeRequest $request): RedirectResponse
    {
        $datosValidados = $request->validated();
        $matricula = $datosValidados['alumno_matricula'];

        // --- REGLA: NO INSCRIBIR A ALUMNOS DE BAJA O EGRESADOS ---
        $alumno = Alumno::find($matricula);
        
        if (!$alumno || !$alumno->esta_activo) {
            return Redirect::back()
                ->with('error', 'Este alumno está dado de baja y no se le pueden añadir inscripciones.')
                ->withInput();
        }
        
        // ==========================================================
        // NUEVA REGLA: Bloquear si es egresado
        // ==========================================================
        if ($alumno->es_egresado) {
            return Redirect::back()
                ->with('error', 'Este alumno es egresado y no se le pueden añadir nuevas materias.')
                ->withInput();
        }
        // --- FIN REGLAS ---
        
        $grupoNuevoId = $datosValidados['grupo_id'];
        $semestreActual = $datosValidados['semestre'];
        $añoActual = $datosValidados['año'];

        $grupoNuevo = Grupo::with('materia')->find($grupoNuevoId);
        $materiaId = $grupoNuevo->materia_id;
        $datosValidados['materia_id'] = $materiaId; 

        // --- VERIFICACIÓN DE EMPALME DE HORARIO (ALUMNO) ---
        $horariosNuevos = Horario::where('grupo_id', $grupoNuevoId)->get();
        $otrasInscripciones = Historiale::where('alumno_matricula', $matricula)
            ->where('semestre', $semestreActual)
            ->where('año', $añoActual)
            ->whereNull('calificacion')
            ->where('grupo_id', '!=', $grupoNuevoId)
            ->pluck('grupo_id'); 

        if ($otrasInscripciones->isNotEmpty()) {
            $horariosExistentes = Horario::whereIn('grupo_id', $otrasInscripciones)->get();

            foreach ($horariosNuevos as $horarioNuevo) {
                foreach ($horariosExistentes as $horarioExistente) {
                    if ($horarioNuevo->dia_semana == $horarioExistente->dia_semana) {
                        $empalme = ($horarioNuevo->hora_inicio < $horarioExistente->hora_fin) &&
                                   ($horarioNuevo->hora_fin > $horarioExistente->hora_inicio);
                        
                        if ($empalme) {
                            $grupoConflicto = Grupo::with('materia')->find($horarioExistente->grupo_id);
                            $materiaConflicto = $grupoConflicto->materia->nombre ?? 'N/A';
                            
                            return Redirect::back()
                                ->with('error', "Empalme de horario: La materia '{$grupoNuevo->materia->nombre}' se empalma con '{$materiaConflicto}'.")
                                ->withInput();
                        }
                    }
                }
            }
        }
        // --- FIN VERIFICACIÓN DE EMPALME ---
        
        // --- LÓGICA ORDINARIO/REPITE/ESPECIAL ---
        $calificacionMinimaAprobatoria = 6.0; 
        $ultimoIntento = Historiale::where('alumno_matricula', $matricula)
            ->where('materia_id', $materiaId)
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
        // --- FIN LÓGICA ORDINARIO/REPITE ---

        $datosValidados['tipo'] = $nuevoTipo;
        $datosValidados['calificacion'] = $datosValidados['calificacion'] ?? null;
        $calificacionActual = $datosValidados['calificacion'];

        Historiale::create($datosValidados);

        // --- LÓGICA DE BAJA (por reprobar Especial) ---
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

    /**
     * Muestra un registro específico del historial.
     */
    public function show(Historiale $historiale): View
    {
        // Cargar las relaciones necesarias
        $historiale->load(['alumno', 'materia', 'grupo.profesor', 'grupo.horarios']);
        return view('historiale.show', compact('historiale'));
    }

    /**
     * Muestra el formulario para editar un registro.
     */
    public function edit(Historiale $historiale): View
    {
        // ==========================================================
        // CAMBIO: Filtramos alumnos que NO estén activos O SEAN EGRESADOS
        // Incluimos al alumno actual en la lista, por si acaso es egresado pero
        // solo queremos editar su registro, no crear uno nuevo.
        // ==========================================================
        $alumnos = Alumno::where(function($query) use ($historiale) {
                $query->where('esta_activo', true)
                      ->where('es_egresado', false)
                      ->orWhere('matricula', $historiale->alumno_matricula); // Incluir al alumno actual
            })
            ->select('matricula', DB::raw("CONCAT(nombre, ' ', apellido_paterno) AS nombre_completo"))
            ->pluck('nombre_completo', 'matricula');
            
        $grupos = Grupo::with('materia')
            ->get()
            ->mapWithKeys(function ($grupo) {
                $nombreMateria = $grupo->materia->nombre ?? 'Sin Materia';
                $key = $grupo->id;
                $value = $nombreMateria . ' - Gpo: ' . $grupo->nombre; 
                return [$key => $value];
            });

        return view('historiale.edit', compact('historiale', 'alumnos', 'grupos'));
    }

    /**
     * Actualiza un registro de historial.
     */
    public function update(HistorialeRequest $request, Historiale $historiale): RedirectResponse
    {
        $datosValidados = $request->validated();
        
        // (Lógica de validación de egresado/empalme podría ir aquí también si permites cambiar alumno/grupo)
        
        $historiale->update($datosValidados);
        $historiale->refresh(); 

        $calificacion = $historiale->calificacion;
        $tipo = $historiale->tipo;
        $calificacionMinimaAprobatoria = 6.0;

        // --- LÓGICA DE BAJA (por reprobar Especial) ---
        if ($tipo == 'Especial' && $calificacion !== null && $calificacion < $calificacionMinimaAprobatoria) 
        {
            $alumno = $historiale->alumno;
            $alumno->esta_activo = false;
            $alumno->save();
            
            return Redirect::route('historiales.index')
                ->with('success', 'Calificación de Especial actualizada. ¡ALUMNO DADO DE BAJA por reprobar!');
        }
        
        return Redirect::route('historiales.index')
            ->with('success', 'Registro de historial actualizado exitosamente.');
    }

    /**
     * Elimina un registro de historial.
     */
    public function destroy(Historiale $historiale): RedirectResponse
    {
        $historiale->delete();
        return Redirect::route('historiales.index')
            ->with('success', 'Registro de historial eliminado exitosamente.');
    }
    
    /**
     * API: Devuelve grupos disponibles para AJAX (Opcional).
     */
    public function getGruposDisponibles(Request $request)
    {
        $datos = $request->validate([
            'matricula' => 'required|string|exists:alumnos,matricula',
            'semestre' => 'required|integer',
            'año' => 'required|integer',
        ]);

        $matricula = $datos['matricula'];
        $semestre = $datos['semestre'];
        $año = $datos['año'];

        // Verificar si el alumno está egresado o inactivo
        $alumno = Alumno::find($matricula);
        if (!$alumno || !$alumno->esta_activo || $alumno->es_egresado) {
            return response()->json(['error' => 'Alumno no válido para inscripción'], 403);
        }

        $inscripcionesExistentes = Historiale::where('alumno_matricula', $matricula)
            ->where('semestre', $semestre)
            ->where('año', $año)
            ->whereNull('calificacion')
            ->pluck('grupo_id');

        $horariosOcupados = Horario::whereIn('grupo_id', $inscripcionesExistentes)->get();

        $todosLosGrupos = Grupo::with(['materia', 'horarios'])->get();
        $gruposDisponibles = [];

        foreach ($todosLosGrupos as $grupo) {
            $tieneConflicto = false;
            
            if ($grupo->horarios->isEmpty()) continue;

            foreach ($grupo->horarios as $horarioNuevo) {
                foreach ($horariosOcupados as $horarioOcupado) {
                    if ($horarioNuevo->dia_semana == $horarioOcupado->dia_semana) {
                        $empalme = ($horarioNuevo->hora_inicio < $horarioOcupado->hora_fin) &&
                                   ($horarioNuevo->hora_fin > $horarioOcupado->hora_inicio);
                        if ($empalme) {
                            $tieneConflicto = true;
                            break; 
                        }
                    }
                }
                if ($tieneConflicto) break;
            }

            if (!$tieneConflicto) {
                $gruposDisponibles[] = [
                    'id' => $grupo->id,
                    'nombre_completo' => ($grupo->materia->nombre ?? 'N/A') . ' - Gpo: ' . $grupo->nombre
                ];
            }
        }
        return response()->json($gruposDisponibles);
    }
}

