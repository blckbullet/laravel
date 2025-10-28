<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Materia
 *
 * @property $id
 * @property $nombre
 * @property $creditos
 * @property $semestre_optimo
 * @property $carrera_id
 * @property $prerequisito_id
 *
 * @property Carrera $carrera
 * @property Materia $materia
 * @property Grupo[] $grupos
 * @property Historiale[] $historiales
 * @property Materia[] $materias
 * @property MateriaProfesor[] $materiaProfesors
 * @property PaqueteMaterium[] $paqueteMaterias
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Materia extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'creditos', 'semestre_optimo', 'carrera_id', 'prerequisito_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carrera()
    {
        return $this->belongsTo(\App\Models\Carrera::class, 'carrera_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materia()
    {
        return $this->belongsTo(\App\Models\Materia::class, 'prerequisito_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grupos()
    {
        return $this->hasMany(\App\Models\Grupo::class, 'id', 'materia_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historiales()
    {
        return $this->hasMany(\App\Models\Historiale::class, 'id', 'materia_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materias()
    {
        return $this->hasMany(\App\Models\Materia::class, 'id', 'prerequisito_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materiaProfesors()
    {
        return $this->hasMany(\App\Models\MateriaProfesor::class, 'id', 'materia_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paqueteMaterias()
    {
        return $this->hasMany(\App\Models\PaqueteMaterium::class, 'id', 'materia_id');
    }
    public function prerequisito()
    {
        // El segundo argumento es la llave foránea ('prerequisito_id')
        // El tercer argumento es la llave local a la que se conecta ('id')
        return $this->belongsTo(Materia::class, 'prerequisito_id', 'id');
    }
    
}
