<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProcedimientoController extends Controller
{
    /**
     * Muestra la vista con los botones de procedimientos.
     */
    public function index(): View
    {
        return view('procedimientos.index');
    }

    // --- Procedimiento 1 ---
    public function showProc1Form(): View
    {
        $carreras = Carrera::orderBy('nombre')->get();
        $tipos_materia = DB::table('historiales')->distinct()->pluck('tipo');
        return view('procedimientos.proc1-form', compact('carreras', 'tipos_materia'));
    }

    public function runProc1(Request $request)
    {
        $request->validate([
            'tipo_materia' => 'required|string',
            'nombre_carrera' => 'required|string',
        ]);

        $tipo_materia = $request->input('tipo_materia');
        $nombre_carrera = $request->input('nombre_carrera');

        $resultados = DB::table('alumnos as a')
            ->join('historiales as h', 'a.matricula', '=', 'h.alumno_matricula')
            ->join('materias as m', 'h.materia_id', '=', 'm.id')
            ->join('carreras as c', 'm.carrera_id', '=', 'c.id')
            ->where('h.tipo', $tipo_materia)
            ->where('c.nombre', $nombre_carrera)
            ->select(
                DB::raw("CONCAT(a.nombre, ' ', COALESCE(a.segundo_nombre, ''), ' ', a.apellido_paterno, ' ', a.apellido_materno) AS nombre_completo"),
                'a.matricula',
                'h.semestre',
                'h.tipo',
                'c.nombre as nombre_carrera'
            )
            ->selectRaw('COUNT(m.id) as total_materias')
            ->groupBy('a.matricula', 'a.nombre', 'a.segundo_nombre', 'a.apellido_paterno', 'a.apellido_materno', 'h.semestre', 'h.tipo', 'c.nombre')
            ->get();

        return view('procedimientos.proc1-results', compact('resultados', 'tipo_materia', 'nombre_carrera'));
    }


    // --- Procedimiento 2 ---
    public function showProc2Form(): View
{   
    $grupos = Grupo::with('materia')->orderBy('nombre')->get();


 return view('procedimientos.proc2-form', compact('grupos'));
 }

    public function runProc2(Request $request)
    {
        $request->validate(['nombre_grupo' => 'required|string']);
        $nombre_grupo = $request->input('nombre_grupo');

        $resultados = DB::table('alumnos as a')
            ->join('historiales as h', 'a.matricula', '=', 'h.alumno_matricula')
            ->join('materias as m', 'h.materia_id', '=', 'm.id')
            ->join('grupos as g', 'm.id', '=', 'g.materia_id')
            ->join('profesores as p', 'g.profesor_id', '=', 'p.id')
            ->join('carreras as c', 'a.carrera_id', '=', 'c.id')
            ->where('g.nombre', $nombre_grupo)
            ->select(
                DB::raw("CONCAT(a.nombre, ' ', COALESCE(a.segundo_nombre, ''), ' ', a.apellido_paterno, ' ', a.apellido_materno) AS nombre_completo"),
                'a.matricula',
                'h.tipo as oportunidad',
                'g.nombre as nombre_grupo',
                'm.nombre as nombre_materia',
                'c.nombre as nombre_carrera',
                DB::raw("CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS nombre_profesor")
            )
            ->distinct()
            ->get();

        return view('procedimientos.proc2-results', compact('resultados', 'nombre_grupo'));
    }

    // --- Procedimiento 3 ---
    public function showProc3Form(): View
    {
        $alumnos = Alumno::orderBy('apellido_paterno')->get();
        return view('procedimientos.proc3-form', compact('alumnos'));
    }

    public function runProc3(Request $request)
    {
        $request->validate(['matricula_alumno' => 'required|string|exists:alumnos,matricula']);
        $matricula_alumno = $request->input('matricula_alumno');

        $alumno = Alumno::find($matricula_alumno);

        $resultados = DB::table('historiales as h')
            ->join('materias as m', 'h.materia_id', '=', 'm.id')
            ->leftJoin('grupos as g', 'm.id', '=', 'g.materia_id')
            ->leftJoin('profesores as p', 'g.profesor_id', '=', 'p.id')
            ->where('h.alumno_matricula', $matricula_alumno)
            ->select(
                'm.nombre as nombre_materia',
                'g.nombre as nombre_grupo',
                'h.semestre',
                'h.tipo as oportunidad',
                'h.año as anio',
                'h.calificacion',
                DB::raw("COALESCE(CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno), 'Sin profesor asignado') AS nombre_profesor")
            )
            ->orderBy('h.año')
            ->orderBy('h.semestre')
            ->get();

        return view('procedimientos.proc3-results', compact('resultados', 'alumno'));
    }

    // --- Procedimiento 4 ---
    public function runProc4()
    {
        try {
            $resultados = DB::table('grupos as g')
                ->join('profesores as p', 'g.profesor_id', '=', 'p.id')
                ->join('historiales as h', 'g.materia_id', '=', 'h.materia_id')
                ->select(
                    'p.id as numero_trabajador',
                    DB::raw("CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) as nombre_profesor"),
                    'g.nombre as nombre_grupo',
                    DB::raw('COUNT(DISTINCT h.alumno_matricula) as cantidad_alumnos')
                )
                ->groupBy('g.id', 'g.nombre', 'p.id', 'p.nombre', 'p.apellido_paterno', 'p.apellido_materno')
                ->orderBy('nombre_profesor')
                ->orderBy('nombre_grupo')
                ->get();

            return view('procedimientos.proc4-results', compact('resultados'));

        } catch (\Exception $e) {
            Log::error('Error al ejecutar Procedimiento 4: ' . $e->getMessage());
            return redirect()->route('procedimientos.index')->with('error', 'Ocurrió un error al generar el reporte.');
        }
    }

    // --- Procedimiento 5 ---
    public function runProc5()
    {
        try {
            $resultados = DB::table('alumnos as a')
                ->join('historiales as h', 'a.matricula', '=', 'h.alumno_matricula')
                ->join('carreras as c', 'a.carrera_id', '=', 'c.id')
                ->select(
                    'a.matricula',
                    DB::raw("CONCAT(a.nombre, ' ', COALESCE(a.segundo_nombre, ''), ' ', a.apellido_paterno, ' ', a.apellido_materno) AS nombre_completo"),
                    'c.nombre as nombre_carrera',
                    DB::raw('AVG(h.calificacion) AS promedio')
                )
                ->groupBy('a.matricula', 'a.nombre', 'a.segundo_nombre', 'a.apellido_paterno', 'a.apellido_materno', 'c.nombre')
                ->orderBy('nombre_carrera', 'asc') // <-- CAMBIO AQUÍ
                ->orderBy('promedio', 'desc')
                ->get();

            return view('procedimientos.proc5-results', compact('resultados'));

        } catch (\Exception $e) {
            Log::error('Error al ejecutar Procedimiento 5: ' . $e->getMessage());
            return redirect()->route('procedimientos.index')->with('error', 'Ocurrió un error al generar el reporte de promedios.');
        }
    }
}

