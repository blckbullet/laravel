@extends('layouts.app')

@section('template_title')
    Reporte de Alumnos por Grupo
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Reporte de Alumnos por Profesor y Grupo</h4>
                        <a href="{{ route('procedimientos.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Volver al Panel
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Este reporte muestra la cantidad de alumnos que cada profesor tiene en los grupos que imparte.
                    </p>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th># Trabajador</th>
                                    <th>Nombre del Profesor</th>
                                    <th>Grupo</th>
                                    <th>Cantidad de Alumnos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($resultados as $resultado)
                                    <tr>
                                        <td><span class="badge bg-secondary">{{ $resultado->numero_trabajador }}</span></td>
                                        <td>{{ $resultado->nombre_profesor }}</td>
                                        <td>{{ $resultado->nombre_grupo }}</td>
                                        <td>{{ $resultado->cantidad_alumnos }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <p class="mb-0">No se encontraron resultados para generar el reporte.</p>
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

