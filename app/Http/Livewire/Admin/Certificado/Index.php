<?php

namespace App\Http\Livewire\Admin\Certificado;

use Livewire\Component;
use App\Models\User;
use App\Models\Client;
use App\Models\Asistencia;
use App\Models\Detallehoja;

class Index extends Component
{
    public $tecnicos;
    public $asistencias;
    public $clients;
    public $client_id;
    public $desde;
    public $hasta;

    public function mount()
    {
        $this->tecnicos = User::role('Tecnico')->get();
        $this->clients = Client::WhereHas('asistencias')->get();

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

        if($this->desde){
            $this->asistencias = $this->asistencias->where('fecha', '>=', $this->desde);
        }

        if($this->hasta){
            $this->asistencias = $this->asistencias->where('fecha', '<=', $this->hasta);
        }

        if($this->client_id){
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
        $detallehoja->$field = $value;
        $detallehoja->save();
        $this->asistencias = $this->asistencias->fresh();
    }
}