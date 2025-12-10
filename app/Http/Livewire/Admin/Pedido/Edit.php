<?php

namespace App\Http\Livewire\Admin\Pedido;

use Livewire\Component;
use App\Models\Pedido;
use App\Models\PedidoState;
use App\Models\Supplier;
use App\Models\Product;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class Edit extends Component
{
    use WithFileUploads;

    public $pedido;
    public $pedidoStates;
    public $suppliers;
    public $contacts;

    public $searchTerm;
    public $total;
    public $recibido;
    public $difRecibido;

    public $editDetalleId;
    public $precio;
    public $cantidad;


    public $solicitudPedido;
    public $pedidoFile;
    public $ordenCompra;

    public $users;

    protected $listeners = ['calcTotal'];

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


    public function render()
    {
        $this->contacts = $this->pedido->supplier_id ? Supplier::find($this->pedido->supplier_id)->supplier : [];
        $this->pedido->condicion = $this->pedido->supplier_id ? Supplier::find($this->pedido->supplier_id)->condicion : '';

        $this->calcTotal();

        return view('livewire.admin.pedido.edit');
    }

    public function mount(Pedido $pedido){
        $this->pedido = $pedido;
        $this->pedidoStates = PedidoState::all();
        $this->suppliers = Supplier::orderby('razon_social')->get();
        $this->users = User::whereHas('roles', function($query) {
        $query->whereIn('name', ['Admin', 'Vendedor']);
        })->get();
    }

    public function calcTotal($cambioRecibido = false){
        $total = 0;
        $recibido = 0;
        foreach ($this->pedido->detallePedidos as $detail) {
            $subtotal = $detail['precio'] * $detail['cantidad'];
            $total += $subtotal;
            $recibido += $subtotal * ($detail['recibido'] ? 1 : 0);
        }
        $this->total = $total;
        $this->recibido = $recibido;
        $this->difRecibido = $total - $recibido;

        if($cambioRecibido){
            if($this->pedido->detallePedidos->where('recibido', 1)->count() == 0){
                $this->pedido->pedido_state_id = 1;
            }
            else{
                if($this->pedido->detallePedidos->where('recibido', 1)->count() == $this->pedido->detallePedidos->count()){
                    $this->pedido->pedido_state_id = 3;
                }
                else{
                    $this->pedido->pedido_state_id = 2;
                }
            }
        }
    }

    public function guardar(){
        $this->validate();

        if($this->solicitudPedido){
            $rutaReal = realpath(storage_path('app/' . $this->pedido->solicitudPedido));
            if($rutaReal && Storage::exists($rutaReal)){
                Storage::delete($this->pedido->solicitudPedido);
            }

            $this->pedido->solicitudPedido = $this->solicitudPedido->store('solicitudPedido', 'public');
        }

        if($this->pedidoFile){
            $rutaReal = realpath(storage_path('app/' . $this->pedido->pedido));
            if($rutaReal && Storage::exists($rutaReal)){
                Storage::delete($this->pedido->pedido);
            }

            $this->pedido->pedido = $this->pedidoFile->store('pedido', 'public');
        }

        if($this->ordenCompra){
            if($this->pedido->ordenCompra && Storage::exists($this->pedido->ordenCompra))
                Storage::delete($this->pedido->ordenCompra);
            $this->pedido->ordenCompra = $this->ordenCompra->store('ordenCompra', 'public');
        }

        $this->pedido->save();
        $this->emit('guardado');
    }


}
