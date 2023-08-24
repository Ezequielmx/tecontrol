<?php

namespace App\Http\Livewire\Admin\Quotation;

use Livewire\Component;
use App\Models\Quotation;
use App\Models\QuotationState;
use App\Models\QuotationPriority;
use App\Models\QuotationType;
use App\Models\Client;
use App\Models\Product;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $quotation;
    public $quotationStates;
    public $quotationPriorities;
    public $quotationTypes;
    public $clients;
    public $contacts;
    public $currencies;

    public $searchTerm;
    public $total;
    public $facturado;
    public $difFact;

    public $editDetalleId;
    public $precio;
    public $cantidad;


    public $solicitudCotizacion;
    public $cotizacion;
    public $ordenCompra;

    protected $listeners = ['calcTotal'];

    protected $rules = [
        'quotation.nro' => 'required|numeric',
        'quotation.client_id' => 'required',
        'quotation.fecha' => 'required',
        'quotation.quotation_state_id' => 'required',
        'quotation.quotation_priority_id' => 'required',
        'quotation.quotation_type_id' => 'required',

        'quotation.solicitudCotizacion' => 'nullable',
        'quotation.cotizacion' => 'nullable',
        'quotation.ordenCompra' => 'nullable',
        'quotation.observaciones' => 'nullable',
        'quotation.contacto' => 'nullable',
        'quotation.ref' => 'nullable',
        'quotation.validezOferta' => 'nullable',
        'quotation.condicion' => 'nullable',
        'quotation.plazoEntrega' => 'nullable',
        'quotation.lugarEntrega' => 'nullable',
        'quotation.nota' => 'nullable',
        'quotation.fechaContacto' => 'nullable',
        'quotation.detalleContacto' => 'nullable'
    ];

    

    public function render()
    {
        $this->contacts = $this->quotation->client_id ? Client::find($this->quotation->client_id)->client : [];
        $this->quotation->condicion = $this->quotation->client_id ? Client::find($this->quotation->client_id)->condicion : '';
        
        $this->calcTotal();

        return view('livewire.admin.quotation.edit');
    }

    public function mount(Quotation $quotation){
        $this->quotation = $quotation;
        $this->quotationStates = QuotationState::all();
        $this->quotationPriorities = QuotationPriority::all();
        $this->quotationTypes = QuotationType::all();
        $this->clients = Client::orderby('razon_social')->get();
    }

    public function calcTotal($cambioFact = false){
        $total = 0;
        $facturado = 0;
        foreach ($this->quotation->quotationDetails as $detail) {
            $subtotal = $detail['precio'] * $detail['cantidad'] * $detail['cotizacion'];
            $total += $subtotal;
            $facturado += $subtotal * $detail['facturado'];
        }
        $this->total = $total;
        $this->facturado = $facturado;
        $factCarg = $this->quotation->quotationDocs->sum('monto');
        $this->difFact = $facturado - $factCarg;

        if($cambioFact){
            if($this->quotation->quotationDetails->where('facturado', 1)->count() == 0){
                $this->quotation->quotation_state_id = 3;
            }
            else{
                if($this->quotation->quotationDetails->where('facturado', 1)->count() == $this->quotation->quotationDetails->count()){
                    $this->quotation->quotation_state_id = 5;
                }
                else{
                    $this->quotation->quotation_state_id = 4;
                }
            }    
        }
    }

    public function guardar(){
        $this->validate();

        if($this->solicitudCotizacion){
            $rutaReal = realpath(storage_path('app/' . $this->quotation->solicitudCotizacion));
            if($rutaReal && Storage::exists($rutaReal)){
                Storage::delete($this->quotation->solicitudCotizacion);
            }

            $this->quotation->solicitudCotizacion = $this->solicitudCotizacion->store('solicitudCotizacion', 'public');
        }

        if($this->cotizacion){
            $rutaReal = realpath(storage_path('app/' . $this->quotation->cotizacion));
            if($rutaReal && Storage::exists($rutaReal)){
                Storage::delete($this->quotation->cotizacion);
            }

            $this->quotation->cotizacion = $this->cotizacion->store('cotizacion', 'public');
        }

        if($this->ordenCompra){
            if($this->quotation->ordenCompra && Storage::exists($this->quotation->ordenCompra))
                Storage::delete($this->quotation->ordenCompra);
            $this->quotation->ordenCompra = $this->ordenCompra->store('ordenCompra', 'public');
        }

        $this->quotation->save();
        $this->emit('guardado');
    }


}
