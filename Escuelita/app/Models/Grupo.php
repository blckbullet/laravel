<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Grupo
 *
 * @property $id
 * @property $nombre
 * @property $materia_id
 * @property $profesor_id
 *
 * @property Materia $materia
 * @property Profesore $profesore
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Grupo extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'materia_id', 'profesor_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materia()
    {
        return $this->belongsTo(\App\Models\Materia::class, 'materia_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profesor()
    {
        return $this->belongsTo(\App\Models\Profesore::class, 'profesor_id', 'id');
    }
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    // RELACIÓN NUEVA: Un grupo puede estar en muchos historiales
    public function historiales()
    {
        return $this->hasMany(Historiale::class);
    }
    
    
}
