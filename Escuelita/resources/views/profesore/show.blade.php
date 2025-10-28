@extends('layouts.app')

@section('template_title')
    Detalles del Profesor
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-custom text-black">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Detalles del Profesor</h2>
                        <a class="btn btn-light btn-sm" href="{{ route('profesores.index') }}">
                             <i class="fas fa-arrow-left me-1"></i> Volver al listado
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row align-items-center">
                        {{-- Sección de Avatar --}}
                        <div class="col-md-3 text-center mb-4 mb-md-0">
                            <i class="fas fa-chalkboard-teacher fa-6x text-muted"></i>
                        </div>
                        {{-- Sección de Datos Principales --}}
                        <div class="col-md-9">
                            <h3 class="font-weight-bold">{{ $profesore->nombre }} {{ $profesore->apellido_paterno }} {{ $profesore->apellido_materno }}</h3>
                            <p class="text-muted mb-2">
                                {{ $profesore->area->nombre ?? 'Área no especificada' }}
                            </p>
                        </div>
                    </div>
                    
                    <hr>

                    {{-- Lista de Detalles --}}
                    <dl class="row mt-4">
                        <dt class="col-sm-4">Correo Electrónico:</dt>
                        <dd class="col-sm-8"><a href="mailto:{{ $profesore->correo }}">{{ $profesore->correo }}</a></dd>

                        <dt class="col-sm-4">Teléfono:</dt>
                        <dd class="col-sm-8">{{ $profesore->telefono ?? 'No especificado' }}</dd>
                    </dl>
                </div>

                <div class="card-footer text-end">
                     <a class="btn btn-success" href="{{ route('profesores.edit', $profesore->id) }}">
                        <i class="fas fa-edit me-1"></i> Editar Profesor
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection