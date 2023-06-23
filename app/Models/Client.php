<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClientsContact;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'razon_social',
        'tipo_cliente',
        'cuit',
        'direccion',
        'telefono',
        'condicion',
        'observaciones',
        'active'
    ];

    public function client()
    {
        return $this->hasMany(ClientsContact::class, 'clients_id');
    }

    public function scopeSearch(Builder $query, Request $request): Builder
    {
        return $query->when($request->input('razon_social'), function ($query) use ($request) {
            return $query->where('razon_social', 'like', '%' . $request->input('razon_social') . '%');
        })->when($request->input('tipo_cliente'), function ($query) use ($request) {
            return $query->where('tipo_cliente', 'like', '%' . $request->input('tipo_cliente') . '%');
        });
    }

    public function quotations()
    {
        return $this->hasMany('App\Models\Quotation');
    }

    public function asistencias()
    {
        return $this->hasMany('App\Models\Asistencia');
    }
}
