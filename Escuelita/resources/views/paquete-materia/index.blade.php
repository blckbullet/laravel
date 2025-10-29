@extends('layouts.app')

@section('template_title')
    Materias por Paquete
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">

            {{-- Encabezado --}}
            <div class="d-flex justify-content-between align-items-center my-4">
                <h1 class="mb-0">Gestión de Materias por Paquete</h1>
                <a href="{{ route('paquete-materias.create') }}" class="btn btn-primary-custom">
                    <i class="fas fa-plus me-1"></i> Asignar Nueva Materia
                </a>
            </div>

            {{-- Barra de Búsqueda --}}
            <div class="card shadow border-0 mb-4">
                <div class="card-body">
                    <form action="{{ route('paquete-materias.index') }}" method="GET" class="row g-3 align-items-center">
                        <div class="col-md">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Buscar por Paquete o Materia..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <button type="submit" class.btn btn-info">Buscar</button>
                            @if(request('search'))
                                <a href="{{ route('paquete-materias.index') }}" class="btn btn-secondary">Limpiar</a>
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
                                    <th>Paquete</th>
                                    <th>Materia</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($paqueteMaterias as $paqueteMateria)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $paqueteMateria->paquete->nombre ?? 'N/A' }}</td>
                                        <td>{{ $paqueteMateria->materia->nombre ?? 'N/A' }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('paquete-materias.destroy', $paqueteMateria->id) }}" method="POST">
                                                <a class="btn btn-sm btn-icon btn-info" href="{{ route('paquete-materias.show', $paqueteMateria->id) }}" data-bs-toggle="tooltip" title="Mostrar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-icon btn-success" href="{{ route('paquete-materias.edit', $paqueteMateria->id) }}" data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" title="Borrar"
                                                        onclick="return confirm('¿Seguro que quieres quitar esta materia del paquete?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <i class="fas fa-exclamation-circle fa-4x text-muted mb-3"></i>
                                            <h4 class="text-muted">No hay materias asignadas a paquetes todavía.</h4>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($paqueteMaterias->count() > 0)
                <div class="card-footer d-flex justify-content-end">
                    {!! $paqueteMaterias->withQueryString()->links() !!}
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