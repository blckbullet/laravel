<div class="row">
    <div class="col-md-12">
        <div class="form-floating mb-3">
            <select name="profesor_id" class="form-select @error('profesor_id') is-invalid @enderror" id="profesor_id">
                <option value="">-- Seleccione un Profesor --</option>
                @foreach($profesores as $id => $nombre_completo)
                    <option value="{{ $id }}" {{ old('profesor_id', $materiaProfesore?->profesor_id) == $id ? 'selected' : '' }}>
                        {{ $nombre_completo }}
                    </option>
                @endforeach
            </select>
            <label for="profesor_id"><i class="fas fa-chalkboard-teacher me-2"></i>Profesor</label>
            @error('profesor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <select name="materia_id" class="form-select @error('materia_id') is-invalid @enderror" id="materia_id">
                <option value="">-- Seleccione una Materia --</option>
                @foreach($materias as $id => $nombre)
                    <option value="{{ $id }}" {{ old('materia_id', $materiaProfesore?->materia_id) == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
            <label for="materia_id"><i class="fas fa-book me-2"></i>Materia a impartir</label>
            @error('materia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

{{-- Botones de Acción --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('materia-profesores.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-times me-1"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary-custom">
        <i class="fas fa-save me-1"></i> Guardar Asignación
    </button>
</div>