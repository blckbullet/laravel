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
        Historiale::create($request->validated());
        return Redirect::route('historiales.index')
            ->with('success', 'Registro de historial creado exitosamente.');
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