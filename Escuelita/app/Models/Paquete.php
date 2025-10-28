<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Paquete
 *
 * @property $id
 * @property $nombre
 *
 * @property PaqueteMaterium[] $paqueteMaterias
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Paquete extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paqueteMaterias()
    {
        return $this->hasMany(\App\Models\PaqueteMaterium::class, 'id', 'paquete_id');
    }
    
}
