@extends('layouts.app')

@section('template_title')
    Asignación de Materias
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">

            {{-- Encabezado --}}
            <div class="d-flex justify-content-between align-items-center my-4">
                <h1 class="mb-0">Gestión de Asignaciones</h1>
                <a href="{{ route('materia-profesores.create') }}" class="btn btn-primary-custom">
                    <i class="fas fa-plus me-1"></i> Crear Nueva Asignación
                </a>
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
                                    <th>Profesor</th>
                                    <th>Materia</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($materiaProfesores as $materiaProfesore)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $materiaProfesore->profesore->nombre ?? 'N/A' }} {{ $materiaProfesore->profesore->apellido_paterno ?? '' }}</td>
                                        <td>{{ $materiaProfesore->materia->nombre ?? 'N/A' }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('materia-profesores.destroy', $materiaProfesore->id) }}" method="POST">
                                                <a class="btn btn-sm btn-icon btn-info" href="{{ route('materia-profesores.show', $materiaProfesore->id) }}" data-bs-toggle="tooltip" title="Mostrar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-icon btn-success" href="{{ route('materia-profesores.edit', $materiaProfesore->id) }}" data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" title="Borrar"
                                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta asignación?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <i class="fas fa-exclamation-circle fa-4x text-muted mb-3"></i>
                                            <h4 class="text-muted">No hay asignaciones registradas todavía.</h4>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($materiaProfesores->count() > 0)
                <div class="card-footer d-flex justify-content-end">
                    {!! $materiaProfesores->withQueryString()->links() !!}
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