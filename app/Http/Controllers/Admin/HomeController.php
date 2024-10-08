<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CotizacionBna;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $cot = new CotizacionBna();
        $cotizaciones = $cot->getCotiz();

        $desde = date('Y-01-01');
        $hasta = date('Y-m-d');

        $dat = DB::select('SELECT quotation_states.id, quotation_states.state as estado, SUM(quotation_details.precio * quotation_details.cantidad * quotation_details.cotizacion) as total FROM quotations
        JOIN quotation_details ON quotations.id = quotation_details.quotation_id
        JOIN quotation_states ON quotation_states.id = quotations.quotation_state_id
        WHERE quotations.fecha BETWEEN "' . $desde . '" AND "' . $hasta . '" 
        GROUP BY quotation_states.id, quotation_states.state
        ORDER BY quotation_states.id;');

        $colEst = ['#000000', '#e6e396', '#5b9bd5', '#c5e0b4', '#92d050', '#317775','#ff5050', '#373837'];

        $estadosIni = [];
        $totalesIni = [];
        $coloresIni = [];
        foreach ($dat as $estado) {
            $estadosIni[] = $estado->estado;
            $totalesIni[] = $estado->total;
            $coloresIni[] = $colEst[$estado->id];
        }

        

        $dat2 = DB::select('SELECT quotation_states.id, quotation_states.state as estado, COUNT(quotations.id) as cantidad FROM quotations
        JOIN quotation_states ON quotation_states.id = quotations.quotation_state_id
        WHERE quotations.fecha BETWEEN "' . $desde . '" AND "' . $hasta . '" 
        GROUP BY quotation_states.id, quotation_states.state
        ORDER BY quotation_states.id;');

        $estadosPie = [];
        $cantPie = [];
        $coloresPie = [];
        foreach ($dat2 as $estado) {
            $estadosPie[] = $estado->estado;
            $cantPie[] = $estado->cantidad;
            $coloresPie[] = $colEst[$estado->id];
        }

        return view('admin.index', compact('cotizaciones', 'estadosIni', 'totalesIni', 'coloresIni', 'estadosPie', 'cantPie', 'coloresPie'));
    }
}
