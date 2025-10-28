<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Alumno;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AlumnoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        
        $alumnos = Alumno::with('carrera')
                         ->where('es_egresado', false)
                         ->paginate(10);

        return view('alumno.index', compact('alumnos'))
            ->with('i', (request()->input('page', 1) - 1) * $alumnos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $alumno = new Alumno();
        $carreras = Carrera::pluck('nombre', 'id');
        
        $ultimoAlumno = Alumno::orderBy('matricula', 'desc')->first();
        if ($ultimoAlumno) {
            $siguienteMatricula = (int)$ultimoAlumno->matricula + 1;
        } else {
            $siguienteMatricula = 21220501; // Matrícula inicial si no hay alumnos
        }

        $alumno->matricula = (string)$siguienteMatricula;

        return view('alumno.create', compact('alumno', 'carreras'));
    }

   
    public function store(AlumnoRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        $ultimoAlumno = Alumno::orderBy('matricula', 'desc')->first();
        if ($ultimoAlumno) {
            $nuevaMatricula = (int)$ultimoAlumno->matricula + 1;
        } else {
            $nuevaMatricula = 21220501;
        }

        $data['matricula'] = (string)$nuevaMatricula;

        
        Alumno::create($data);

        return Redirect::route('alumnos.index')
            ->with('success', 'Alumno registrado exitosamente con la matrícula: ' . $nuevaMatricula);
    }

    
   
    public function show(Alumno $alumno): View
    {
        return view('alumno.show', compact('alumno'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumno $alumno): View
    {
        $carreras = Carrera::pluck('nombre', 'id');

        return view('alumno.edit', compact('alumno', 'carreras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlumnoRequest $request, Alumno $alumno): RedirectResponse
    {
        $alumno->update($request->validated());

        return Redirect::route('alumnos.index')
            ->with('success', 'Alumno actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * (AHORA MARCA COMO EGRESADO)
     */
    public function destroy(Alumno $alumno): RedirectResponse
    {
        // ==================================================================
        // CAMBIO: En lugar de $alumno->delete(), actualizamos el estatus.
        // ==================================================================
        $alumno->update(['es_egresado' => true]);

        // ==================================================================
        // CAMBIO: Actualizamos el mensaje de éxito.
        // ==================================================================
        return Redirect::route('alumnos.index')
            ->with('success', 'Alumno marcado como egresado exitosamente.');
    }
}
