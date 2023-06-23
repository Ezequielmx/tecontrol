<?php

namespace App\Http\Livewire\Admin\Asistencia;

use Livewire\Component;
use App\Models\Asistencia;
use App\Models\Client;
use App\Models\Detallehoja;
use App\Models\Diatipo;
use App\Models\Hojasasistencia;
use App\Models\Quotation;
use App\Models\Trabajotipo;
use App\Models\User;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;
    
    public $asistencia;
    public $clients;
    public $trabajotipos;
    public $diatipos;
    public $tecnicos;

    public $cotizaciones;

    public $tabActivo;

    public $hojaActiva;
    public $pdf;

    public $new_tecnico_id;
    public $tecnicos_selected = [];

    public $newDetalle;
    public $newCert=0;
    public $newNro;

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
        'hojaActiva.nro' => 'required',
    ];

    public function mount(Asistencia $asistencia){
        $this->asistencia = $asistencia;
    
        $this->clients = Client::orderBy('razon_social')->get();
        $this->trabajotipos = Trabajotipo::all();
        $this->diatipos = Diatipo::all();
        $this->tecnicos = User::role('Tecnico')->get();

        foreach($this->asistencia->tecnicos as $tecnico){
            $this->tecnicos_selected[] = ["id" => $tecnico->id, "name" => $tecnico->name];
        }

        if($this->asistencia->hojas->count() > 0){
            $this->tabActivo = $this->asistencia->hojas->first()->id;
            $this->hojaActiva = $this->asistencia->hojas->first();
        }
    }

    public function render()
    {
        $this->cotizaciones = Quotation::where('client_id', $this->asistencia->client_id)->get();
        return view('livewire.admin.asistencia.edit');
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

        if($this->pdf){
            $rutaReal = realpath(storage_path('app/' . $this->hojaActiva->pdf));
            if($rutaReal && Storage::exists($rutaReal)){
                Storage::delete($this->hojaActiva->pdf);
            }

            $this->hojaActiva->pdf = $this->pdf->store('hojaAsistencia', 'public');
        }

        $this->hojaActiva->save();
        $ids = array_column($this->tecnicos_selected, 'id');
        $this->asistencia->tecnicos()->sync($ids);
        return redirect()->route('admin.asistencias.index')->with('info', 'Asistencia guardada con éxito');
    }

    public function activaTab($id)
    {
        $this->tabActivo = $id;
        $this->hojaActiva = $this->asistencia->hojas->find($id);
    }

    public function addHoja(){
        $this->validate([
            'newNro' => 'required',
        ]);

        $hoja = new Hojasasistencia();
        $hoja->nro = $this->newNro;
        $hoja->asistencia_id = $this->asistencia->id;
        $hoja->save();
        $this->asistencia = $this->asistencia->fresh();
        $this->newNro = null;
    }

    public function deleteHoja(){

        $this->hojaActiva->delete();
        $this->asistencia = $this->asistencia->fresh();
        $this->tabActivo = $this->asistencia->hojas->first()->id;
        $this->hojaActiva = $this->asistencia->hojas->first();
    }


    public function changeDetalle(Detallehoja $detallehoja, $detalle){
        $detallehoja->detalle = $detalle;
        $detallehoja->save();
        $this->hojaActiva = $this->hojaActiva->fresh();
    }

    public function changeCert(Detallehoja $detallehoja, $cert){
        $detallehoja->certificado = $cert;
        $detallehoja->save();
        $this->hojaActiva = $this->hojaActiva->fresh();
    }

    public function changeCotizacion(Detallehoja $detallehoja, $cotiz_id){
        $detallehoja->quotation_id = $cotiz_id;
        $detallehoja->save();
        $this->hojaActiva = $this->hojaActiva->fresh();
    }

    public function deleteDetalle(Detallehoja $detallehoja){
        $detallehoja->delete();
        $this->hojaActiva = $this->hojaActiva->fresh();
    }

    public function addDetalle(){
        $this->validate([
            'newDetalle' => 'required',
            'newCert' => 'required',
        ]);

        $detallehoja = new Detallehoja();
        $detallehoja->detalle = $this->newDetalle;
        $detallehoja->certificado = $this->newCert;
        $detallehoja->hojasasistencia_id = $this->hojaActiva->id;
        $detallehoja->save();

        $this->newDetalle = null;
        $this->newCert = 0;
        $this->hojaActiva = $this->hojaActiva->fresh();
    }


}
