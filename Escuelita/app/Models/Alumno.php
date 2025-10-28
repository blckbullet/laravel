<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    /**
     * ==========================================================
     * CORRECCIONES CLAVE PARA SOLUCIONAR EL ERROR
     * ==========================================================
     */

    /**
     * La llave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'matricula';

    /**
     * Indica si la llave primaria es autoincremental.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * El tipo de dato de la llave primaria.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Obtiene el nombre de la clave para la ruta del modelo.
     * Esto le dice al router que use 'matricula' en la URL.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'matricula';
    }
    
    /**
     * ==========================================================
     * FIN DE LAS CORRECCIONES
     * ==========================================================
     */
     
    protected $perPage = 20;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'matricula', 'nombre','segundo_nombre', 'apellido_paterno', 'apellido_materno', 
        'correo', 'telefono', 'carrera_id', 'semestre_actual', 'es_egresado'
    ];


    /**
     * Define la relación con Carrera.
     */
    public function carrera()
    {
        return $this->belongsTo(\App\Models\Carrera::class, 'carrera_id');
    }
    
    /**
     * Define la relación con Historial.
     */
    public function historiales()
    {
        return $this->hasMany(\App\Models\Historiale::class, 'alumno_matricula', 'matricula');
    }
}