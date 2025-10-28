    <?php
    
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\AreaController;
    use App\Http\Controllers\CarreraController;
    use App\Http\Controllers\ProfesoreController;
    use App\Http\Controllers\MateriaController;
    use App\Http\Controllers\PaqueteController;
    use App\Http\Controllers\GrupoController;
    use App\Http\Controllers\AlumnoController;
    use App\Http\Controllers\HistorialeController;
    use App\Http\Controllers\MateriaProfesoreController;
    use App\Http\Controllers\PaqueteMateriaController;
    use App\Http\Controllers\ProcedimientoController;
    
 
    
    Route::get('/', function () {
        return redirect()->route('login');
    });
    
    Auth::routes();
    
    Route::middleware(['auth'])->group(function () {
        
        Route::get('/home', [HomeController::class, 'index'])->name('home');
    
        
        Route::resource('areas', AreaController::class);
        Route::resource('carreras', CarreraController::class);
        Route::resource('profesores', ProfesoreController::class);
        Route::resource('materias', MateriaController::class);
        Route::resource('paquetes', PaqueteController::class);
        Route::resource('grupos', GrupoController::class);
        Route::resource('alumnos', AlumnoController::class);
        Route::resource('historiales', HistorialeController::class);
        Route::resource('materia-profesores', MateriaProfesoreController::class);
        Route::resource('paquete-materias', PaqueteMateriaController::class);
    
        // Rutas para Procedimientos y Consultas
        Route::prefix('procedimientos')->name('procedimientos.')->group(function () {
            Route::get('/', [ProcedimientoController::class, 'index'])->name('index');
    
            // Proc 1: Consultar Materias por Alumno
            Route::get('/consulta-materias-alumno', [ProcedimientoController::class, 'showProc1Form'])->name('proc1.form');
            Route::post('/consulta-materias-alumno', [ProcedimientoController::class, 'runProc1'])->name('proc1.run');
    
            // Proc 2: Consultar Alumnos por Grupo
            Route::get('/consulta-alumnos-grupo', [ProcedimientoController::class, 'showProc2Form'])->name('proc2.form');
            Route::post('/consulta-alumnos-grupo', [ProcedimientoController::class, 'runProc2'])->name('proc2.run');
    
            // Proc 3: Consultar Historial por Matrícula
            Route::get('/consulta-historial-alumno', [ProcedimientoController::class, 'showProc3Form'])->name('proc3.form');
            Route::post('/consulta-historial-alumno', [ProcedimientoController::class, 'runProc3'])->name('proc3.run');
            
            // Proc 4: Reporte de Alumnos por Profesor/Grupo
            Route::post('/reporte-alumnos-grupo', [ProcedimientoController::class, 'runProc4'])->name('proc4.run');
    
            // Proc 5: Reporte de Promedios por Alumno
            Route::post('/reporte-promedios', [ProcedimientoController::class, 'runProc5'])->name('proc5.run');
        });
    });
    

