<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Carrera
 *
 * @property $id
 * @property $nombre
 * @property $area_id
 *
 * @property Area $area
 * @property Alumno[] $alumnos
 * @property Materia[] $materias
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Carrera extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'area_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(\App\Models\Area::class, 'area_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alumnos()
    {
        return $this->hasMany(\App\Models\Alumno::class, 'id', 'carrera_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materias()
    {
        return $this->hasMany(\App\Models\Materia::class, 'id', 'carrera_id');
    }
    
}
