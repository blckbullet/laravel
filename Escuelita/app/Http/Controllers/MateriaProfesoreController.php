<?php

namespace App\Http\Controllers;

use App\Models\MateriaProfesore;
use App\Models\Materia;    // 1. Importar el modelo Materia
use App\Models\Profesore;  // 2. Importar el modelo Profesore
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MateriaProfesoreRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MateriaProfesoreController extends Controller
{
    /**
     * Muestra la lista de asignaciones.
     */
    public function index(Request $request): View
    {
        // 3. Cargar relaciones para mostrar los nombres en la tabla
        $materiaProfesores = MateriaProfesore::with('materia', 'profesore')->paginate();

        return view('materia-profesore.index', compact('materiaProfesores'))
            ->with('i', ($request->input('page', 1) - 1) * $materiaProfesores->perPage());
    }

    /**
     * Muestra el formulario para crear una nueva asignación.
     */
     public function create(): View
    {
        $materiaProfesore = new MateriaProfesore();
        $materias = Materia::pluck('nombre', 'id');

        // ==========================================================
        // CORRECCIÓN AQUÍ: Construimos el nombre completo
        // ==========================================================
        $profesores = Profesore::select(
            'id',
            DB::raw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre_completo")
        )->pluck('nombre_completo', 'id');
        // ==========================================================

        return view('materia-profesore.create', compact('materiaProfesore', 'materias', 'profesores'));
    }

    /**
     * Guarda la nueva asignación.
     */
    public function store(MateriaProfesoreRequest $request): RedirectResponse
    {
        MateriaProfesore::create($request->validated());

        return Redirect::route('materia-profesores.index')
            ->with('success', 'Asignación creada exitosamente.'); // Mensaje en español
    }

    /**
     * Muestra una asignación (generalmente no es necesario, pero se deja por consistencia).
     */
    public function show(MateriaProfesore $materiaProfesore): View // 5. Usando Route-Model Binding
    {
        return view('materia-profesore.show', compact('materiaProfesore'));
    }

    /**
     * Muestra el formulario para editar una asignación.
     */
    public function edit(MateriaProfesore $materiaProfesore): View // 5. Usando Route-Model Binding
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

        return view('materia-profesore.edit', compact('materiaProfesore', 'materias', 'profesores'));
    }


    /**
     * Actualiza una asignación.
     */
    public function update(MateriaProfesoreRequest $request, MateriaProfesore $materiaProfesore): RedirectResponse
    {
        $materiaProfesore->update($request->validated());

        return Redirect::route('materia-profesores.index')
            ->with('success', 'Asignación actualizada exitosamente.'); // Mensaje en español
    }

    /**
     * Elimina una asignación.
     */
    public function destroy(MateriaProfesore $materiaProfesore): RedirectResponse // 5. Usando Route-Model Binding
    {
        $materiaProfesore->delete();

        return Redirect::route('materia-profesores.index')
            ->with('success', 'Asignación eliminada exitosamente.'); // Mensaje en español
    }
}