@php
    // Necesitamos Carbon para formatear las horas
    use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('template_title')
    Historial Académico
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">

            {{-- Encabezado --}}
            <div class="d-flex justify-content-between align-items-center my-4">
                <h1 class="mb-0">Historial Académico</h1>
                <a href="{{ route('historiales.create') }}" class="btn btn-primary-custom">
                    <i class="fas fa-plus me-1"></i> Añadir Calificación
                </a>
            </div>

            {{-- Barra de Búsqueda --}}
            <div class="card shadow border-0 mb-4">
                <div class="card-body">
                    <form action="{{ route('historiales.index') }}" method="GET" class="row g-3 align-items-center">
                        <div class="col-md">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Buscar por Matrícula, Alumno o Materia..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <button type="submit" class="btn btn-info">Buscar</button>
                            @if(request('search'))
                                <a href="{{ route('historiales.index') }}" class="btn btn-secondary">Limpiar</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-custom-success alert-dismissible fade show" role="alert">
                    <p class="mb-0">{{ $message }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($message = Session::get('error')) {{-- Añadido para mostrar errores de lógica --}}
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p class="mb-0">{{ $message }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-white">
                                <tr>
                                    <th>#</th>
                                    <th>Matrícula</th>
                                    <th>Alumno</th>
                                    <th>Materia</th>
                                    
                                    {{-- ================== NUEVAS COLUMNAS ================== --}}
                                    <th>Grupo</th>
                                    <th>Profesor</th>
                                    <th>Horario</th>
                                    {{-- =================================================== --}}

                                    <th>Calificación</th>
                                    <th>Periodo</th>
                                    <th>Tipo</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($historiales as $historiale)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td><span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">{{ $historiale->alumno->matricula ?? 'N/A' }}</span></td>
                                        <td>{{ $historiale->alumno->nombre ?? 'N/A' }} {{ $historiale->alumno->apellido_paterno ?? '' }}</td>
                                        <td>{{ $historiale->materia->nombre ?? 'N/A' }}</td>

                                        {{-- ================== NUEVAS CELDAS ================== --}}
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $historiale->grupo->nombre ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($historiale->grupo && $historiale->grupo->profesor)
                                                {{ $historiale->grupo->profesor->nombre }} {{ $historiale->grupo->profesor->apellido_paterno }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td style="min-width: 190px; font-size: 0.9em;">
                                            @if($historiale->grupo && $historiale->grupo->horarios->isNotEmpty())
                                                @foreach ($historiale->grupo->horarios as $horario)
                                                    <span class="d-block" style="text-transform: capitalize;">
                                                        <i class="fas fa-calendar-day me-1 text-muted"></i>
                                                        {{ $horario->dia_semana }}: 
                                                        <i class="fas fa-clock me-1 text-muted"></i>
                                                        {{ Carbon::parse($horario->hora_inicio)->format('H:i') }} - 
                                                        {{ Carbon::parse($horario->hora_fin)->format('H:i') }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">Sin horario</span>
                                            @endif
                                        </td>
                                        {{-- ================================================= --}}

                                        <td>
                                            @if ($historiale->calificacion === null)
                                                <span class="badge bg-warning text-dark">En Curso</span>
                                            @else
                                                <span class="badge badge-calificacion-{{ $historiale->calificacion >= 6.0 ? 'aprobado' : 'reprobado' }}">
                                                    {{ number_format($historiale->calificacion, 2) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $historiale->semestre }}° / {{ $historiale->año }}</td>
                                        <td>{{ $historiale->tipo }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('historiales.destroy', $historiale->id) }}" method="POST">
                                                <a class="btn btn-sm btn-icon btn-info" href="{{ route('historiales.show', $historiale->id) }}" data-bs-toggle="tooltip" title="Mostrar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-icon btn-success" href="{{ route('historiales.edit', $historiale->id) }}" data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" title="Borrar"
                                                        onclick="return confirm('¿Estás seguro de eliminar este registro del historial?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-5"> {{-- Colspan aumentado a 11 --}}
                                            <i class="fas fa-exclamation-circle fa-4x text-muted mb-3"></i>
                                            <h4 class="text-muted">No hay registros en el historial todavía.</h4>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($historiales->count() > 0)
                <div class="card-footer d-flex justify-content-end">
                    {!! $historiales->withQueryString()->links() !!}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Inicializar los tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush

