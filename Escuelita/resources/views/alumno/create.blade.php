@extends('layouts.app')

@section('template_title')
    Registrar Alumno
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            {{-- Encabezado --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Registrar Nuevo Alumno</h1>
                <a class="btn btn-outline-secondary" href="{{ route('alumnos.index') }}">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
            </div>

            {{-- Tarjeta con el formulario --}}
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('alumnos.store') }}" role="form" enctype="multipart/form-data">
                        @csrf
                        @include('alumno.form')
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection