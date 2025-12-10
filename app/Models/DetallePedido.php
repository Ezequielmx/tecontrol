<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $table = 'detalle_pedidos';

    protected $fillable = [
        'pedido_id',
        'product_id',
        'descripcion',
        'precio',
        'cantidad',
        'destino',
        'recibido',
        'cantidad_recibida',
        'fecha_recibido',
        'cotizacion'
    ];

    public function pedido(){
        return $this->belongsTo('App\Models\Pedido');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
}
