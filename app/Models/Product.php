<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion_pedido',
        'descripcion_cotizacion',
        'proveedor',
        'moneda',
        'categoria',
        'precio_compra',
        'precio_venta',
        'punto_pedido',
        'stock_inicial',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function moneda()
    {
        return $this->belongsTo(Currency::class, 'moneda');
    }

    public function categoria()
    {
        return $this->belongsTo(Category::class);
    }

    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class, 'product_id');
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('descripcion_pedido', 'LIKE', '%'.$searchTerm.'%')
            ->orWhere('descripcion_cotizacion', 'LIKE', '%'.$searchTerm.'%');
    }
}
