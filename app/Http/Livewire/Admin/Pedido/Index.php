<?php

namespace App\Http\Livewire\Admin\Pedido;

use App\Models\Supplier;
use App\Models\Pedido;
use App\Models\PedidoState;
use Livewire\Component;
use App\Models\DetallePedido;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $pedido_nro;
    public $supplier_id;
    public $finalizados = false;
    public $suppliers;
    public $estado_id = 1;
    public $pedidoStates;
    public $nroPedido;

    public $selected_id;
    public $detallePedidos;

    protected $listeners = ['deletePedido'];

    public function mount($supplier_id = null){
        $this->detallePedidos = [];
        if($supplier_id){
            $this->supplier_id = $supplier_id;
        }
        else{
            $this->supplier_id = session('supplier_id');
            $this->estado_id = session('estado_id');
            $this->finalizados = session('finalizados');
        }
    }

    public function render()
    {
        if (auth()->user()->hasRole('Admin')) {
            $pedidos = Pedido::orderBy('fecha', 'desc');
        } else {
            $pedidos = Pedido::where('user_id', auth()->user()->id)->orderBy('fecha', 'desc');
        }

        $pedidos = $pedidos
        ->when($this->pedido_nro, function ($query) {
            return $query->where('nro', $this->pedido_nro);
        })
        ->when($this->supplier_id, function ($query) {
            return $query->where('supplier_id', $this->supplier_id);
        })
        ->when($this->estado_id, function ($query) {
            return $query->where('pedido_state_id', $this->estado_id);
        })
        ->when(!$this->finalizados, function ($query) {
            return $query->where('pedido_state_id', '<', 3);
        })
        ->when($this->nroPedido, function($query){
            return $query->where('nroPedido', 'like', '%'.$this->nroPedido. '%');
        })
        ->paginate(50);

        $this->suppliers = Supplier::whereHas('pedidos')->orderby('razon_social')->get();
        $this->pedidoStates = PedidoState::all();

        session([
            'supplier_id' => $this->supplier_id,
            'estado_id' => $this->estado_id,
            'finalizados' => $this->finalizados
        ]);

        return view('livewire.admin.pedido.index', compact('pedidos'));
    }

    public function deletePedido($id){
        $pedido = Pedido::find($id);
        $pedido->delete();
    }

    public function borrarFiltros(){
        $this->supplier_id = null;
        $this->estado_id = null;
        $this->finalizados = false;
        $this->pedido_nro = null;
    }

    public function selPed($id){
        $this->selected_id == $id? $this->selected_id = null : $this->selected_id = $id;
        $this->detallePedidos = DetallePedido::where('pedido_id', $id)->get();
    }
}
