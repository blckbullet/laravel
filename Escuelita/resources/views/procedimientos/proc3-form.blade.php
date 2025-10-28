    @extends('layouts.app')

    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-light">
                        <h4 class="mb-0">Consultar Historial de Alumno</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Selecciona un alumno para ver su historial académico completo.</p>

                        <form action="{{ route('procedimientos.proc3.run') }}" method="POST">
                            @csrf

                            {{-- Campo para seleccionar el Alumno por matrícula --}}
                            <div class="form-floating mb-3">
                                 <select name="matricula_alumno" class="form-select @error('matricula_alumno') is-invalid @enderror" id="matricula_alumno" required>
                                    <option value="">-- Seleccione un Alumno --</option>
                                    @foreach($alumnos as $alumno)
                                        <option value="{{ $alumno->matricula }}" {{ old('matricula_alumno') == $alumno->matricula ? 'selected' : '' }}>
                                            {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}, {{ $alumno->nombre }} ({{ $alumno->matricula }})
                                        </option>
                                    @endforeach
                                </select>
                                <label for="matricula_alumno"><i class="fas fa-user-graduate me-2"></i>Alumno</label>
                                @error('matricula_alumno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('procedimientos.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> Consultar Historial
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    
