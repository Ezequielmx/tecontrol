<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CotizGraf extends Component
{
    public $desde;
    public $hasta;

    public function mount()
    {
        $this->desde = date('Y-01-01');
        $this->hasta = date('Y-m-d');
    }	

    public function render()
    {
        $dat = DB::select('SELECT quotation_states.id, quotation_states.state as estado, SUM(quotation_details.precio * quotation_details.cantidad * quotation_details.cotizacion) as total FROM quotations
        JOIN quotation_details ON quotations.id = quotation_details.quotation_id
        JOIN quotation_states ON quotation_states.id = quotations.quotation_state_id
        WHERE quotations.fecha BETWEEN "' . $this->desde . '" AND "' . $this->hasta . '" 
        GROUP BY quotation_states.id, quotation_states.state
        ORDER BY quotation_states.id;');

        $colEst = ['#000000', '#e6e396', '#5b9bd5', '#c5e0b4', '#92d050', '#317775','#ff5050', '#373837'];

        $estados = [];
        $totales = [];
        $colores = [];
        foreach ($dat as $estado) {
            $estados[] = $estado->estado;
            $totales[] = $estado->total;
            $colores[] = $colEst[$estado->id];
        }

        $dat2 = DB::select('SELECT quotation_states.id, quotation_states.state as estado, COUNT(quotations.id) as cantidad FROM quotations
        JOIN quotation_states ON quotation_states.id = quotations.quotation_state_id
        WHERE quotations.fecha BETWEEN "' . $this->desde . '" AND "' . $this->hasta . '" 
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

        

        $this->emit('graph', $estados, $totales, $colores);
        $this->emit('graph2', $estadosPie, $cantPie, $coloresPie);
        //dd($dat);
        return view('livewire.admin.cotiz-graf');
    }
}
