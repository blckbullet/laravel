@extends('layouts.app')

@section('template_title')
    Detalles de la Carrera
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Tarjeta de Detalles de la Carrera --}}
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-custom text-black">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Detalles de la Carrera</h2>
                        <a class="btn btn-light btn-sm" href="{{ route('carreras.index') }}">
                             <i class="fas fa-arrow-left me-1"></i> Volver al listado
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <h3 class="font-weight-bold">{{ $carrera->nombre }}</h3>
                    
                    <hr>

                    <dl class="row mt-4">
                        <dt class="col-sm-4">Área Académica:</dt>
                        {{-- Es importante mostrar el nombre del área, no el ID --}}
                        <dd class="col-sm-8">{{ $carrera->area->nombre ?? 'N/A' }}</dd>
                    </dl>
                </div>

                <div class="card-footer text-end">
                     <a class="btn btn-success" href="{{ route('carreras.edit', $carrera->id) }}">
                        <i class="fas fa-edit me-1"></i> Editar Carrera
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection