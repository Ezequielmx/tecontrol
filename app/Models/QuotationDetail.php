<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\CotizacionBna;

class QuotationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'product_id',
        'currency_id',
        'precio',
        'cotizacion',
        'cantidad',
        'facturado',
        'nroPedido'
    ];

    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

    public static function updateAllCot()
    {
        /*
        $cotizaciones = new CotizacionBna();
        $cotizaciones = $cotizaciones->getCotiz();

        if ($cotizaciones->dolarCompra != Currency::find(1)->compra ||
            $cotizaciones->dolarVenta != Currency::find(1)->venta ||
            $cotizaciones->euroCompra != Currency::find(2)->compra ||
            $cotizaciones->euroVenta != Currency::find(2)->venta) {
            Currency::find(1)->update([
                'compra' => $cotizaciones->dolarCompra,
                'venta' => $cotizaciones->dolarVenta,
            ]);

            Currency::find(2)->update([
                'compra' => $cotizaciones->euroCompra,
                'venta' => $cotizaciones->euroVenta,
            ]);

        */
        $details = self::where('facturado', 0)
            ->where('currency_id', '<', 3)
            ->get();

        $dolarV = Currency::find(1)->venta;
        $euroV = Currency::find(2)->venta;

        foreach ($details as $detail) {
            // Actualizar los valores según el currency_id
            if ($detail->currency_id == 1) {
                $detail->cotizacion = $dolarV ;
            } elseif ($detail->currency_id == 2) {
                $detail->cotizacion = $euroV;
            }

            // Guardar el detalle de cotización actualizado
            $detail->save();
        }
    }
}
