<?php

namespace App\Http\Livewire\Admin\Asistencia;

use Livewire\Component;
use App\Models\Asistencia;
use App\Models\Client;
use App\Models\Diatipo;
use App\Models\Trabajotipo;

class Index extends Component
{
    public $asistencias;
    public $trabajotipos;
    public $diatipos;
    public $clients;
    public $client_id;
    public $desde;
    public $hasta;

    public function mount()
    {
        $this->clients = Client::WhereHas('asistencias')->get();
        $this->trabajotipos = Trabajotipo::all();
        $this->diatipos = Diatipo::all();

        if(session('desde')){
            $this->desde = session('desde_asist');
        }else{
            $this->desde = date('Y-m-01');
        }

        if(session('hasta')){
            $this->hasta = session('hasta_asist');
        }else{
            $this->hasta = date('Y-m-d');
        }

        $this->client_id = session('client_id_asist');
    }

    public function render()
    {
        $this->asistencias = Asistencia::orderBy('nro', 'desc');

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
                'client_id_asist' => $this->client_id,
                'desde_asist' => $this->desde,
                'hasta_asist' => $this->hasta,
            ]
        );

        return view('livewire.admin.asistencia.index');
    }
}
