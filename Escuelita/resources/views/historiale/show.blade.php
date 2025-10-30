@php
    // Necesitamos Carbon para formatear las horas
    use Carbon\Carbon;
@endphp

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
                        @if ($historiale->calificacion === null)
                            <span class="badge bg-warning text-dark fs-4 me-2">
                                En Curso
                            </span>
                        @else
                            <span class="badge badge-calificacion-{{ $historiale->calificacion >= 6.0 ? 'aprobado' : 'reprobado' }} fs-4 me-2">
                                {{ number_format($historiale->calificacion, 2) }}
                            </span>
                        @endif
                        
                        {{ $historiale->materia->nombre ?? 'N/A' }}
                    </h3>
                    <p class="text-muted">
                        Para el alumno: <strong>{{ $historiale->alumno->nombre ?? 'N/A' }} {{ $historiale->alumno->apellido_paterno ?? '' }}</strong>
                        ({{ $historiale->alumno->matricula ?? 'N/A' }})
                    </p>
                    
                    <hr>

                    <dl class="row mt-4">
                        <dt class="col-sm-4">Periodo Cursado:</dt>
                        <dd class="col-sm-8">{{ $historiale->semestre }}° Semestre, Año {{ $historiale->año }}</dd>

                        <dt class="col-sm-4">Tipo de Calificación:</dt>
                        <dd class="col-sm-8">{{ $historiale->tipo }}</dd>
                        
                        {{-- ================== NUEVA SECCIÓN ================== --}}
                        <dt class="col-sm-12 mt-3 mb-2 h5 border-top pt-3">Datos del Grupo</dt>
                        
                        <dt class="col-sm-4">Grupo:</dt>
                        <dd class="col-sm-8">{{ $historiale->grupo->nombre ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Profesor:</dt>
                        <dd class="col-sm-8">
                            @if($historiale->grupo && $historiale->grupo->profesor)
                                {{ $historiale->grupo->profesor->nombre }} {{ $historiale->grupo->profesor->apellido_paterno }}
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Horarios:</dt>
                        <dd class="col-sm-8">
                            @if($historiale->grupo && $historiale->grupo->horarios->isNotEmpty())
                                <ul class="list-unstyled mb-0">
                                @foreach ($historiale->grupo->horarios as $horario)
                                    <li style="text-transform: capitalize;">
                                        <i class="fas fa-calendar-day me-1 text-muted"></i>
                                        {{ $horario->dia_semana }}: 
                                        <i class="fas fa-clock me-1 text-muted"></i>
                                        {{ Carbon::parse($horario->hora_inicio)->format('H:i') }} - 
                                        {{ Carbon::parse($horario->hora_fin)->format('H:i') }}
                                    </li>
                                @endforeach
                                </ul>
                            @else
                                <span class="text-muted">Sin horario</span>
                            @endif
                        </dd>
                        {{-- ================================================= --}}
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

