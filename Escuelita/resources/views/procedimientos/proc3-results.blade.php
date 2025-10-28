    @extends('layouts.app')

    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Historial Académico</h4>
                            <a href="{{ route('procedimientos.proc3.form') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Nueva Consulta
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($alumno)
                            <div class="alert alert-light border">
                                <h5 class="alert-heading">{{ $alumno->nombre_completo }}</h5>
                                <p class="mb-1"><strong>Matrícula:</strong> {{ $alumno->matricula }}</p>
                                <p class="mb-0"><strong>Carrera:</strong> {{ $alumno->carrera->nombre ?? 'N/A' }}</p>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Materia</th>
                                        <th>Calificación</th>
                                        <th>Periodo</th>
                                        <th>Oportunidad</th>
                                        <th>Profesor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($resultados as $resultado)
                                        <tr>
                                            <td>{{ $resultado->nombre_materia }}</td>
                                            <td>
                                                <span class="badge fs-6 {{ $resultado->calificacion >= 7 ? 'bg-success-subtle text-success-emphasis' : 'bg-danger-subtle text-danger-emphasis' }}">
                                                    {{ number_format($resultado->calificacion, 2) }}
                                                </span>
                                            </td>
                                            <td>{{ $resultado->semestre }}° / {{ $resultado->anio }}</td>
                                            <td>{{ $resultado->oportunidad }}</td>
                                            <td>{{ $resultado->nombre_profesor }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <p class="mb-0">No se encontraron registros en el historial para este alumno.</p>
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
    
