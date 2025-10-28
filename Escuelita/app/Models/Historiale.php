<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Historiale
 *
 * @property $alumno_matricula
 * @property $materia_id
 * @property $calificacion
 * @property $semestre
 * @property $año
 * @property $tipo
 *
 * @property Alumno $alumno
 * @property Materia $materia
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Historiale extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['alumno_matricula', 'materia_id', 'calificacion', 'semestre', 'año', 'tipo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alumno()
    {
        return $this->belongsTo(\App\Models\Alumno::class, 'alumno_matricula', 'matricula');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materia()
    {
        return $this->belongsTo(\App\Models\Materia::class, 'materia_id', 'id');
    }
    
}
