<?php

namespace App\Http\Controllers;

use App\Models\PaqueteMateria;
use App\Models\Paquete; // 1. Importar Paquete
use App\Models\Materia; // 2. Importar Materia
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PaqueteMateriaRequest; // Asegúrate de que este archivo exista
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PaqueteMateriaController extends Controller
{
    public function index(Request $request): View
    {
        // 3. Cargar relaciones para mostrar nombres
        $paqueteMaterias = PaqueteMateria::with('paquete', 'materia')->paginate();

        return view('paquete-materia.index', compact('paqueteMaterias'))
            ->with('i', ($request->input('page', 1) - 1) * $paqueteMaterias->perPage());
    }

    public function create(): View
    {
        $paqueteMateria = new PaqueteMateria();
        // 4. Obtener datos para las listas desplegables
        $paquetes = Paquete::pluck('nombre', 'id');
        $materias = Materia::pluck('nombre', 'id');

        return view('paquete-materia.create', compact('paqueteMateria', 'paquetes', 'materias'));
    }

    public function store(PaqueteMateriaRequest $request): RedirectResponse
    {
        PaqueteMateria::create($request->validated());
        return Redirect::route('paquete-materias.index')
            ->with('success', 'Materia asignada al paquete exitosamente.');
    }

    public function show(PaqueteMateria $paqueteMateria): View
    {
        return view('paquete-materia.show', compact('paqueteMateria'));
    }

    public function edit(PaqueteMateria $paqueteMateria): View
    {
        $paquetes = Paquete::pluck('nombre', 'id');
        $materias = Materia::pluck('nombre', 'id');

        return view('paquete-materia.edit', compact('paqueteMateria', 'paquetes', 'materias'));
    }

    public function update(PaqueteMateriaRequest $request, PaqueteMateria $paqueteMateria): RedirectResponse
    {
        $paqueteMateria->update($request->validated());
        return Redirect::route('paquete-materias.index')
            ->with('success', 'Asignación actualizada exitosamente.');
    }

    public function destroy(PaqueteMateria $paqueteMateria): RedirectResponse
    {
        $paqueteMateria->delete();
        return Redirect::route('paquete-materias.index')
            ->with('success', 'Asignación eliminada exitosamente.');
    }
}