<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}