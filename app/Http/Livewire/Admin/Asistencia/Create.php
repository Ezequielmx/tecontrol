<?php

namespace App\Http\Livewire\Admin\Asistencia;

use Livewire\Component;
use App\Models\Asistencia;
use App\Models\Client;
use App\Models\Diatipo;
use App\Models\Trabajotipo;
use App\Models\User;

class Create extends Component
{
    public $asistencia;
    public $clients;
    public $trabajotipos;
    public $diatipos;
    public $tecnicos;

    public $new_tecnico_id;
    public $tecnicos_selected = [];

    protected $rules = [
        'asistencia.nro' => 'required',
        'asistencia.client_id' => 'required',
        'asistencia.fecha' => 'required',
        'asistencia.diatipo_id' => 'required',
        'asistencia.programado' => 'nullable',
        'asistencia.trabajotipo_id' => 'required',
        'asistencia.horas_trabajo' => 'required',
        'asistencia.horas_espera' => 'nullable',
        'asistencia.tecnico_she' => 'nullable',
        'asistencia.horas_she' => 'nullable',
        'asistencia.reclamo' => 'nullable',
        'asistencia.reclamo_detalle' => 'nullable',
        'asistencia.encuesta_conformidad' => 'nullable',
        'asistencia.encuesta_personal' => 'nullable',
        'asistencia.encuesta_tiempo' => 'nullable',
        'asistencia.accidente' => 'nullable',
        'asistencia.accidente_detalle' => 'nullable',
    ];

    public function mount(){
        $this->asistencia = new Asistencia();
    
        $this->clients = Client::orderBy('razon_social')->get();
        $this->trabajotipos = Trabajotipo::all();
        $this->diatipos = Diatipo::all();
        $this->asistencia->nro = Asistencia::max('nro') + 1;
        $this->asistencia->fecha = date('Y-m-d');
        $this->asistencia->diatipo_id = 1;
        $this->asistencia->programado = 0;
        $this->asistencia->tecnico_she = 0;
        $this->asistencia->reclamo = 0;
        $this->asistencia->accidente = 0;
        $this->asistencia->horas_espera = 0;

        $this->updatedAsistenciaFecha();
        $this->tecnicos = User::role('Tecnico')->get();
    }

    public function render()
    {
        return view('livewire.admin.asistencia.create');
    }

    public function updatedAsistenciaFecha(){
        $weekday = date('w', strtotime($this->asistencia->fecha));
        switch ($weekday) {
            case 6:
                $this->asistencia->diatipo_id = 2;
                break;
            case 0:
                $this->asistencia->diatipo_id = 3;
                break;
            default:
                $this->asistencia->diatipo_id = 1;
                break;
        }
    } 

    //function to add tecnico to the array
    public function addTecnico(){
        $tec = User::find($this->new_tecnico_id);
        $this->tecnicos_selected[] = ["id" => $tec->id, "name" => $tec->name];
        $this->new_tecnico_id = '';
    }

    //function to remove tecnico from the array
    public function removeTecnico($tecnico_id){
        $this->tecnicos_selected = array_filter($this->tecnicos_selected, function($elemento) use ($tecnico_id) {
            return $elemento['id'] !== $tecnico_id;
        });
    }

    public function save(){  
        $this->validate();
        $this->asistencia->save();
        $ids = array_column($this->tecnicos_selected, 'id');
        $this->asistencia->tecnicos()->sync($ids);
        return redirect()->route('admin.asistencias.index')->with('info', 'Asistencia creada con éxito');
    }
}
