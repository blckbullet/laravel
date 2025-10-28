@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Resultados de la Consulta</h4>
                        <a href="{{ route('procedimientos.proc1.form') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Nueva Consulta
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Mostrando resultados para el tipo de materia "<strong>{{ $tipo_materia }}</strong>" en la carrera de "<strong>{{ $nombre_carrera }}</strong>".
                    </p>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nombre Completo</th>
                                    <th>Matrícula</th>
                                    <th>Semestre</th>
                                    <th>Tipo</th>
                                    <th>Total de Materias</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($resultados as $resultado)
                                    <tr>
                                        <td>{{ $resultado->nombre_completo }}</td>
                                        <td><span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">{{ $resultado->matricula }}</span></td>
                                        <td>{{ $resultado->semestre }}</td>
                                        <td><span class="badge bg-info-subtle text-info-emphasis">{{ $resultado->tipo }}</span></td>
                                        <td>{{ $resultado->total_materias }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <p class="mb-0">No se encontraron resultados para los criterios seleccionados.</p>
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
