<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nro',
        'client_id',
        'fecha',
        'programado',
        'trabajotipo_id',
        'horas_trabajo',
        'horas_espera',
        'tecnico_she',
        'horas_she',
        'reclamo',
        'reclamo_detalle',
        'encuesta_conformidad',
        'encuesta_personal',
        'encuesta_tiempo',
        'accidente',
        'accidente_detalle',
        'diatipo_id',
    ];

    public function client(){
        return $this->belongsTo('App\Models\Client');
    }

    public function diatipo(){
        return $this->belongsTo('App\Models\Diatipo');
    }

    public function trabajotipo(){
        return $this->belongsTo('App\Models\Trabajotipo');
    }

    public function tecnicos(){
        return $this->belongsToMany('App\Models\User');
    }

    public function hojas(){
        return $this->hasMany('App\Models\Hojasasistencia');
    }
}
