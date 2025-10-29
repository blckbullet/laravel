<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Carrera; // 1. Importar el modelo Carrera
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MateriaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MateriaController extends Controller
{
    /**
     * Muestra la lista de materias.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $materias = Materia::with('carrera', 'prerequisito')
            ->when($search, function ($query, $search) {
                return $query->where('nombre', 'like', "%{$search}%");
            })
            ->paginate();

        return view('materia.index', compact('materias'))
            ->with('i', ($request->input('page', 1) - 1) * $materias->perPage());
    }

    /**
     * Muestra el formulario para crear una nueva materia.
     */
    public function create(): View
    {
        $materia = new Materia();
        // 3. Obtener los datos para AMBAS listas desplegables
        $carreras = Carrera::pluck('nombre', 'id');
        $materias_disponibles = Materia::pluck('nombre', 'id'); // Para la lista de prerrequisitos

        return view('materia.create', compact('materia', 'carreras', 'materias_disponibles'));
    }

    /**
     * Guarda la nueva materia.
     */
    public function store(MateriaRequest $request): RedirectResponse
    {
        Materia::create($request->validated());

        return Redirect::route('materias.index')
            ->with('success', 'Materia creada exitosamente.'); // Mensaje en español
    }

    /**
     * Muestra una materia específica.
     */
    public function show(Materia $materia): View // 4. Usando Route-Model Binding
    {
        return view('materia.show', compact('materia'));
    }

    /**
     * Muestra el formulario para editar una materia.
     */
    public function edit(Materia $materia): View // 4. Usando Route-Model Binding
    {
        // 5. También necesitamos los datos de las listas para editar
        $carreras = Carrera::pluck('nombre', 'id');
        // Excluimos la materia actual de la lista de posibles prerrequisitos
        $materias_disponibles = Materia::where('id', '!=', $materia->id)->pluck('nombre', 'id');

        return view('materia.edit', compact('materia', 'carreras', 'materias_disponibles'));
    }

    /**
     * Actualiza una materia.
     */
    public function update(MateriaRequest $request, Materia $materia): RedirectResponse
    {
        $materia->update($request->validated());

        return Redirect::route('materias.index')
            ->with('success', 'Materia actualizada exitosamente.'); // Mensaje en español
    }

    /**
     * Elimina una materia.
     */
    public function destroy(Materia $materia): RedirectResponse // 4. Usando Route-Model Binding
    {
        $materia->delete();

        return Redirect::route('materias.index')
            ->with('success', 'Materia eliminada exitosamente.'); // Mensaje en español
    }

    /**
     * Devuelve las materias de una carrera específica en formato JSON.
     */
    public function getPorCarrera(Carrera $carrera)
    {
        return response()->json($carrera->materias()->get());
    }
}