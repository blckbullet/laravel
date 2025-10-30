<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Asumimos que todos pueden
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Reglas para el grupo
            'nombre' => 'required|string|max:10',
            'materia_id' => 'required|integer|exists:materias,id',
            'profesor_id' => 'required|integer|exists:profesores,id',

            // --- REGLAS NUEVAS PARA LOS HORARIOS ---
            'horarios' => 'nullable|array', // 'horarios' es un array, pero puede estar vacío
            'horarios.*.dia_semana' => 'required_with:horarios|string|in:lunes,martes,miercoles,jueves,viernes,sabado,domingo',
            'horarios.*.hora_inicio' => 'required_with:horarios|date_format:H:i',
            'horarios.*.hora_fin' => 'required_with:horarios|date_format:H:i|after:horarios.*.hora_inicio',
        ];
    }
}
