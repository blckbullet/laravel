<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistorialeRequest extends FormRequest
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
    return [
        'alumno_matricula' => 'required|string|exists:alumnos,matricula',
        'materia_id' => 'required|integer|exists:materias,id',
        
        
        'calificacion' => 'nullable|numeric|min:0|max:10',
        
        'semestre' => 'required|integer',
        'año' => 'required|integer',
    ];
}
}
