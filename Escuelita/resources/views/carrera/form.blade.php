<div class="row">
    <div class="col-md-12">
        <div class="form-floating mb-3">
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $carrera?->nombre) }}" id="nombre" placeholder="Nombre de la Carrera">
            <label for="nombre"><i class="fas fa-graduation-cap me-2"></i>Nombre de la Carrera</label>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-floating mb-3">
            <select name="area_id" class="form-select @error('area_id') is-invalid @enderror" id="area_id" required>
                <option value="">-- Seleccione un Área --</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ old('area_id', $carrera?->area_id) == $area->id ? 'selected' : '' }}>
                        {{ $area->nombre }}
                    </option>
                @endforeach
            </select>
            <label for="area_id"><i class="fas fa-sitemap me-2"></i>Área Académica</label>
            @error('area_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

{{-- Botones de Acción --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('carreras.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-times me-1"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary-custom">
        <i class="fas fa-save me-1"></i> Guardar
    </button>
</div>