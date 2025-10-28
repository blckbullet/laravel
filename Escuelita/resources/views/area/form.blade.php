<div class="row">
    <div class="col-md-12">
        <div class="form-floating mb-3">
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $area?->nombre) }}" id="nombre" placeholder="Nombre del Área">
            <label for="nombre"><i class="fas fa-building me-2"></i>Nombre del Área</label>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-floating mb-3">
            <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion', $area?->descripcion) }}" id="descripcion" placeholder="Descripción">
            <label for="descripcion"><i class="fas fa-align-left me-2"></i>Descripción</label>
            @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="jefe_area" class="form-control @error('jefe_area') is-invalid @enderror" value="{{ old('jefe_area', $area?->jefe_area) }}" id="jefe_area" placeholder="Jefe de Área">
            <label for="jefe_area"><i class="fas fa-user-tie me-2"></i>Jefe de Área</label>
            @error('jefe_area') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

{{-- Botones de Acción --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('areas.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-times me-1"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary-custom">
        <i class="fas fa-save me-1"></i> Guardar
    </button>
</div>