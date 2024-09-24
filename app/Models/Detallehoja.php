<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallehoja extends Model
{
    use HasFactory;

    protected $fillable=[
        'hojasasistencia_id',
        'detalle',
        'certificado',
        'quotation_id',
        'user_id',
        'fechaborrador',
        'fechacliente',
        'certpdf'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function hojasasistencia(){
        return $this->belongsTo('App\Models\Hojasasistencia');
    }

    public function asistencia(){
        return $this->hojasasistencia->asistencia();
    }

    public function client(){
        return $this->asistencia->client();
    }

    public function sector(){
        return $this->hasOne('App\Models\ClientsSector', 'id', 'clientssector_id');
    }
}
