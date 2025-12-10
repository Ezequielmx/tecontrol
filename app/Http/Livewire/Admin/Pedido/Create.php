<?php

namespace App\Http\Livewire\Admin\Pedido;

use Livewire\Component;
use App\Models\Pedido;
use App\Models\PedidoState;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\DetallePedido;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;

    public $pedido;
    public $pedidoStates;
    public $suppliers;
    public $contacts;
    public $products;

    public $detallePedidos = [];
    public $searchTerm;
    public $total;

    public $solicitudPedido;
    public $pedidoFile;
    public $ordenCompra;

    protected $rules = [
        'pedido.nro' => 'required|numeric',
        'pedido.supplier_id' => 'required',
        'pedido.user_id' => 'required',
        'pedido.fecha' => 'required',
        'pedido.pedido_state_id' => 'required',

        'pedido.solicitudPedido' => 'nullable',
        'pedido.pedido' => 'nullable',
        'pedido.ordenCompra' => 'nullable',
        'pedido.observaciones' => 'nullable',
        'pedido.contacto' => 'nullable',
        'pedido.ref' => 'nullable',
        'pedido.condicion' => 'nullable',
        'pedido.plazoEntrega' => 'nullable',
        'pedido.lugarEntrega' => 'nullable',
        'pedido.nota' => 'nullable',
        'pedido.fechaContacto' => 'nullable',
        'pedido.detalleContacto' => 'nullable',

        'pedido.nroPedido' => 'nullable',
    ];


    public function mount()
    {
        $this->pedido = new Pedido();
        $this->pedidoStates = PedidoState::all();
        $this->suppliers = Supplier::orderby('razon_social')->get();
        $this->products = Product::all();

        $this->pedido->pedido_state_id = 1;
        $this->pedido->fecha = date('Y-m-d');
        $this->pedido->nro = Pedido::max('nro') + 1;
        $this->pedido->user_id = auth()->user()->id;
    }

    public function render()
    {
        $this->contacts = $this->pedido->supplier_id ? Supplier::find($this->pedido->supplier_id)->suppliersContacts : [];
        $this->pedido->condicion = $this->pedido->supplier_id ? Supplier::find($this->pedido->supplier_id)->condicion : '';
        $this->products = Product::search($this->searchTerm)->orderBy('descripcion_pedido')->get();

        $total = 0;
        foreach ($this->detallePedidos as $detail) {
            $subtotal = $detail['precio'] * $detail['cantidad'];
            $total += $subtotal;
        }
        $this->total = $total;

        return view('livewire.admin.pedido.create');
    }

    public function addProduct(Product $product)
    {
        $this->detallePedidos[] = [
            'pedido_id' => $this->pedido->id,
            'product_id' => $product->id,
            'descripcion' => $product->descripcion_pedido,
            'cantidad' => 1,
            'precio' => $product->precio_compra,
            'destino' => '',
            'recibido' => 0,
            'cantidad_recibida' => 0
        ];
    }

    public function removeDetallePedido($index)
    {
        unset($this->detallePedidos[$index]);
        $this->detallePedidos = array_values($this->detallePedidos);
    }

    public function guardar()
    {
        $this->validate();

        if ($this->solicitudPedido) {
            $year = Carbon::now()->year;
            $date = Carbon::now()->format('Y-m-d');

            $fileName = $date . '_' . $this->solicitudPedido->getClientOriginalName();
            $path = $this->solicitudPedido->storeAs('public/' . $year, $fileName);
            $this->pedido->solicitudPedido = Storage::url($path);
        }

        if ($this->pedidoFile) {
            $this->pedido->pedido = $this->pedidoFile->store('pedido', 'public');
        }

        if ($this->ordenCompra) {
            $this->pedido->ordenCompra = $this->ordenCompra->store('ordenCompra', 'public');
        }

        $this->pedido->save();

        foreach ($this->detallePedidos as $detail) {
            $detallePedido = new DetallePedido();
            $detallePedido->pedido_id = $this->pedido->id;
            $detallePedido->product_id = $detail['product_id'];
            $detallePedido->descripcion = $detail['descripcion'];
            $detallePedido->cantidad = $detail['cantidad'];
            $detallePedido->precio = $detail['precio'];
            $detallePedido->destino = $detail['destino'];
            $detallePedido->recibido = $detail['recibido'];
            $detallePedido->cantidad_recibida = $detail['cantidad_recibida'];
            $detallePedido->save();
        }

        return redirect()->route('admin.pedidos.index')->with('info', 'El pedido se creó con éxito');
    }
}
