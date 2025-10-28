<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Profesore
 *
 * @property $id
 * @property $nombre
 * @property $apellido_paterno
 * @property $apellido_materno
 * @property $correo
 * @property $telefono
 * @property $area_id
 *
 * @property Area $area
 * @property Grupo[] $grupos
 * @property MateriaProfesor[] $materiaProfesors
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Profesore extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'apellido_paterno', 'apellido_materno', 'correo', 'telefono', 'area_id'];


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
    public function grupos()
    {
        return $this->hasMany(\App\Models\Grupo::class, 'id', 'profesor_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materiaProfesors()
    {
        return $this->hasMany(\App\Models\MateriaProfesor::class, 'id', 'profesor_id');
    }
    
}
