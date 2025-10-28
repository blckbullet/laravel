<div class="row">
    <div class="col-md-12">
        <div class="form-floating mb-3">
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $paquete?->nombre) }}" id="nombre" placeholder="Nombre del Paquete">
            <label for="nombre"><i class="fas fa-box-open me-2"></i>Nombre del Paquete</label>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

{{-- Botones de Acción --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('paquetes.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-times me-1"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary-custom">
        <i class="fas fa-save me-1"></i> Guardar
    </button>
</div>