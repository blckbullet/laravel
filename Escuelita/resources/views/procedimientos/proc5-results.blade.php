    @extends('layouts.app')
    
    @section('template_title')
        Reporte de Promedios por Alumno
    @endsection
    
    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Reporte de Promedios Generales por Alumno</h4>
                            <a href="{{ route('procedimientos.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Volver al Panel
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            Este reporte muestra el promedio general de calificaciones para cada alumno.
                        </p>
    
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Matrícula</th>
                                        <th>Nombre Completo</th>
                                        <th>Carrera</th>
                                        <th>Promedio General</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($resultados as $resultado)
                                        <tr>
                                            <td><span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">{{ $resultado->matricula }}</span></td>
                                            <td>{{ $resultado->nombre_completo }}</td>
                                            <td>{{ $resultado->nombre_carrera }}</td>
                                            <td><span class="badge bg-success">{{ number_format($resultado->promedio, 2) }}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <p class="mb-0">No se encontraron datos para generar el reporte de promedios.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    
