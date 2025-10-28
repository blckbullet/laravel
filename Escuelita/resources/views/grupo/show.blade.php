@extends('layouts.app')

@section('template_title')
    Detalles del Grupo
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-custom text-black">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Detalles del Grupo</h2>
                        <a class="btn btn-light btn-sm" href="{{ route('grupos.index') }}">
                             <i class="fas fa-arrow-left me-1"></i> Volver al listado
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <h3 class="font-weight-bold">Grupo: {{ $grupo->nombre }}</h3>
                    
                    <hr>

                    <dl class="row mt-4">
                        <dt class="col-sm-4">Materia:</dt>
                        <dd class="col-sm-8">{{ $grupo->materia->nombre ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Profesor Asignado:</dt>
                        <dd class="col-sm-8">{{ $grupo->profesor->nombre ?? 'N/A' }} {{ $grupo->profesor->apellido_paterno ?? '' }}</dd>
                    </dl>
                </div>

                <div class="card-footer text-end">
                     <a class="btn btn-success" href="{{ route('grupos.edit', $grupo->id) }}">
                        <i class="fas fa-edit me-1"></i> Editar Grupo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection