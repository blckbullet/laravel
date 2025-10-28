<div class="row">
    <div class="col-md-12">
        <div class="form-floating mb-3">
            <select name="paquete_id" class="form-select @error('paquete_id') is-invalid @enderror" id="paquete_id">
                <option value="">-- Seleccione un Paquete --</option>
                @foreach($paquetes as $id => $nombre)
                    <option value="{{ $id }}" {{ old('paquete_id', $paqueteMateria?->paquete_id) == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
            <label for="paquete_id"><i class="fas fa-box-open me-2"></i>Paquete</label>
            @error('paquete_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <select name="materia_id" class="form-select @error('materia_id') is-invalid @enderror" id="materia_id">
                <option value="">-- Seleccione una Materia --</option>
                @foreach($materias as $id => $nombre)
                    <option value="{{ $id }}" {{ old('materia_id', $paqueteMateria?->materia_id) == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
            <label for="materia_id"><i class="fas fa-book me-2"></i>Materia a asignar</label>
            @error('materia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

{{-- Botones de Acción --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('paquete-materias.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-times me-1"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary-custom">
        <i class="fas fa-save me-1"></i> Guardar Asignación
    </button>
</div>