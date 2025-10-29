@extends('layouts.app')

@section('template_title')
    Profesores
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">

            {{-- Encabezado --}}
            <div class="d-flex justify-content-between align-items-center my-4">
                <h1 class="mb-0">Gestión de Profesores</h1>
                <a href="{{ route('profesores.create') }}" class="btn btn-primary-custom">
                    <i class="fas fa-plus me-1"></i> Registrar Nuevo Profesor
                </a>
            </div>

            {{-- Barra de Búsqueda --}}
            <div class="card shadow border-0 mb-4">
                <div class="card-body">
                    <form action="{{ route('profesores.index') }}" method="GET" class="row g-3 align-items-center">
                        <div class="col-md">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Buscar por Nombre o Correo..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <button type="submit" class="btn btn-info">Buscar</button>
                            @if(request('search'))
                                <a href="{{ route('profesores.index') }}" class="btn btn-secondary">Limpiar</a>
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

            <div class="card shadow-lg border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-white">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre Completo</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Área</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($profesores as $profesore)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $profesore->nombre }} {{ $profesore->apellido_paterno }} {{ $profesore->apellido_materno }}</td>
                                        <td>{{ $profesore->correo }}</td>
                                        <td>{{ $profesore->telefono }}</td>
                                        <td>{{ $profesore->area->nombre ?? 'N/A' }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('profesores.destroy', $profesore->id) }}" method="POST">
                                                <a class="btn btn-sm btn-icon btn-info" href="{{ route('profesores.show', $profesore->id) }}" data-bs-toggle="tooltip" title="Mostrar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-icon btn-success" href="{{ route('profesores.edit', $profesore->id) }}" data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" title="Borrar"
                                                        onclick="return confirm('¿Estás seguro de que deseas eliminar a este profesor?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="fas fa-exclamation-circle fa-4x text-muted mb-3"></i>
                                            <h4 class="text-muted">No hay profesores registrados todavía.</h4>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($profesores->count() > 0)
                <div class="card-footer d-flex justify-content-end">
                    {!! $profesores->withQueryString()->links() !!}
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