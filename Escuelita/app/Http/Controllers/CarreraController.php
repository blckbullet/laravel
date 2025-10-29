<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CarreraRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\Area;


class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $carreras = Carrera::when($search, function ($query, $search) {
                return $query->where('nombre', 'like', "%{$search}%");
            })
            ->paginate();

        return view('carrera.index', compact('carreras'))
            ->with('i', ($request->input('page', 1) - 1) * $carreras->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $carrera = new Carrera();
        $areas = Area::all(); // <-- 2. Obtén todas las áreas de la base de datos

        // 3. Pasa la variable $areas a la vista
        return view('carrera.create', compact('carrera', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarreraRequest $request): RedirectResponse
    {
        Carrera::create($request->validated());

        return Redirect::route('carreras.index')
            ->with('success', 'Carrera created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $carrera = Carrera::find($id);

        return view('carrera.show', compact('carrera'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carrera $carrera) // Usando Route Model Binding
    {
        $areas = Area::all(); // <-- También necesitas las áreas aquí

        return view('carrera.edit', compact('carrera', 'areas'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(CarreraRequest $request, Carrera $carrera): RedirectResponse
    {
        $carrera->update($request->validated());

        return Redirect::route('carreras.index')
            ->with('success', 'Carrera updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Carrera::find($id)->delete();

        return Redirect::route('carreras.index')
            ->with('success', 'Carrera deleted successfully');
    }
}
