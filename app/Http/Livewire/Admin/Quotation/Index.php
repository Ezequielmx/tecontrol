<?php

namespace App\Http\Livewire\Admin\Quotation;

use App\Models\Client;
use App\Models\Quotation;
use App\Models\QuotationState;
use Livewire\Component;
use App\Models\QuotationPriority;
use App\Models\QuotationDetail;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $cliente_id;
    public $finalizadas = false;
    public $clients;
    public $estado_id = 2;
    public $quotationStates;
    public $quotationPriorities;
    public $prioridad_id;

    public $selected_id;
    public $quotationDetails;

    protected $listeners = ['deleteCotizacion'];
    
    public function mount($cliente_id = null){
        $this->quotationDetails = [];
        if($cliente_id){
            $this->cliente_id = $cliente_id;
        }
        else{
            $this->cliente_id = session('cliente_id');
            $this->estado_id = session('estado_id');
            $this->prioridad_id = session('prioridad_id');
            $this->finalizadas = session('finalizadas');
        }
    }
    public function render()
    {   

        $cotizaciones = Quotation::orderBy('fecha', 'desc')
        ->when($this->cliente_id, function ($query) {
            return $query->where('client_id', $this->cliente_id);
        })
        ->when($this->estado_id, function ($query) {
            return $query->where('quotation_state_id', $this->estado_id);
        })
        ->when($this->prioridad_id, function ($query) {
            return $query->where('quotation_priority_id', $this->prioridad_id);
        })
        ->when(!$this->finalizadas, function ($query) {
            return $query->where('quotation_state_id', '<', 5);
        })
        ->paginate(50); 

        $this->clients = Client::whereHas('quotations')->orderby('razon_social')->get();
        $this->quotationStates = QuotationState::all();
        $this->quotationPriorities = QuotationPriority::all();

        session([
            'cliente_id' => $this->cliente_id,
            'estado_id' => $this->estado_id,
            'prioridad_id' => $this->prioridad_id,
            'finalizadas' => $this->finalizadas
        ]);


        return view('livewire.admin.quotation.index', compact('cotizaciones'));
    }

    public function deleteCotizacion($id){
        $cotizacion = Quotation::find($id);
        $cotizacion->delete();
    }

    public function borrarFiltros(){
        $this->cliente_id = null;
        $this->estado_id = null;
        $this->prioridad_id = null;
        $this->finalizadas = false;
    }

    public function selCot($id){

        $this->selected_id == $id? $this->selected_id = null : $this->selected_id = $id;
        $this->quotationDetails = QuotationDetail::where('quotation_id', $id)->get();
        //dd($this->quotationDetails);	
    }
}
