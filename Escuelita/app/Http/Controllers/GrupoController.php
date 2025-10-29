<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Materia;    // 1. Importar el modelo Materia
use App\Models\Profesore;  // 2. Importar el modelo Profesore
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\GrupoRequest;
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

        // ==========================================================
        // CORRECCIÓN AQUÍ: Construimos el nombre completo del profesor
        // ==========================================================
        $profesores = Profesore::select(
            'id',
            DB::raw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre_completo")
        )->pluck('nombre_completo', 'id');
        // ==========================================================

        return view('grupo.create', compact('grupo', 'materias', 'profesores'));
    }

    /**
     * Guarda el nuevo grupo.
     */
    public function store(GrupoRequest $request): RedirectResponse
    {
        Grupo::create($request->validated());

        return Redirect::route('grupos.index')
            ->with('success', 'Grupo creado exitosamente.'); // Mensaje en español
    }

    /**
     * Muestra un grupo específico.
     */
    public function show(Grupo $grupo): View // 5. Usando Route-Model Binding
    {
        return view('grupo.show', compact('grupo'));
    }

    /**
     * Muestra el formulario para editar un grupo.
     */
    public function edit(Grupo $grupo): View // 5. Usando Route-Model Binding
    {
        $materias = Materia::pluck('nombre', 'id');
        
        // ==========================================================
        // APLICA EL MISMO CAMBIO AQUÍ
        // ==========================================================
        $profesores = Profesore::select(
            'id',
            DB::raw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre_completo")
        )->pluck('nombre_completo', 'id');
        // ==========================================================

        return view('grupo.edit', compact('grupo', 'materias', 'profesores'));
    }

    /**
     * Actualiza un grupo.
     */
    public function update(GrupoRequest $request, Grupo $grupo): RedirectResponse
    {
        $grupo->update($request->validated());

        return Redirect::route('grupos.index')
            ->with('success', 'Grupo actualizado exitosamente.'); // Mensaje en español
    }

    /**
     * Elimina un grupo.
     */
    public function destroy(Grupo $grupo): RedirectResponse // 5. Usando Route-Model Binding
    {
        $grupo->delete();

        return Redirect::route('grupos.index')
            ->with('success', 'Grupo eliminado exitosamente.'); // Mensaje en español
    }
}