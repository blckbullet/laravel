<div class="row">
    {{-- Columna Izquierda --}}
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <select name="alumno_matricula" class="form-select @error('alumno_matricula') is-invalid @enderror" id="alumno_matricula">
                <option value="">-- Seleccione un Alumno --</option>
                @foreach($alumnos as $matricula => $nombre_completo)
                    <option value="{{ $matricula }}" {{ old('alumno_matricula', $historiale?->alumno_matricula) == $matricula ? 'selected' : '' }}>
                        {{ $nombre_completo }} ({{ $matricula }})
                    </option>
                @endforeach
            </select>
            <label for="alumno_matricula"><i class="fas fa-user-graduate me-2"></i>Alumno</label>
            @error('alumno_matricula') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <select name="materia_id" class="form-select @error('materia_id') is-invalid @enderror" id="materia_id">
                <option value="">-- Seleccione una Materia --</option>
                @foreach($materias as $id => $nombre)
                    <option value="{{ $id }}" {{ old('materia_id', $historiale?->materia_id) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                @endforeach
            </select>
            <label for="materia_id"><i class="fas fa-book me-2"></i>Materia</label>
            @error('materia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="number" step="0.01" name="calificacion" class="form-control @error('calificacion') is-invalid @enderror" value="{{ old('calificacion', $historiale?->calificacion) }}" id="calificacion" placeholder="Ej: 8.50">
            <label for="calificacion"><i class="fas fa-star-half-alt me-2"></i>Calificación</label>
            @error('calificacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    {{-- Columna Derecha --}}
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="number" name="semestre" class="form-control @error('semestre') is-invalid @enderror" value="{{ old('semestre', $historiale?->semestre) }}" id="semestre" placeholder="Ej: 3">
            <label for="semestre"><i class="fas fa-calendar-alt me-2"></i>Semestre Cursado</label>
            @error('semestre')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-floating mb-3">
            <input type="number" name="año" class="form-control @error('año') is-invalid @enderror" value="{{ old('año', $historiale?->año) }}" id="año" placeholder="Ej: 2024">
            <label for="año"><i class="fas fa-calendar-day me-2"></i>Año Cursado</label>
            @error('año')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-floating mb-3">
            <select name="tipo" class="form-select @error('tipo') is-invalid @enderror" id="tipo">
                <option value="Ordinario" {{ old('tipo', $historiale?->tipo) == 'Ordinario' ? 'selected' : '' }}>Ordinario</option>
                <option value="Extraordinario" {{ old('tipo', $historiale?->tipo) == 'Extraordinario' ? 'selected' : '' }}>Extraordinario</option>
                <option value="Título de Suficiencia" {{ old('tipo', $historiale?->tipo) == 'Título de Suficiencia' ? 'selected' : '' }}>Título de Suficiencia</option>
            </select>
            <label for="tipo"><i class="fas fa-tag me-2"></i>Tipo de Calificación</label>
            @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- Botones de Acción --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('historiales.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-times me-1"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary-custom">
        <i class="fas fa-save me-1"></i> Guardar Registro
    </button>
</div>