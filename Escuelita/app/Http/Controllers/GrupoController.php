<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Profesore; // Tu modelo de profesor
use App\Models\Horario;   // <-- 1. AÑADIR IMPORTACIÓN
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\GrupoRequest; // <-- 2. AHORA USAMOS ESTO
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect; // <-- 3. AÑADIR IMPORTACIÓN
use Illuminate\View\View;

class GrupoController extends Controller
{
    /**
     * Muestra la lista de grupos.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        // ==========================================================
        // CAMBIO: Añadir 'horarios' al with()
        // ==========================================================
        $grupos = Grupo::with('materia', 'profesor', 'horarios') 
            ->when($search, function ($query, $search) {
                return $query->where('nombre', 'like', "%{$search}%")
                    ->orWhereHas('materia', function ($q) use ($search) {
                        $q->where('nombre', 'like', "%{$search}%");
                    })
                    ->orWhereHas('profesor', function ($q) use ($search) {
                        $q->whereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE ?", ["%{$search}%"]);
                    });
            })
            ->paginate();

        return view('grupo.index', compact('grupos'))
            ->with('i', ($request->input('page', 1) - 1) * $grupos->perPage());
    }

    /**
     * Muestra el formulario para crear un nuevo grupo.
     */
    public function create(): View
    {
        $grupo = new Grupo();
        $materias = Materia::pluck('nombre', 'id');

        $profesores = Profesore::select(
            'id',
            DB::raw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre_completo")
        )->pluck('nombre_completo', 'id');

        return view('grupo.create', compact('grupo', 'materias', 'profesores'));
    }

    /**
     * Guarda el nuevo grupo Y SUS HORARIOS (CON VALIDACIÓN DE PROFESOR).
     */
    public function store(GrupoRequest $request): RedirectResponse
    {
        // 1. Obtenemos los datos validados
        $datosValidados = $request->validated();
        
        $profesor_id = $datosValidados['profesor_id'];
        $horarios_nuevos = $datosValidados['horarios'] ?? []; // Obtenemos el array de horarios

        // ==========================================================
        // 2. NUEVA VALIDACIÓN DE EMPALME PARA PROFESOR
        // ==========================================================
        if ($profesor_id && !empty($horarios_nuevos)) {
            $conflicto = $this->validarHorarioProfesor($profesor_id, $horarios_nuevos);
            
            if ($conflicto) {
                return Redirect::back()
                    ->with('error', "¡Empalme de horario para el profesor! Ya tiene una clase el {$conflicto['dia_semana']} de {$conflicto['hora_inicio']} a {$conflicto['hora_fin']}.")
                    ->withInput(); // withInput() para que el formulario no se borre
            }
        }
        // --- FIN DE LA VALIDACIÓN ---

        // 3. Creamos el Grupo primero
        $grupo = Grupo::create([
            'nombre' => $datosValidados['nombre'],
            'materia_id' => $datosValidados['materia_id'],
            'profesor_id' => $datosValidados['profesor_id'],
        ]);

        // 4. Guardamos los horarios asociados (si se enviaron)
        if ($request->has('horarios')) {
            foreach ($datosValidados['horarios'] as $horarioData) {
                // Creamos el horario y lo asociamos al grupo
                $grupo->horarios()->create($horarioData);
            }
        }

        return Redirect::route('grupos.index')
            ->with('success', 'Grupo creado exitosamente con sus horarios.');
    }

    /**
     * Muestra un grupo específico.
     */
    public function show(Grupo $grupo): View
    {
        // ==========================================================
        // CAMBIO: Cargar relaciones para la vista
        // ==========================================================
        $grupo->load('materia', 'profesor', 'horarios');
        return view('grupo.show', compact('grupo'));
    }

    /**
     * Muestra el formulario para editar un grupo.
     */
    public function edit(Grupo $grupo): View
    {
        // 6. Cargar los horarios existentes para pasarlos al formulario
        $grupo->load('horarios');
        
        $materias = Materia::pluck('nombre', 'id');
        
        $profesores = Profesore::select(
            'id',
            DB::raw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre_completo")
        )->pluck('nombre_completo', 'id');

        return view('grupo.edit', compact('grupo', 'materias', 'profesores'));
    }

