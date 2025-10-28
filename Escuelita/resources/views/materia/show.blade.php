@extends('layouts.app')

@section('template_title')
    Detalles de la Materia
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-custom text-black">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Detalles de la Materia</h2>
                        <a class="btn btn-light btn-sm" href="{{ route('materias.index') }}">
                             <i class="fas fa-arrow-left me-1"></i> Volver al listado
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <h3 class="font-weight-bold">{{ $materia->nombre }}</h3>
                    <p class="text-muted">
                        {{ $materia->creditos }} créditos | Semestre Óptimo: {{ $materia->semestre_optimo }}°
                    </p>
                    
                    <hr>

                    <dl class="row mt-4">
                        <dt class="col-sm-4">Carrera:</dt>
                        <dd class="col-sm-8">{{ $materia->carrera->nombre ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Prerrequisito:</dt>
                        <dd class="col-sm-8">{{ $materia->prerequisito->nombre ?? 'Ninguno' }}</dd>
                    </dl>
                </div>

                <div class="card-footer text-end">
                     <a class="btn btn-success" href="{{ route('materias.edit', $materia->id) }}">
                        <i class="fas fa-edit me-1"></i> Editar Materia
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection