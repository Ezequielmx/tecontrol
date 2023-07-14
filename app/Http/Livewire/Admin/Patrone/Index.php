<?php

namespace App\Http\Livewire\Admin\Patrone;

use Livewire\Component;
use App\Models\Client;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\Patrone;
use Illuminate\Support\Facades\Storage;


class Index extends Component
{
    use WithFileUploads;
    public $clients;
    public $client_id;
    public $anio;
    public $pdf;
    public $patrones;


    public function mount()
    {
        $this->clients = Client::orderBy('razon_social')->get();

        if (session('anio_pat')) {
            $this->anio = session('anio_pat');
        } else {
            $this->anio = date('Y');
        }

        if (session('client_id_pat')) {
            $this->client_id = session('client_id_pat');
        }
    }

    public function render()
    {
        if ($this->client_id)
            $this->patrones = Client::find($this->client_id)->patrones()->where('anio', $this->anio)->get();
        else
            $this->patrones = [];

        session(['anio_pat' => $this->anio]);
        session(['client_id_pat' => $this->client_id]);
        return view('livewire.admin.patrone.index');
    }

    public function agregar()
    {

        $nombreOriginal = $this->pdf->getClientOriginalName();
        $carpAleat = Str::random(40); // Genera una cadena aleatoria de 40 caracteres

        Patrone::create([
            'client_id' => $this->client_id,
            'anio' => $this->anio,
            'pdf' => $this->pdf->storeAs('patrones/' . $carpAleat, $nombreOriginal, 'public')
        ]);

        $this->pdf = '';
    }

    public function eliminar($id)
    {
        $patron = Patrone::find($id);
        Storage::delete($patron->pdf);
        $patron->delete();
    }
}