    /**
     * Actualiza un grupo Y SUS HORARIOS (CON VALIDACIÓN DE PROFESOR).
     */
    public function update(GrupoRequest $request, Grupo $grupo): RedirectResponse
    {
        // 1. Obtenemos los datos validados
        $datosValidados = $request->validated();

        $profesor_id = $datosValidados['profesor_id'];
        $horarios_nuevos = $datosValidados['horarios'] ?? [];

        // ==========================================================
        // 2. NUEVA VALIDACIÓN DE EMPALME (excluyendo este mismo grupo)
        // ==========================================================
        if ($profesor_id && !empty($horarios_nuevos)) {
            // Pasamos el ID del grupo actual para excluirlo de la comprobación
            $conflicto = $this->validarHorarioProfesor($profesor_id, $horarios_nuevos, $grupo->id);
            
            if ($conflicto) {
                return Redirect::back()
                    ->with('error', "¡Empalme de horario para el profesor! Ya tiene una clase el {$conflicto['dia_semana']} de {$conflicto['hora_inicio']} a {$conflicto['hora_fin']}.")
                    ->withInput();
            }
        }
        // --- FIN DE LA VALIDACIÓN ---

        // 8. Actualizamos los datos principales del grupo
        $grupo->update([
            'nombre' => $datosValidados['nombre'],
            'materia_id' => $datosValidados['materia_id'],
            'profesor_id' => $datosValidados['profesor_id'],
        ]);

        // 9. Sincronizamos los horarios: Borramos los viejos y creamos los nuevos
        $grupo->horarios()->delete(); 

        if ($request->has('horarios')) {
            foreach ($datosValidados['horarios'] as $horarioData) {
                // Creamos los nuevos horarios
                $grupo->horarios()->create($horarioData);
            }
        }

        return Redirect::route('grupos.index')
            ->with('success', 'Grupo actualizado exitosamente con sus horarios.');
    }

    /**
     * Elimina un grupo.
     */
    public function destroy(Grupo $grupo): RedirectResponse
    {
        $grupo->delete();

        return Redirect::route('grupos.index')
            ->with('success', 'Grupo eliminado exitosamente.');
    }

    /**
     * ==================================================================
     * FUNCIÓN HELPER PRIVADA PARA VALIDAR HORARIOS DE PROFESOR
     * ==================================================================
     */
    private function validarHorarioProfesor($profesor_id, $horarios_nuevos, $excluir_grupo_id = null)
    {
        // 1. Obtener TODOS los IDs de los OTROS grupos de este profesor
        $query = Grupo::where('profesor_id', $profesor_id);

        if ($excluir_grupo_id !== null) {
            $query->where('id', '!=', $excluir_grupo_id);
        }
        
        $grupos_del_profesor = $query->pluck('id');

        if ($grupos_del_profesor->isEmpty()) {
            return false; // No tiene otros grupos, no puede haber conflicto
        }

        // 2. Obtener TODOS los horarios existentes de esos OTROS grupos
        $horarios_existentes = Horario::whereIn('grupo_id', $grupos_del_profesor)->get();

        // 3. Comparar cada horario nuevo con cada horario existente
        foreach ($horarios_nuevos as $horario_nuevo) {
            if (!isset($horario_nuevo['dia_semana']) || !isset($horario_nuevo['hora_inicio']) || !isset($horario_nuevo['hora_fin'])) {
                continue;
            }

            foreach ($horarios_existentes as $horario_existente) {
                
                // A. ¿Mismo día?
                if ($horario_nuevo['dia_semana'] == $horario_existente->dia_semana) {
                    
                    // B. ¿Empalme de hora? (InicioA < FinB) Y (FinA > InicioB)
                    $empalme = ($horario_nuevo['hora_inicio'] < $horario_existente->hora_fin) &&
                               ($horario_nuevo['hora_fin'] > $horario_existente->hora_inicio);

                    if ($empalme) {
                        // ¡Conflicto!
                        return [
                            'dia_semana' => ucfirst($horario_existente->dia_semana),
                            'hora_inicio' => date('H:i', strtotime($horario_existente->hora_inicio)),
                            'hora_fin' => date('H:i', strtotime($horario_existente->hora_fin)),
                        ];
                    }
                }
            }
        }

        return false; // No se encontraron conflictos
    }
}

