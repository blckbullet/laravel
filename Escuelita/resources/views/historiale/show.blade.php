@extends('layouts.app')

@section('template_title')
    Detalles del Registro
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-custom text-black">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Detalles del Registro</h2>
                        <a class="btn btn-light btn-sm" href="{{ route('historiales.index') }}">
                             <i class="fas fa-arrow-left me-1"></i> Volver al listado
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <h3 class="font-weight-bold">
                        <span class="badge badge-calificacion-{{ $historiale->calificacion >= 7 ? 'aprobado' : 'reprobado' }} fs-4 me-2">
                            {{ number_format($historiale->calificacion, 2) }}
                        </span>
                        {{ $historiale->materia->nombre ?? 'N/A' }}
                    </h3>
                    <p class="text-muted">
                        Para el alumno: <strong>{{ $historiale->alumno->nombre ?? 'N/A' }} {{ $historiale->alumno->apellido_paterno ?? '' }}</strong>
                    </p>
                    
                    <hr>

                    <dl class="row mt-4">
                        <dt class="col-sm-4">Periodo Cursado:</dt>
                        <dd class="col-sm-8">{{ $historiale->semestre }}° Semestre, Año {{ $historiale->año }}</dd>

                        <dt class="col-sm-4">Tipo de Calificación:</dt>
                        <dd class="col-sm-8">{{ $historiale->tipo }}</dd>
                    </dl>
                </div>

                <div class="card-footer text-end">
                     <a class="btn btn-success" href="{{ route('historiales.edit', $historiale->id) }}">
                        <i class="fas fa-edit me-1"></i> Editar Registro
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection