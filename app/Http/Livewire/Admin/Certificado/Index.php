<?php

namespace App\Http\Livewire\Admin\Certificado;

use Livewire\Component;
use App\Models\User;
use App\Models\Client;
use App\Models\Asistencia;
use App\Models\Detallehoja;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithFileUploads;

    public $tecnicos;
    public $asistencias;
    public $clients;
    public $client_id;
    public $desde;
    public $hasta;
    public $certpdf;
    public $detalleact_id;

    public function mount()
    {
        $this->tecnicos = User::role('Tecnico')->get();
        $this->clients = Client::WhereHas('asistencias')->orderBy('razon_social')->get();

        if (session('desde_cert')) {
            $this->desde = session('desde_cert');
        } else {
            $this->desde = date('Y-m-01');
        }

        if (session('hasta_cert')) {
            $this->hasta = session('hasta_cert');
        } else {
            $this->hasta = date('Y-m-d');
        }

        $this->client_id = session('client_id_cert');
    }

    public function render()
    {
        $this->asistencias = Asistencia::orderBy('fecha');

        if ($this->desde) {
            $this->asistencias = $this->asistencias->where('fecha', '>=', $this->desde);
        }

        if ($this->hasta) {
            $this->asistencias = $this->asistencias->where('fecha', '<=', $this->hasta);
        }

        if ($this->client_id) {
            $this->asistencias = $this->asistencias->where('client_id', $this->client_id);
        }

        $this->asistencias = $this->asistencias->get();

        session(
            [
                'client_id_cert' => $this->client_id,
                'desde_cert' => $this->desde,
                'hasta_cert' => $this->hasta,
            ]
        );
        return view('livewire.admin.certificado.index');
    }

    public function changeVal(Detallehoja $detallehoja, $field, $value)
    {
        //if value "" then null
        if ($value == "") {
            $value = null;
        }
        $detallehoja->$field = $value;
        $detallehoja->save();
        $this->asistencias = $this->asistencias->fresh();
    }


    //function if update $this->certpdf

    public function seldet($detalle_id)
    {
        $this->detalleact_id = $detalle_id;
    }



    public function updatedCertpdf()
    {
        $detallehoja = Detallehoja::find($this->detalleact_id);

        if ($detallehoja->certpdf) {
            Storage::delete($detallehoja->certpdf);
        }

        $nombreOriginal = $this->certpdf->getClientOriginalName();
        $carpAleat = Str::random(40); // Genera una cadena aleatoria de 40 caracteres

        $detallehoja->certpdf = $this->certpdf->storeAs('certificados/' . $carpAleat, $nombreOriginal, 'public');

        //$detallehoja->certpdf = $this->certpdf->store('certificados', 'public');
        $detallehoja->save();
        $this->detalleact_id = null;
    }
}
