<?php

namespace App\Http\Livewire\Admin;

use App\Models\Quotation;
use App\Models\QuotationState;
use Livewire\Component;

class Tablero extends Component
{
    public $cotizaciones;
    public $states;

    public function mount()
    {
        $this->states = QuotationState::all();
    }

    public function render()
    {
        $this->cotizaciones = Quotation::orderBy('fecha', 'desc')->get();
        return view('livewire.admin.tablero');
    }
}
