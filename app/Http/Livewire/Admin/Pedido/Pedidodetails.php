<?php

namespace App\Http\Livewire\Admin\Pedido;

use Livewire\Component;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Product;
use App\Models\Client;

class Pedidodetails extends Component
{
    public $pedido;
    public $detallePedidos;
    public $products;
    public $clients;
    public $searchTerm;

    protected $listeners = ['render', 'deleteDetalle', 'deleteProds'];


    public function mount(Pedido $pedido){
        $this->pedido = $pedido;
        $this->clients = Client::orderby('razon_social')->get();
    }

    public function render()
    {
        // Filtrar productos solo del proveedor del pedido
        if ($this->pedido->supplier_id) {
            $this->products = Product::where('proveedor', $this->pedido->supplier_id)
                ->when($this->searchTerm, function($query) {
                    return $query->where(function($q) {
                        $q->where('descripcion_pedido', 'LIKE', '%'.$this->searchTerm.'%')
                          ->orWhere('descripcion_cotizacion', 'LIKE', '%'.$this->searchTerm.'%');
                    });
                })
                ->orderBy('descripcion_pedido')
                ->get();
        } else {
            $this->products = collect([]);
        }

        $this->detallePedidos = DetallePedido::where('pedido_id', $this->pedido->id)->get();
        return view('livewire.admin.pedido.pedidodetails');
    }

    public function cambioCantidad($cantidad, $detalle_id){
        DetallePedido::find($detalle_id)->update(['cantidad' => $cantidad]);
        $this->emit('calcTotal');
    }

    public function cambioPrecio($precio, $detalle_id){
        DetallePedido::find($detalle_id)->update(['precio' => $precio]);
        $this->emit('calcTotal');
    }

    public function cambioDestino($destino, $detalle_id){
        DetallePedido::find($detalle_id)->update(['destino' => $destino ?: null]);
    }

    public function cambioCotizacion($cotizacion, $detalle_id){
        DetallePedido::find($detalle_id)->update(['cotizacion' => $cotizacion ?: null]);
    }

    public function cambioRecibido($recibido, $detalle_id){
        $recibido_val = $recibido ? 1 : 0;
        DetallePedido::find($detalle_id)->update(['recibido' => $recibido_val]);
        $this->emit('calcTotal', true);
    }

    public function deleteDetalle($detalle_id){
        DetallePedido::find($detalle_id)->delete();
        $this->emit('calcTotal');
    }

    public function addProduct(Product $product)
    {
        $detallePedido = new DetallePedido();
        $detallePedido->pedido_id = $this->pedido->id;
        $detallePedido->product_id = $product->id;
        $detallePedido->descripcion = $product->descripcion_pedido;
        $detallePedido->cantidad = 1;
        $detallePedido->precio = $product->precio_compra;
        $detallePedido->destino = null;
        $detallePedido->cotizacion = null;
        $detallePedido->recibido = 0;
        $detallePedido->cantidad_recibida = 0;
        $detallePedido->save();
    }
}
