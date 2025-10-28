<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Area
 *
 * @property $id
 * @property $nombre
 * @property $descripcion
 * @property $jefe_area
 *
 * @property Carrera[] $carreras
 * @property Profesore[] $profesores
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Area extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'descripcion', 'jefe_area'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carreras()
    {
        return $this->hasMany(\App\Models\Carrera::class, 'id', 'area_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profesores()
    {
        return $this->hasMany(\App\Models\Profesore::class, 'id', 'area_id');
    }
    
}
