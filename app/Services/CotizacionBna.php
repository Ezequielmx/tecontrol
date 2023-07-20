<?php

namespace App\Services;

use GuzzleHttp\Client;
use stdClass;
use App\Models\Currency;
use App\Models\QuotationDetail;

class CotizacionBna
{
    public function getCotiz()
    {
        $con = true;

        if ($con) {
            $client = new Client();
            $response = $client->request('GET', 'https://www.bna.com.ar/Personas');
            $html = (string)$response->getBody();

            // Extrae la cotización del dólar del HTML obtenido
            $regexDolar = '/<tr>\s*<td class="tit">Dolar U.S.A<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<\/tr>/s';
            $regexEuro = '/<tr>\s*<td class="tit">Euro<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<\/tr>/s';

            // Extraer las cotizaciones utilizando las expresiones regulares
            preg_match($regexDolar, $html, $matchesDolar);
            $dolarCompra = str_replace(',', '.', $matchesDolar[1]);
            $dolarVenta = str_replace(',', '.', $matchesDolar[2]);

            preg_match($regexEuro, $html, $matchesEuro);
            $euroCompra = str_replace(',', '.', $matchesEuro[1]);
            $euroVenta = str_replace(',', '.', $matchesEuro[2]);


            // Extrae la cotización del euro divisa del HTML obtenido
            $regexTabDivisas = '/<div class="tab-pane fade" id="divisas">(.*?)<\/div>/s';
            preg_match($regexTabDivisas, $html, $matchesTabDivisas);
            $regexDolarDivisa = '/<tr>\s*<td class="tit">Dolar U.S.A<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<\/tr>/s';
            $regexEuroDivisa = '/<tr>\s*<td class="tit">Euro<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<\/tr>/s';


            // Extraer la cotización del dólar divisa utilizando la expresión regular
            preg_match($regexDolarDivisa, $matchesTabDivisas[1], $matchesDolarDivisa);
            $dolarDivisaCompra = str_replace(',', '.', $matchesDolarDivisa[1]);
            $dolarDivisaVenta = str_replace(',', '.', $matchesDolarDivisa[2]);

            // Extraer la cotización del euro divisa utilizando la expresión regular
            preg_match($regexEuroDivisa, $matchesTabDivisas[1], $matchesEuroDivisa);
            $euroDivisaCompra = str_replace(',', '.', $matchesEuroDivisa[1]);
            $euroDivisaVenta = str_replace(',', '.', $matchesEuroDivisa[2]);

            // Crear el objeto con las cotizaciones
            $cotizaciones = new stdClass();
            $cotizaciones->dolarCompra = doubleval($dolarCompra);
            $cotizaciones->dolarVenta = doubleval($dolarVenta);
            $cotizaciones->euroCompra = doubleval($euroCompra);
            $cotizaciones->euroVenta = doubleval($euroVenta);
            $cotizaciones->dolarDivisaCompra = doubleval($dolarDivisaCompra);
            $cotizaciones->dolarDivisaVenta = doubleval($dolarDivisaVenta);
            $cotizaciones->euroDivisaCompra = doubleval($euroDivisaCompra);
            $cotizaciones->euroDivisaVenta = doubleval($euroDivisaVenta);

            $val = (
                $cotizaciones->dolarCompra != Currency::find(1)->compra ||
                $cotizaciones->dolarVenta != Currency::find(1)->venta ||
                $cotizaciones->euroCompra != Currency::find(2)->compra ||
                $cotizaciones->euroVenta != Currency::find(2)->venta ||
                $cotizaciones->dolarDivisaCompra != Currency::find(1)->divisacompra ||
                $cotizaciones->dolarDivisaVenta != Currency::find(1)->divisaventa ||
                $cotizaciones->euroDivisaCompra != Currency::find(2)->divisacompra ||
                $cotizaciones->euroDivisaVenta != Currency::find(2)->divisaventa
            );

            if (
                $cotizaciones->dolarCompra != Currency::find(1)->compra ||
                $cotizaciones->dolarVenta != Currency::find(1)->venta ||
                $cotizaciones->euroCompra != Currency::find(2)->compra ||
                $cotizaciones->euroVenta != Currency::find(2)->venta ||
                $cotizaciones->dolarDivisaCompra != Currency::find(1)->divisacompra ||
                $cotizaciones->dolarDivisaVenta != Currency::find(1)->divisaventa ||
                $cotizaciones->euroDivisaCompra != Currency::find(2)->divisacompra ||
                $cotizaciones->euroDivisaVenta != Currency::find(2)->divisaventa
            ) {
                Currency::find(1)->update([
                    'compra' => $cotizaciones->dolarCompra,
                    'venta' => $cotizaciones->dolarVenta,
                    'divisacompra' => $cotizaciones->dolarDivisaCompra,
                    'divisaventa' => $cotizaciones->dolarDivisaVenta,
                ]);

                Currency::find(2)->update([
                    'compra' => $cotizaciones->euroCompra,
                    'venta' => $cotizaciones->euroVenta,
                    'divisacompra' => $cotizaciones->euroDivisaCompra,
                    'divisaventa' => $cotizaciones->euroDivisaVenta,
                ]);

                QuotationDetail::updateAllCot();
            }
            return $cotizaciones;
        } else {
            $cotizaciones = new stdClass();
            $cotizaciones->dolarCompra = Currency::find(1)->compra;
            $cotizaciones->dolarVenta = Currency::find(1)->venta;
            $cotizaciones->euroCompra = Currency::find(2)->compra;
            $cotizaciones->euroVenta = Currency::find(2)->venta;
            $cotizaciones->dolarDivisaCompra = Currency::find(1)->divisacompra;
            $cotizaciones->dolarDivisaVenta = Currency::find(1)->divisaventa;
            $cotizaciones->euroDivisaCompra = Currency::find(2)->divisacompra;
            $cotizaciones->euroDivisaVenta = Currency::find(2)->divisaventa;

            return $cotizaciones;
        }
    }
}
