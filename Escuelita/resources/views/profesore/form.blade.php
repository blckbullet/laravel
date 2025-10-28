<div class="row">
    {{-- Columna Izquierda --}}
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $profesore?->nombre) }}" id="nombre" placeholder="Nombre(s)">
            <label for="nombre"><i class="fas fa-user me-2"></i>Nombre(s)</label>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="apellido_paterno" class="form-control @error('apellido_paterno') is-invalid @enderror" value="{{ old('apellido_paterno', $profesore?->apellido_paterno) }}" id="apellido_paterno" placeholder="Apellido Paterno">
            <label for="apellido_paterno"><i class="fas fa-user me-2"></i>Apellido Paterno</label>
            @error('apellido_paterno') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="apellido_materno" class="form-control @error('apellido_materno') is-invalid @enderror" value="{{ old('apellido_materno', $profesore?->apellido_materno) }}" id="apellido_materno" placeholder="Apellido Materno">
            <label for="apellido_materno"><i class="fas fa-user me-2"></i>Apellido Materno</label>
            @error('apellido_materno') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    {{-- Columna Derecha --}}
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo', $profesore?->correo) }}" id="correo" placeholder="Correo Electrónico">
            <label for="correo"><i class="fas fa-envelope me-2"></i>Correo Electrónico</label>
            @error('correo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $profesore?->telefono) }}" id="telefono" placeholder="Teléfono">
            <label for="telefono"><i class="fas fa-phone me-2"></i>Teléfono</label>
            @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <select name="area_id" class="form-select @error('area_id') is-invalid @enderror" id="area_id">
                <option value="">-- Seleccione un Área --</option>
                @foreach ($areas as $id => $nombre)
                    <option value="{{ $id }}" {{ old('area_id', $profesore?->area_id) == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
            <label for="area_id"><i class="fas fa-building me-2"></i>Área</label>
            @error('area_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

{{-- Botones de Acción --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('profesores.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-times me-1"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary-custom">
        <i class="fas fa-save me-1"></i> Guardar
    </button>
</div>