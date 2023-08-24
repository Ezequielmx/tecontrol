<?php

namespace App\Http\Livewire\Admin\Quotation;

use Livewire\Component;
use App\Models\Quotation;
use App\Models\QuotationState;
use App\Models\QuotationPriority;
use App\Models\QuotationType;
use App\Models\Client;
use App\Models\Product;
use App\Models\QuotationDetail;
use App\Models\Currency;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;

    public $quotation;
    public $quotationStates;
    public $quotationPriorities;
    public $quotationTypes;
    public $clients;
    public $contacts;
    public $products;
    public $currencies;

    public $quotationDetails = [];
    public $searchTerm;
    public $total;

    public $solicitudCotizacion;
    public $cotizacion;
    public $ordenCompra;

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


    public function mount()
    {
        $this->quotation = new Quotation();
        $this->quotationStates = QuotationState::all();
        $this->quotationPriorities = QuotationPriority::all();
        $this->quotationTypes = QuotationType::all();
        $this->clients = Client::orderby('razon_social')->get();
        $this->products = Product::all();
        $this->currencies = Currency::all();

        $this->quotation->quotation_state_id = 1;
        $this->quotation->quotation_priority_id = 2;
        $this->quotation->quotation_type_id = 1;
        $this->quotation->fecha = date('Y-m-d');
        $this->quotation->nro = Quotation::max('nro') + 1;
    }

    public function render()
    {
        $this->contacts = $this->quotation->client_id ? Client::find($this->quotation->client_id)->client : [];
        $this->quotation->condicion = $this->quotation->client_id ? Client::find($this->quotation->client_id)->condicion : '';
        $this->products = Product::with('moneda')->search($this->searchTerm)->orderBy('descripcion_cotizacion')->get();

        $total = 0;
        foreach ($this->quotationDetails as $detail) {
            $subtotal = $detail['precio'] * $detail['cantidad'] * $detail['cotizacion'];
            $total += $subtotal;
        }
        $this->total = $total;

        return view('livewire.admin.quotation.create');
    }

    public function addProduct(Product $product)
    {
        $this->quotationDetails[] = [
            'quotation_id' => $this->quotation->id,
            'product_id' => $product->id,
            'descripcion' => $product->descripcion_cotizacion,
            'cantidad' => 1,
            'precio' => $product->precio_venta,
            'currency_id' => $product->moneda,
            'moneda' => $product->moneda()->first()->moneda,
            'cotizacion'  => Currency::find($product->moneda)->venta,
            'facturado' => 0
        ];
    }

    public function removeQuotationDetail($index)
    {
        unset($this->quotationDetails[$index]);
        $this->quotationDetails = array_values($this->quotationDetails);
    }

    public function guardar()
    {
        $this->validate();



        if ($this->solicitudCotizacion) {
            $year = Carbon::now()->year;
            $date = Carbon::now()->format('Y-m-d');

            $fileName = $date . '_' . $this->solicitudCotizacion->getClientOriginalName();
            $path = $this->solicitudCotizacion->storeAs('public/' . $year, $fileName);
            $this->quotation->solicitudCotizacion = Storage::url($path);

            //$this->quotation->solicitudCotizacion = $this->solicitudCotizacion->store('solicitudCotizacion', 'public');
        }

        if ($this->cotizacion) {
            $this->quotation->cotizacion = $this->cotizacion->store('cotizacion', 'public');
        }

        if ($this->ordenCompra) {
            $this->quotation->ordenCompra = $this->ordenCompra->store('ordenCompra', 'public');
        }

        $this->quotation->save();

        foreach ($this->quotationDetails as $detail) {
            $quotationDetail = new QuotationDetail();
            $quotationDetail->quotation_id = $this->quotation->id;
            $quotationDetail->product_id = $detail['product_id'];
            $quotationDetail->cantidad = $detail['cantidad'];
            $quotationDetail->precio = $detail['precio'];
            $quotationDetail->currency_id = $detail['currency_id'];
            $quotationDetail->cotizacion = $detail['cotizacion'];
            $quotationDetail->facturado = $detail['facturado'];
            $quotationDetail->save();
        }

        return redirect()->route('admin.cotizaciones.index')->with('info', 'La cotización se creó con éxito');
    }

    public function print()
    {
        $this->guardar();
        $url = route('admin.cotizaciones.print', $this->quotation);
        return redirect()->to($url);
    }
}
