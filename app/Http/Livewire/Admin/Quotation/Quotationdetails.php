<?php

namespace App\Http\Livewire\Admin\Quotation;

use Livewire\Component;
use App\Models\QuotationDetail;
use App\Models\Quotation;
use App\Models\Product;
use App\Models\Currency;

class Quotationdetails extends Component
{
    public $quotation;
    public $quotationDetails;
    public $products;
    public $currencies;
    public $searchTerm;

    protected $listeners = ['render', 'deleteDetalle', 'deleteProds'];


    public function mount(Quotation $quotation){
        $this->quotation = $quotation;
        $this->currencies = Currency::all();
    }

    public function render()
    {
        $this->products = Product::with('moneda')->search($this->searchTerm)->orderBy('descripcion_cotizacion')->get();
        $this->quotationDetails = QuotationDetail::where('quotation_id', $this->quotation->id)->get();
        return view('livewire.admin.quotation.quotationdetails');
    }

    public function cambioCantidad($cantidad, $detalle_id){
        QuotationDetail::find($detalle_id)->update(['cantidad' => $cantidad]);
        //$this->emit('render');
        $this->emit('calcTotal');
    }

    public function cambioPrecio($precio, $detalle_id){
        QuotationDetail::find($detalle_id)->update(['precio' => $precio]);
        //$this->emit('render');
        $this->emit('calcTotal');
    }

    public function cambioFacturado($facturado, $detalle_id){
        $facturado_val = $facturado ? 1 : 0;
        QuotationDetail::find($detalle_id)->update(['facturado' => $facturado_val]);
        //dd($facturado_val, $detalle_id);
        //$this->emit('render');
        $this->emit('calcTotal', true);
    }

    public function deleteDetalle($detalle_id){
        QuotationDetail::find($detalle_id)->delete();
        //$this->emit('render');
        $this->emit('calcTotal');
    }

    public function addProduct(Product $product)
    {
        $quotationDetail = new QuotationDetail();
        $quotationDetail->quotation_id = $this->quotation->id;
        $quotationDetail->product_id = $product->id;
        $quotationDetail->cantidad = 1;
        $quotationDetail->precio = $product->precio_venta;
        $quotationDetail->currency_id = $product->moneda;
        $quotationDetail->cotizacion = $product->moneda()->first()->venta;
        $quotationDetail->facturado = 0;
        $quotationDetail->save();
        //$this->emit('render');
    }
}
