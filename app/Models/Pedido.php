<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'nro',
        'supplier_id',
        'fecha',
        'pedido_state_id',
        'solicitudPedido',
        'pedido',
        'ordenCompra',
        'observaciones',
        'contacto',
        'ref',
        'condicion',
        'plazoEntrega',
        'lugarEntrega',
        'nota',
        'fechaContacto',
        'detalleContacto',
        'nroPedido',
        'user_id'
    ];

    public function pedidoState(){
        return $this->belongsTo('App\Models\PedidoState');
    }

    public function supplier(){
        return $this->belongsTo('App\Models\Supplier');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function detallePedidos(){
        return $this->hasMany('App\Models\DetallePedido');
    }

    public function contact(){
        return $this->belongsTo('App\Models\SuppliersContact', 'contacto');
    }

    public function total()
    {
        $total = 0;
        foreach ($this->detallePedidos as $detail) {
            $total += $detail->cantidad * $detail->precio;
        }
        return $total;
    }
}
