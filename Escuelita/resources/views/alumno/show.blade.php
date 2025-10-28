@extends('layouts.app')

@section('template_title')
    Detalles del Alumno
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Tarjeta de Perfil del Alumno --}}
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-custom text-black">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Detalles del Alumno</h2>
                        <a class="btn btn-light btn-sm" href="{{ route('alumnos.index') }}">
                             <i class="fas fa-arrow-left me-1"></i> Volver al listado
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row align-items-center">
                        {{-- Sección de Avatar --}}
                        <div class="col-md-3 text-center mb-4 mb-md-0">
                            <i class="fas fa-user-graduate fa-6x text-muted"></i>
                        </div>
                        {{-- Sección de Datos Principales --}}
                        <div class="col-md-9">
                            {{-- ============================================= --}}
                            {{-- CAMPO MODIFICADO: Nombre Completo           --}}
                            {{-- ============================================= --}}
                            <h3 class="font-weight-bold">{{ implode(' ', array_filter([$alumno->nombre, $alumno->segundo_nombre, $alumno->apellido_paterno, $alumno->apellido_materno])) }}</h3>
                            <p class="text-muted mb-2">
                                <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill fs-6">{{ $alumno->matricula }}</span>
                            </p>
                            <p>
                                @if ($alumno->es_egresado)
                                    <span class="badge badge-status-egresado">Egresado</span>
                                @else
                                    <span class="badge badge-status-activo">Activo</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <hr>

                    {{-- Lista de Detalles --}}
                    <dl class="row mt-4">
                        <dt class="col-sm-4">Carrera:</dt>
                        <dd class="col-sm-8">{{ $alumno->carrera->nombre ?? 'N/A' }}</dd>
                        <dt class="col-sm-4">Semestre Actual:</dt>
                        <dd class="col-sm-8">{{ $alumno->semestre_actual ?? 'No especificado' }}</dd>


                        <dt class="col-sm-4">Correo Electrónico:</dt>
                        <dd class="col-sm-8"><a href="mailto:{{ $alumno->correo }}">{{ $alumno->correo }}</a></dd>

                        <dt class="col-sm-4">Teléfono:</dt>
                        <dd class="col-sm-8">{{ $alumno->telefono ?? 'No especificado' }}</dd>
                    </dl>
                </div>

                <div class="card-footer text-end">
                       <a class="btn btn-success" href="{{ route('alumnos.edit', $alumno) }}">
                            <i class="fas fa-edit me-1"></i> Editar Alumno
                       </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
