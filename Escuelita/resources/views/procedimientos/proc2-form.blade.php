@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Consultar Alumnos por Grupo</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">Selecciona un grupo para ver la lista de alumnos inscritos.</p>

                    <form action="{{ route('procedimientos.proc2.run') }}" method="POST">
                        @csrf

                        {{-- Campo para seleccionar el Grupo --}}
                        <div class="form-floating mb-3">
                             <select name="nombre_grupo" class="form-select @error('nombre_grupo') is-invalid @enderror" id="nombre_grupo" required>
                                 <option value="">-- Seleccione un Grupo --</option>
                                 @foreach($grupos as $grupo)
                                    
                                    <option value="{{ $grupo->nombre }}" {{ old('nombre_grupo') == $grupo->nombre ? 'selected' : '' }}>
                                        {{ $grupo->nombre }} - {{ $grupo->materia->nombre }}
                                    </option>
                                 @endforeach
                             </select>
                            <label for="nombre_grupo"><i class="fas fa-users me-2"></i>Nombre del Grupo</label>
                            @error('nombre_grupo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('procedimientos.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Consultar Grupo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
