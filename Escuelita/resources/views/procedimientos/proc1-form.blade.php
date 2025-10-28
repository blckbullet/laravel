@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Consultar Materias por Alumno</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">Introduce los criterios para buscar a los alumnos.</p>

                    <form action="{{ route('procedimientos.proc1.run') }}" method="POST">
                        @csrf

                        
                        <div class="form-floating mb-3">
                            <select name="tipo_materia" class="form-select @error('tipo_materia') is-invalid @enderror" id="tipo_materia" required>
                                <option value="">-- Seleccione un Tipo --</option>
                                @foreach($tipos_materia as $tipo)
                                    <option value="{{ $tipo }}" {{ old('tipo_materia') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                                @endforeach
                            </select>
                            <label for="tipo_materia"><i class="fas fa-tag me-2"></i>Tipo de Materia</label>
                            @error('tipo_materia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo para Nombre de Carrera --}}
                        <div class="form-floating mb-3">
                             <select name="nombre_carrera" class="form-select @error('nombre_carrera') is-invalid @enderror" id="nombre_carrera" required>
                                <option value="">-- Seleccione una Carrera --</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->nombre }}" {{ old('nombre_carrera') == $carrera->nombre ? 'selected' : '' }}>{{ $carrera->nombre }}</option>
                                @endforeach
                            </select>
                            <label for="nombre_carrera"><i class="fas fa-graduation-cap me-2"></i>Nombre de la Carrera</label>
                            @error('nombre_carrera')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('procedimientos.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Buscar Alumnos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

