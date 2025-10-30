{{-- Muestra errores de VALIDACIÓN (Campos vacíos, formato incorrecto, etc.) --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>¡Error de Validación!</strong> Por favor, corrige los siguientes problemas:<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- ====================================================================== --}}
{{-- ▼▼▼ BLOQUE AÑADIDO: Muestra errores de LÓGICA (Empalmes, etc.) ▼▼▼ --}}
{{-- ====================================================================== --}}
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>¡Error de Lógica!</strong>
        <p class="mb-0">{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- ====================================================================== --}}
{{-- ▲▲▲ FIN DEL BLOQUE AÑADIDO ▲▲▲ --}}
{{-- ====================================================================== --}}


{{-- DATOS PRINCIPALES DEL GRUPO --}}
<div class="row">
    <div class="col-md-4 mb-3">
        <label for="nombre" class="form-label">Nombre del Grupo (Ej: 101A)</label>
        <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $grupo?->nombre) }}">
        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="materia_id" class="form-label">Materia</label>
        <select name="materia_id" id="materia_id" class="form-select @error('materia_id') is-invalid @enderror">
            <option value="">-- Seleccione --</option>
            @foreach($materias as $id => $nombre)
                <option value="{{ $id }}" {{ old('materia_id', $grupo?->materia_id) == $id ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
            @endforeach
        </select>
        @error('materia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="profesor_id" class="form-label">Profesor</label>
        <select name="profesor_id" id="profesor_id" class="form-select @error('profesor_id') is-invalid @enderror">
            <option value="">-- Seleccione --</option>
            @foreach($profesores as $id => $nombre)
                <option value="{{ $id }}" {{ old('profesor_id', $grupo?->profesor_id) == $id ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
            @endforeach
        </select>
        @error('profesor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<hr class="my-4">

{{-- SECCIÓN DINÁMICA DE HORARIOS --}}
<h4>Horarios del Grupo</h4>
<div id="horarios-container">
    
    @php
        // Carga los horarios de 'old' (si falló la validación) o del modelo (si es 'edit')
        $horarios = old('horarios', $grupo->horarios->map(function ($horario) {
            // Aseguramos que el formato de hora sea H:i para el input type="time"
            return [
                'dia_semana' => $horario->dia_semana,
                'hora_inicio' => \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i'),
                'hora_fin' => \Carbon\Carbon::parse($horario->hora_fin)->format('H:i'),
            ];
        }) ?? []);
    @endphp

    @foreach($horarios as $index => $horario)
        <div class="row align-items-end horario-row mb-2">
            <div class="col-md-4">
                <label class="form-label">Día de la Semana</label>
                <select name="horarios[{{ $index }}][dia_semana]" class="form-select @error("horarios.{$index}.dia_semana") is-invalid @enderror">
                    <option value="lunes" {{ ($horario['dia_semana'] ?? '') == 'lunes' ? 'selected' : '' }}>Lunes</option>
                    <option value="martes" {{ ($horario['dia_semana'] ?? '') == 'martes' ? 'selected' : '' }}>Martes</option>
                    <option value="miercoles" {{ ($horario['dia_semana'] ?? '') == 'miercoles' ? 'selected' : '' }}>Miércoles</option>
                    <option value="jueves" {{ ($horario['dia_semana'] ?? '') == 'jueves' ? 'selected' : '' }}>Jueves</option>
                    <option value="viernes" {{ ($horario['dia_semana'] ?? '') == 'viernes' ? 'selected' : '' }}>Viernes</option>
                    <option value="sabado" {{ ($horario['dia_semana'] ?? '') == 'sabado' ? 'selected' : '' }}>Sábado</option>
                    <option value="domingo" {{ ($horario['dia_semana'] ?? '') == 'domingo' ? 'selected' : '' }}>Domingo</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Hora Inicio</label>
                <input type="time" name="horarios[{{ $index }}][hora_inicio]" class="form-control @error("horarios.{$index}.hora_inicio") is-invalid @enderror" value="{{ $horario['hora_inicio'] ?? '' }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Hora Fin</label>
                <input type="time" name="horarios[{{ $index }}][hora_fin]" class="form-control @error("horarios.{$index}.hora_fin") is-invalid @enderror" value="{{ $horario['hora_fin'] ?? '' }}">
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

{{-- BOTÓN DE GUARDAR --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('grupos.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar Grupo</button>
</div>


{{-- 
  Esta es la plantilla invisible que usará JavaScript para crear nuevas filas.
  Fíjate en el `__INDEX__` que será reemplazado.
--}}
<template id="horario-template">
    <div class="row align-items-end horario-row mb-2">
        <div class="col-md-4">
            <label class="form-label">Día de la Semana</label>
            <select name="horarios[__INDEX__][dia_semana]" class="form-select">
                <option value="lunes">Lunes</option>
                <option value="martes">Martes</option>
                <option value="miercoles">Miércoles</option>
                <option value="jueves">Jueves</option>
                <option value="viernes">Viernes</option>
                <option value="sabado">Sábado</option>
                <option value="domingo">Domingo</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Hora Inicio</label>
            <input type="time" name="horarios[__INDEX__][hora_inicio]" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Hora Fin</label>
            <input type="time" name="horarios[__INDEX__][hora_fin]" class="form-control">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-horario" style="width: 100%;">Eliminar</button>
        </div>
    </div>
</template>


{{-- JAVASCRIPT PARA AÑADIR/QUITAR --}}
{{-- Puesto directamente aquí para evitar problemas con @push --}}
<script>
    console.log('Script de horarios cargado.'); // Mensaje de depuración

    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('horarios-container');
        const addButton = document.getElementById('add-horario');
        const template = document.getElementById('horario-template');

        // Si alguno de los elementos clave no existe, no continuamos
        if (!container || !addButton || !template) {
            console.error('No se encontraron los elementos del formulario de horarios (container, addButton, o template).');
            return;
        }
        
        // Empezamos el índice después del último que ya exista
        let horarioIndex = {{ count($horarios) }};
        console.log('Índice de horario inicial:', horarioIndex);

        addButton.addEventListener('click', function () {
            console.log('¡Botón Añadir Horario presionado!'); // Mensaje de depuración
            
            // 1. Clonamos el contenido de la plantilla
            const newRowContent = template.content.cloneNode(true);
            
            // 2. Reemplazamos el placeholder __INDEX__ con el índice actual
            // Obtenemos el HTML como string para hacer el reemplazo
            let newRowHTML = newRowContent.firstElementChild.outerHTML;
            newRowHTML = newRowHTML.replace(/__INDEX__/g, horarioIndex);

            // 3. Creamos un div temporal para convertir el string HTML de nuevo a nodos DOM
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newRowHTML;
            const newRowNode = tempDiv.firstElementChild;

            // 4. Añadimos la nueva fila al contenedor
            container.appendChild(newRowNode);
            
            horarioIndex++; // Incrementamos el índice para la próxima fila
            console.log('Nuevo índice de horario:', horarioIndex);
        });

        // Event listener para los botones "Eliminar" (usando delegación de eventos)
        container.addEventListener('click', function (e) {
            // Verificamos que se hizo clic en un botón de eliminar
            if (e.target && e.target.classList.contains('remove-horario')) {
                console.log('Botón Eliminar presionado.');
                // Encontramos el 'horario-row' padre y lo eliminamos
                e.target.closest('.horario-row').remove();
            }
        });
    });
</script>

