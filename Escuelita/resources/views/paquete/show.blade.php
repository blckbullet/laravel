@extends('layouts.app')

@section('template_title')
    Detalles del Paquete
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary-custom text-black">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Detalles del Paquete</h2>
                        <a class="btn btn-light btn-sm" href="{{ route('paquetes.index') }}">
                             <i class="fas fa-arrow-left me-1"></i> Volver al listado
                        </a>
                    </div>
                </div>

                <div class="card-body text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h3 class="font-weight-bold">{{ $paquete->nombre }}</h3>
                </div>

                <div class="card-footer text-end">
                     <a class="btn btn-success" href="{{ route('paquetes.edit', $paquete->id) }}">
                        <i class="fas fa-edit me-1"></i> Editar Paquete
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection