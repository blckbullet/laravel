<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PaqueteMateria
 *
 * @property $paquete_id
 * @property $materia_id
 *
 * @property Materia $materia
 * @property Paquete $paquete
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PaqueteMateria extends Model
{
    
    protected $perPage = 20;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['paquete_id', 'materia_id'];


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
    public function paquete()
    {
        return $this->belongsTo(\App\Models\Paquete::class, 'paquete_id', 'id');
    }
    
}
