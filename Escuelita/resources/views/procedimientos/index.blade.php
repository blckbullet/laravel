    @extends('layouts.app')
    
    @section('template_title')
        Panel de Procedimientos
    @endsection
    
    @section('content')
    <div class="container">
        {{-- Encabezado --}}
        <div class="text-center my-5">
            <h1 class="display-5 font-weight-bold">Panel de Procedimientos y Consultas</h1>
            <p class="text-muted">Selecciona una de las tareas administrativas o consultas disponibles.</p>
        </div>
    
        {{-- Alertas de éxito o error --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    
        {{-- Tarjeta con la lista de botones --}}
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-light">
                        <h4 class="mb-0">Lista de Tareas Disponibles</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
    
                            {{-- Consulta 1: Materias por Tipo y Carrera --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h5 class="mb-1">Consultar Materias por Alumno</h5>
                                    <p class="mb-1 text-muted small">Busca alumnos según el tipo de materia (Ordinario, Repite) y su carrera.</p>
                                </div>
                                <a href="{{ route('procedimientos.proc1.form') }}" class="btn btn-primary-custom">
                                    <i class="fas fa-search me-2"></i>Realizar Consulta
                                </a>
                            </li>
    
                            {{-- Consulta 2: Alumnos por Grupo --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h5 class="mb-1">Consultar Alumnos por Grupo</h5>
                                    <p class="mb-1 text-muted small">Muestra un listado de los alumnos inscritos en un grupo específico.</p>
                                </div>
                                <a href="{{ route('procedimientos.proc2.form') }}" class="btn btn-primary-custom">
                                    <i class="fas fa-users me-2"></i>Realizar Consulta
                                </a>
                            </li>
    
                            {{-- Consulta 3: Historial por Matrícula --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h5 class="mb-1">Consultar Historial de Alumno</h5>
                                    <p class="mb-1 text-muted small">Muestra el historial académico completo de un alumno por su matrícula.</p>
                                </div>
                                 <a href="{{ route('procedimientos.proc3.form') }}" class="btn btn-primary-custom">
                                    <i class="fas fa-history me-2"></i>Realizar Consulta
                                </a>
                            </li>
    
                            {{-- Reporte 4: Cantidad de Alumnos por Grupo/Profesor --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h5 class="mb-1">Reporte de Alumnos por Grupo</h5>
                                    <p class="mb-1 text-muted small">Genera un reporte que muestra cuántos alumnos tiene cada profesor en sus grupos.</p>
                                </div>
                                <form action="{{ route('procedimientos.proc4.run') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas generar este reporte?');">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-file-alt me-2"></i>Generar Reporte
                                    </button>
                                </form>
                            </li>
    
                            {{-- Reporte 5: Promedio general por Alumno --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h5 class="mb-1">Reporte de Promedios Generales</h5>
                                    <p class="mb-1 text-muted small">Calcula el promedio general de calificaciones de cada alumno.</p>
                                </div>
                                <form action="{{ route('procedimientos.proc5.run') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas generar este reporte?');">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-chart-bar me-2"></i>Generar Reporte
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                     <div class="card-footer text-end">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Volver al Panel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    

