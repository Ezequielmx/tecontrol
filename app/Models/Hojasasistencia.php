<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hojasasistencia extends Model
{
    use HasFactory;

    protected $fillable=[
        'nro',
        'asistencia_id',
        'pdf'
    ];

    public function detalles(){
        return $this->hasMany('App\Models\Detallehoja');
    }

    public function asistencia(){
        return $this->belongsTo('App\Models\Asistencia');
    }

    public function certCount(){
        return $this->detalles->where('certpf','!=',null)->count();
    }
}
