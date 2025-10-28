@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Resultados para el Grupo: {{ $nombre_grupo }}</h4>
                        <a href="{{ route('procedimientos.proc2.form') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Nueva Consulta
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($resultados->isNotEmpty())
                        <div class="alert alert-info">
                            <p class="mb-0"><strong>Materia:</strong> {{ $resultados->first()->nombre_materia }}</p>
                            <p class="mb-0"><strong>Profesor:</strong> {{ $resultados->first()->nombre_profesor }}</p>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nombre Completo del Alumno</th>
                                    <th>Matrícula</th>
                                    <th>Carrera</th>
                                    <th>Oportunidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($resultados as $resultado)
                                    <tr>
                                        <td>{{ $resultado->nombre_completo }}</td>
                                        <td><span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">{{ $resultado->matricula }}</span></td>
                                        <td>{{ $resultado->nombre_carrera }}</td>
                                        <td><span class="badge bg-info-subtle text-info-emphasis">{{ $resultado->oportunidad }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <p class="mb-0">No se encontraron alumnos para el grupo seleccionado.</p>
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
