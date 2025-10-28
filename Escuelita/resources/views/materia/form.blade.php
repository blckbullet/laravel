<div class="row">
    {{-- Columna Izquierda --}}
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $materia?->nombre) }}" id="nombre" placeholder="Nombre de la Materia">
            <label for="nombre"><i class="fas fa-book me-2"></i>Nombre de la Materia</label>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="number" name="creditos" class="form-control @error('creditos') is-invalid @enderror" value="{{ old('creditos', $materia?->creditos) }}" id="creditos" placeholder="Créditos">
            <label for="creditos"><i class="fas fa-coins me-2"></i>Créditos</label>
            @error('creditos') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="number" name="semestre_optimo" class="form-control @error('semestre_optimo') is-invalid @enderror" value="{{ old('semestre_optimo', $materia?->semestre_optimo) }}" id="semestre_optimo" placeholder="Semestre Óptimo">
            <label for="semestre_optimo"><i class="fas fa-calendar-alt me-2"></i>Semestre Óptimo</label>
            @error('semestre_optimo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    {{-- Columna Derecha --}}
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <select name="carrera_id" class="form-select @error('carrera_id') is-invalid @enderror" id="carrera_id">
                <option value="">-- Seleccione una Carrera --</option>
                @foreach($carreras as $id => $nombre)
                    <option value="{{ $id }}" {{ old('carrera_id', $materia?->carrera_id) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                @endforeach
            </select>
            <label for="carrera_id"><i class="fas fa-graduation-cap me-2"></i>Carrera</label>
            @error('carrera_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <select name="prerequisito_id" class="form-select @error('prerequisito_id') is-invalid @enderror" id="prerequisito_id">
                <option value="">-- Ninguno --</option>
                @foreach($materias_disponibles as $id => $nombre)
                    <option value="{{ $id }}" {{ old('prerequisito_id', $materia?->prerequisito_id) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                @endforeach
            </select>
            <label for="prerequisito_id"><i class="fas fa-link me-2"></i>Prerrequisito (Opcional)</label>
            @error('prerequisito_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

{{-- Botones de Acción --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('materias.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-times me-1"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary-custom">
        <i class="fas fa-save me-1"></i> Guardar
    </button>
</div>