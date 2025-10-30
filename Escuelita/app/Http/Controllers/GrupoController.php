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
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class GrupoController extends Controller
{
    /**
     * Muestra la lista de grupos.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $grupos = Grupo::with('materia', 'profesor')
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
     * Guarda el nuevo grupo Y SUS HORARIOS.
     */
    public function store(GrupoRequest $request): RedirectResponse
    {
        // 3. Obtenemos los datos validados del GrupoRequest
        $datosValidados = $request->validated();

        // 4. Creamos el Grupo primero
        $grupo = Grupo::create([
            'nombre' => $datosValidados['nombre'],
            'materia_id' => $datosValidados['materia_id'],
            'profesor_id' => $datosValidados['profesor_id'],
        ]);

        // 5. Guardamos los horarios asociados (si se enviaron)
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
     * Actualiza un grupo Y SUS HORARIOS.
     */
    public function update(GrupoRequest $request, Grupo $grupo): RedirectResponse
    {
        // 7. Obtenemos los datos validados
        $datosValidados = $request->validated();

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
}
