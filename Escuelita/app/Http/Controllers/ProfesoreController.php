<?php

namespace App\Http\Controllers;

use App\Models\Profesore;
use App\Models\Area; // 1. ¡IMPORTANTE! Importar el modelo Area
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProfesoreRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfesoreController extends Controller
{
    /**
     * Muestra la lista de profesores.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $profesores = Profesore::with('area')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('correo', 'like', "%{$search}%")
                      ->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE ?", ["%{$search}%"]);
                });
            })
            ->paginate();

        return view('profesore.index', compact('profesores'))
            ->with('i', ($request->input('page', 1) - 1) * $profesores->perPage());
    }

    /**
     * Muestra el formulario para crear un nuevo profesor.
     */
    public function create(): View
    {
        $profesore = new Profesore();
        // 3. Obtener la lista de áreas para la lista desplegable
        $areas = Area::pluck('nombre', 'id'); 

        return view('profesore.create', compact('profesore', 'areas'));
    }

    /**
     * Guarda el nuevo profesor en la base de datos.
     */
    public function store(ProfesoreRequest $request): RedirectResponse
    {
        Profesore::create($request->validated());

        return Redirect::route('profesores.index')
            ->with('success', 'Profesor creado exitosamente.'); // Mensaje en español
    }

    /**
     * Muestra un profesor específico.
     */
    public function show(Profesore $profesore): View // 4. Usando Route-Model Binding
    {
        return view('profesore.show', compact('profesore'));
    }

    /**
     * Muestra el formulario para editar un profesor.
     */
    public function edit(Profesore $profesore): View // 4. Usando Route-Model Binding
    {
        // 5. También necesitamos la lista de áreas para el formulario de edición
        $areas = Area::pluck('nombre', 'id');

        return view('profesore.edit', compact('profesore', 'areas'));
    }

    /**
     * Actualiza un profesor en la base de datos.
     */
    public function update(ProfesoreRequest $request, Profesore $profesore): RedirectResponse
    {
        $profesore->update($request->validated());

        return Redirect::route('profesores.index')
            ->with('success', 'Profesor actualizado exitosamente.'); // Mensaje en español
    }

    /**
     * Elimina un profesor.
     */
    public function destroy(Profesore $profesore): RedirectResponse // 4. Usando Route-Model Binding
    {
        $profesore->delete();

        return Redirect::route('profesores.index')
            ->with('success', 'Profesor eliminado exitosamente.'); // Mensaje en español
    }
}