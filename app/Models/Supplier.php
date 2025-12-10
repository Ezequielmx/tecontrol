<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SuppliersContact;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'razon_social',
        'nac_imp_id',
        'rubro',
        'direccion',
        'telefono',
        'condicion',
        'observaciones',
        'active'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function supplier()
    {
        return $this->hasMany(SuppliersContact::class, 'suppliers_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'supplier_id');
    }

    public function suppliersContacts()
    {
        return $this->hasMany(SuppliersContact::class, 'supplier_id');
    }

    public function scopeSearch(Builder $query, Request $request): Builder
    {
        return $query->when($request->input('razon_social'), function ($query) use ($request) {
            return $query->where('razon_social', 'like', '%' . $request->input('razon_social') . '%');
        });

    }

}
