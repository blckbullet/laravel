@extends('layouts.app')

@section('template_title')
    Alumnos Activos
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">

            <div class="d-flex justify-content-between align-items-center mb-4">
                {{-- CAMBIO: Título ajustado para claridad --}}
                <h1 class="mb-0">Gestión de Alumnos Activos</h1> 
                <a href="{{ route('alumnos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Registrar Nuevo Alumno
                </a>
            </div>

            <div class="card shadow border-0">
                <div class="card-body">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <p>{{ $message }}</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Matrícula</th>
                                    <th>Nombre Completo</th>
                                    <th>Carrera</th>
                                    <th>Semestre</th>
                                    <th>Estatus</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($alumnos as $alumno)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td><span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">{{ $alumno->matricula }}</span></td>
                                        
                                        <td>{{ implode(' ', array_filter([$alumno->nombre, $alumno->segundo_nombre, $alumno->apellido_paterno, $alumno->apellido_materno])) }}</td>
                                        
                                        <td>{{ $alumno->carrera->nombre ?? 'N/A' }}</td>
                                        
                                        <td>{{ $alumno->semestre_actual ?? 'N/A' }}</td>
                                        
                                        <td>
                                            {{-- Esta lógica sigue siendo útil por si acaso --}}
                                            @if ($alumno->es_egresado)
                                                <span class="badge bg-success">Egresado</span>
                                            @else
                                                <span class="badge bg-secondary">Activo</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-sm btn-outline-info" href="{{ route('alumnos.show', $alumno) }}" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('alumnos.edit', $alumno) }}" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                {{-- ============================================= --}}
                                                {{-- CAMBIO: Botón, ícono y confirmación           --}}
                                                {{-- ============================================= --}}
                                                <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Marcar como Egresado"
                                                            onclick="return confirm('¿Estás seguro de que deseas marcar a este alumno como egresado? El alumno se ocultará de esta lista.')">
                                                        <i class="fas fa-user-graduate"></i> {{-- Ícono cambiado --}}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="mb-0">No hay alumnos activos registrados.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($alumnos->count() > 0)
                <div class="card-footer d-flex justify-content-end">
                    {!! $alumnos->withQueryString()->links() !!}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
