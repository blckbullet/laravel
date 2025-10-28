<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MateriaProfesore
 *
 * @property $profesor_id
 * @property $materia_id
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class MateriaProfesore extends Model
{
    /**
     * ==========================================================
     * AÑADE ESTA LÍNEA PARA CORREGIR EL ERROR
     * Le dice a Laravel que esta tabla no tiene created_at ni updated_at.
     * ==========================================================
     */
    public $timestamps = false;
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['profesor_id', 'materia_id'];

    // Aquí puedes añadir las relaciones si las necesitas
    public function materia()
    {
        return $this->belongsTo(\App\Models\Materia::class, 'materia_id', 'id');
    }
    
    public function profesore()
    {
        return $this->belongsTo(\App\Models\Profesore::class, 'profesor_id', 'id');
    }
}