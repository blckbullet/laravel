{{-- Muestra errores de validación (¡importante para los horarios!) --}}
@if ($errors->any())
    <div class="alert alert-danger" style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 1rem; border-radius: 0.25rem; margin-bottom: 1rem;">
        <strong>¡Error de Validación!</strong> Por favor, corrige los siguientes problemas:<br><br>
        <ul style="margin-bottom: 0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="form-floating mb-3">
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $grupo?->nombre) }}" id="nombre" placeholder="Ej: A, B, C1">
            <label for="nombre"><i class="fas fa-users me-2"></i>Nombre del Grupo</label>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <select name="materia_id" class="form-select @error('materia_id') is-invalid @enderror" id="materia_id">
                <option value="">-- Seleccione una Materia --</option>
                @foreach($materias as $id => $nombre)
                    <option value="{{ $id }}" {{ old('materia_id', $grupo?->materia_id) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                @endforeach
            </select>
            <label for="materia_id"><i class="fas fa-book me-2"></i>Materia</label>
            @error('materia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-floating mb-3">
            <select name="profesor_id" class="form-select @error('profesor_id') is-invalid @enderror" id="profesor_id">
                <option value="">-- Seleccione un Profesor --</option>
                @foreach($profesores as $id => $nombre_completo)
                    <option value="{{ $id }}" {{ old('profesor_id', $grupo?->profesor_id) == $id ? 'selected' : '' }}>
                        {{ $nombre_completo }}
                    </option>
                @endforeach
            </select>
            <label for="profesor_id"><i class="fas fa-chalkboard-teacher me-2"></i>Profesor Asignado</label>
            @error('profesor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

{{-- ======================================================= --}}
{{--             SECCIÓN DE HORARIOS (NUEVO)                 --}}
{{-- ======================================================= --}}
<hr class="my-4">

<h4>Horarios del Grupo</h4>
<div id="horarios-container" class="mb-3">
    
    {{-- 
      Aquí cargamos los horarios existentes (si estamos editando) 
      o los que fallaron en la validación (si estamos creando).
    --}}
    @php
        // Usamos old() para recuperar datos de validación fallida, 
        // o $grupo->horarios para 'edit', o un array vacío para 'create'.
        $horarios = old('horarios', $grupo->horarios ?? []);
    @endphp

    @foreach($horarios as $index => $horario)
        {{-- Convertimos a array si es un objeto (en el 'edit') --}}
        @php $horario = (array) $horario; @endphp 
        
        <div class="row align-items-end horario-row mb-2">
            <div class="col-md-4">
                <label class="form-label" style="font-size: 0.875rem;">Día de la Semana</label>
                <select name="horarios[{{ $index }}][dia_semana]" class="form-select">
                    <option value="lunes" {{ ($horario['dia_semana'] ?? '') == 'lunes' ? 'selected' : '' }}>Lunes</option>
                    <option value="martes" {{ ($horario['dia_semana'] ?? '') == 'martes' ? 'selected' : '' }}>Martes</option>
                    <option value="miercoles" {{ ($horario['dia_semana'] ?? '') == 'miercoles' ? 'selected' : '' }}>Miércoles</option>
                    <option value="jueves" {{ ($horario['dia_semana'] ?? '') == 'jueves' ? 'selected' : '' }}>Jueves</option>
                    <option value="viernes" {{ ($horario['dia_semana'] ?? '') == 'viernes' ? 'selected' : '' }}>Viernes</option>
                    <option value="sabado" {{ ($horario['dia_semana'] ?? '') == 'sabado' ? 'selected' : '' }}>Sábado</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size: 0.875rem;">Hora Inicio</label>
                <input type="time" name="horarios[{{ $index }}][hora_inicio]" class="form-control" value="{{ $horario['hora_inicio'] ?? '' }}">
            </div>
            <div class="col-md-3">
                <label class="form-label" style="font-size: 0.875rem;">Hora Fin</label>
                <input type="time" name="horarios[{{ $index }}][hora_fin]" class="form-control" value="{{ $horario['hora_fin'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-horario" style="width: 100%;">Eliminar</button>
            </div>
        </div>
    @endforeach
</div>

{{-- Botón para añadir nuevas filas de horario --}}
<button type="button" id="add-horario" class="btn btn-success mt-2">
    <i class="fas fa-plus me-1"></i> Añadir Horario
</button>
{{-- ======================================================= --}}
{{--         FIN DE LA SECCIÓN DE HORARIOS (NUEVO)           --}}
{{-- ======================================================= --}}


{{-- Botones de Acción --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('grupos.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-times me-1"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary-custom">
        <i class="fas fa-save me-1"></i> Guardar
    </button>
</div>


{{-- 
  Esta es la plantilla invisible que usará JavaScript para crear nuevas filas.
  Fíjate en el `__INDEX__` que será reemplazado.
--}}
<template id="horario-template">
    <div class="row align-items-end horario-row mb-2">
        <div class="col-md-4">
            <label class="form-label" style="font-size: 0.875rem;">Día de la Semana</label>
            <select name="horarios[__INDEX__][dia_semana]" class="form-select">
                <option value="lunes">Lunes</option>
                <option value="martes">Martes</option>
                <option value="miercoles">Miércoles</option>
                <option value="jueves">Jueves</option>
                <option value="viernes">Viernes</option>
                <option value="sabado">Sábado</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label" style="font-size: 0.875rem;">Hora Inicio</label>
            <input type="time" name="horarios[__INDEX__][hora_inicio]" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label" style="font-size: 0.875rem;">Hora Fin</label>
            <input type="time" name="horarios[__INDEX__][hora_fin]" class="form-control">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-horario" style="width: 100%;">Eliminar</button>
        </div>
    </div>
</template>


{{-- JAVASCRIPT PARA AÑADIR/QUITAR --}}
{{-- Movido aquí para asegurar la carga sin depender de @push --}}
<script>
    // Espera a que todo el HTML esté cargado
    document.addEventListener('DOMContentLoaded', function () {
        
        // Obtenemos los elementos principales
        const container = document.getElementById('horarios-container');
        const addButton = document.getElementById('add-horario');
        const template = document.getElementById('horario-template');
        
        // Verificamos si los elementos existen (para depuración)
        if (!container || !addButton || !template) {
            console.error('Error: No se encontraron los elementos del DOM (container, addButton, o template). Revisa los ID.');
            return;
        } else {
            console.log('Script de horarios cargado. Elementos encontrados.');
        }
        
        // Empezamos el índice después del último que ya exista (por si hay errores de validación o es 'edit')
        let horarioIndex = {{ count($horarios) }};

        // Al hacer clic en "Añadir Horario"
        addButton.addEventListener('click', function () {
            // Log para depuración. ¡Revisa la consola F12!
            console.log('¡Botón Añadir Horario presionado! Índice actual:', horarioIndex);

            // 1. Clonamos la plantilla
            const newRowFragment = template.content.cloneNode(true);
            
            // 2. Obtenemos la fila (el div principal)
            const newRowDiv = newRowFragment.firstElementChild;
            
            if (!newRowDiv) {
                console.error('Error: La plantilla está vacía o mal formada.');
                return;
            }

            // 3. Reemplazamos el placeholder __INDEX__ en todos los 'name'
            newRowDiv.querySelectorAll('[name*="__INDEX__"]').forEach(el => {
                el.name = el.name.replace(/__INDEX__/g, horarioIndex);
            });

            // 4. Añadimos la nueva fila clonada al contenedor
            container.appendChild(newRowDiv);
            
            horarioIndex++; // Incrementamos el índice para la próxima fila
        });

        // Event listener para los botones "Eliminar" (usando delegación de eventos)
        container.addEventListener('click', function (e) {
            // Verificamos si el clic fue en un botón de eliminar
            if (e.target && e.target.classList.contains('remove-horario')) {
                // Encontramos el 'horario-row' padre y lo eliminamos
                e.target.closest('.horario-row').remove();
            }
        });
    });
</script>

