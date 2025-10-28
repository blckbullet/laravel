<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlumnoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Se obtiene el ID del alumno de la ruta, si existe (para el caso de 'update')
        $alumnoId = $this->route('alumno') ? $this->route('alumno')->matricula : null;

        return [
            // LA REGLA DE MATRÍCULA SE HA ELIMINADO PORQUE SE AUTOGENERA
            'nombre' => 'required|string|max:50',
            'segundo_nombre' => 'nullable|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            // La regla 'unique' ignora el registro actual al momento de editar para evitar conflictos.
            'correo' => ['required', 'string', 'email', 'max:100', Rule::unique('alumnos')->ignore($alumnoId, 'matricula')],
            'telefono' => 'nullable|string|max:20',
            'carrera_id' => 'required|exists:carreras,id',
            'semestre_actual' => 'nullable|integer|min:1|max:12',
            'es_egresado' => 'required|boolean',
        ];
    }
}

