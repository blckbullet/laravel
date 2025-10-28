@extends('layouts.app')

@section('template_title')
    Detalles de Asignación
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-custom text-black">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Detalles de la Asignación</h2>
                        <a class="btn btn-light btn-sm" href="{{ route('paquete-materias.index') }}">
                             <i class="fas fa-arrow-left me-1"></i> Volver al listado
                        </a>
                    </div>
                </div>

                <div class="card-body text-center">
                    <i class="fas fa-box-open fa-3x text-muted"></i>
                    <h3 class="font-weight-bold mt-3">{{ $paqueteMateria->paquete->nombre ?? 'N/A' }}</h3>
                    
                    <i class="fas fa-link fa-2x text-muted my-3"></i>

                    <i class="fas fa-book fa-3x text-muted"></i>
                    <h3 class="font-weight-bold mt-3">{{ $paqueteMateria->materia->nombre ?? 'N/A' }}</h3>
                </div>

                <div class="card-footer text-end">
                     <a class="btn btn-success" href="{{ route('paquete-materias.edit', $paqueteMateria->id) }}">
                        <i class="fas fa-edit me-1"></i> Editar Asignación
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection