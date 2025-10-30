@php
    // Necesitamos Carbon para formatear las horas
    use Carbon\Carbon;
@endphp

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
                    
                    <h3 class="font-weight-bold">
                        Grupo: {{ $grupo->nombre }}
                    </h3>
                    
                    <hr>

                    <dl class="row mt-4">
                        <dt class="col-sm-4">Materia:</dt>
                        <dd class="col-sm-8">{{ $grupo->materia->nombre ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Profesor:</dt>
                        <dd class="col-sm-8">
                            @if($grupo->profesor)
                                {{ $grupo->profesor->nombre }} {{ $grupo->profesor->apellido_paterno }} {{ $grupo->profesor->apellido_materno ?? '' }}
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </dd>

                        {{-- ================== SECCIÓN DE HORARIOS ================== --}}
                        <dt class="col-sm-12 mt-3 mb-2 h5 border-top pt-3">Horarios Asignados</dt>

                        @if($grupo->horarios->isNotEmpty())
                            <dd class="col-sm-12">
                                <ul class="list-group">
                                @foreach ($grupo->horarios as $horario)
                                    <li class="list-group-item d-flex justify-content-between align-items-center" style="text-transform: capitalize;">
                                        <span>
                                            <i class="fas fa-calendar-day me-2 text-primary"></i>
                                            {{ $horario->dia_semana }}
                                        </span>
                                        <span>
                                            <i class="fas fa-clock me-2 text-primary"></i>
                                            {{ Carbon::parse($horario->hora_inicio)->format('h:i A') }} - 
                                            {{ Carbon::parse($horario->hora_fin)->format('h:i A') }}
                                        </span>
                                    </li>
                                @endforeach
                                </ul>
                            </dd>
                        @else
                            <dd class="col-sm-12">
                                <p class="text-muted">Este grupo aún no tiene horarios asignados.</p>
                            </dd>
                        @endif
                        {{-- ======================================================== --}}
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

