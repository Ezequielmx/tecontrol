<?php

namespace App\Http\Livewire\Admin\Quotation;

use App\Models\Client;
use App\Models\Quotation;
use App\Models\QuotationState;
use Livewire\Component;
use App\Models\QuotationPriority;
use App\Models\QuotationDetail;

class Index extends Component
{
    public $cotizaciones;
    public $cliente_id;
    public $finalizadas = false;
    public $clients;
    public $estado_id = 2;
    public $quotationStates;
    public $quotationPriorities;
    public $prioridad_id;

    protected $listeners = ['deleteCotizacion'];
    
    public function mount($cliente_id = null){
        
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
        $this->cotizaciones = Quotation::orderBy('fecha');

        if($this->cliente_id){
            $this->cotizaciones = $this->cotizaciones->where('client_id', $this->cliente_id);
        }

        if($this->estado_id){
            $this->cotizaciones = $this->cotizaciones->where('quotation_state_id', $this->estado_id);
        }

        if($this->prioridad_id){
            $this->cotizaciones = $this->cotizaciones->where('quotation_priority_id', $this->prioridad_id);
        }

        if(!$this->finalizadas){
            $this->cotizaciones = $this->cotizaciones->where('quotation_state_id', '<', 5);
        }

        
        $this->cotizaciones = $this->cotizaciones->get();
        $this->clients = Client::whereHas('quotations')->get();
        $this->quotationStates = QuotationState::all();
        $this->quotationPriorities = QuotationPriority::all();

        session([
            'cliente_id' => $this->cliente_id,
            'estado_id' => $this->estado_id,
            'prioridad_id' => $this->prioridad_id,
            'finalizadas' => $this->finalizadas
        ]);


        return view('livewire.admin.quotation.index');
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
}
