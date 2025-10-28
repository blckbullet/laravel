<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MateriaRequest extends FormRequest
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
            'nombre' => 'required|string|max:150',
            'creditos' => 'required|integer',
            'semestre_optimo' => 'required|integer',
            'carrera_id' => 'required|integer|exists:carreras,id',
            'prerequisito_id' => 'nullable|integer|exists:materias,id', // 'nullable' permite que sea opcional
        ];
    }
}
