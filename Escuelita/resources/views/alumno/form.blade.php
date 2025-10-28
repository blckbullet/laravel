<div class="row">
    {{-- ============================================= --}}
    {{-- Columna Izquierda (Datos Personales)          --}}
    {{-- ============================================= --}}
    <div class="col-md-6">
        
        {{-- =============================================================== --}}
        {{-- CAMPO MODIFICADO: La matrícula ahora se muestra siempre, pero   --}}
        {{-- es de solo lectura para evitar que el usuario la modifique.     --}}
        {{-- =============================================================== --}}
        <div class="form-floating mb-3">
            <input type="text" name="matricula" class="form-control" value="{{ old('matricula', $alumno?->matricula) }}" id="matricula" readonly>
            <label for="matricula"><i class="fas fa-id-card me-2"></i>Matrícula Asignada</label>
        </div>
        
        <div class="form-floating mb-3">
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $alumno?->nombre) }}" id="nombre" placeholder="Nombre del alumno">
            <label for="nombre"><i class="fas fa-user me-2"></i>Nombre</label>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="segundo_nombre" class="form-control @error('segundo_nombre') is-invalid @enderror" value="{{ old('segundo_nombre', $alumno?->segundo_nombre) }}" id="segundo_nombre" placeholder="Segundo Nombre (Opcional)">
            <label for="segundo_nombre"><i class="fas fa-user me-2"></i>Segundo Nombre (Opcional)</label>
            @error('segundo_nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="apellido_paterno" class="form-control @error('apellido_paterno') is-invalid @enderror" value="{{ old('apellido_paterno', $alumno?->apellido_paterno) }}" id="apellido_paterno" placeholder="Apellido Paterno">
            <label for="apellido_paterno"><i class="fas fa-user me-2"></i>Apellido Paterno</label>
            @error('apellido_paterno') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="apellido_materno" class="form-control @error('apellido_materno') is-invalid @enderror" value="{{ old('apellido_materno', $alumno?->apellido_materno) }}" id="apellido_materno" placeholder="Apellido Materno">
            <label for="apellido_materno"><i class="fas fa-user me-2"></i>Apellido Materno</label>
            @error('apellido_materno') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- Columna Derecha (Datos de Contacto y Académicos) --}}
    {{-- ============================================= --}}
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo', $alumno?->correo) }}" id="correo" placeholder="Correo Electrónico">
            <label for="correo"><i class="fas fa-envelope me-2"></i>Correo Electrónico</label>
            @error('correo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $alumno?->telefono) }}" id="telefono" placeholder="Teléfono">
            <label for="telefono"><i class="fas fa-phone me-2"></i>Teléfono</label>
            @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <select name="carrera_id" class="form-select @error('carrera_id') is-invalid @enderror" id="carrera_id">
                <option value="">-- Seleccione una Carrera --</option>
                @foreach($carreras as $id => $nombre)
                    <option value="{{ $id }}" {{ old('carrera_id', $alumno?->carrera_id) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                @endforeach
            </select>
            <label for="carrera_id"><i class="fas fa-graduation-cap me-2"></i>Carrera</label>
            @error('carrera_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="number" name="semestre_actual" class="form-control @error('semestre_actual') is-invalid @enderror" value="{{ old('semestre_actual', $alumno?->semestre_actual) }}" id="semestre_actual" placeholder="Semestre Actual">
            <label for="semestre_actual"><i class="fas fa-book-open me-2"></i>Semestre Actual</label>
            @error('semestre_actual') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <select name="es_egresado" class="form-select @error('es_egresado') is-invalid @enderror" id="es_egresado">
                <option value="0" {{ old('es_egresado', $alumno?->es_egresado) == '0' ? 'selected' : '' }}>Activo</option>
                <option value="1" {{ old('es_egresado', $alumno?->es_egresado) == '1' ? 'selected' : '' }}>Egresado</option>
            </select>
            <label for="es_egresado"><i class="fas fa-check-circle me-2"></i>Estatus</label>
            @error('es_egresado') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

{{-- Botones de Acción --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('alumnos.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-times me-1"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save me-1"></i> Guardar Cambios
    </button>
</div>

