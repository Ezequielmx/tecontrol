<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Asistencia;
use App\Models\Detallehoja;
use App\Models\Hojasasistencia;
use ZipArchive;
use Illuminate\Support\Carbon;
use App\Models\Client;

class Clientecert extends Component
{
    public $detallehojas;
    public $cliente;

    public function mount()
    {
    }

    public function render()
    {

        $cliente = auth()->user()->client_id;
        $this->cliente = Client::find($cliente);
        $this->detallehojas = Detallehoja::with('hojasasistencia.asistencia')->whereHas('hojasasistencia', function ($query) use ($cliente) {
            $query->whereHas('asistencia', function ($query) use ($cliente) {
                $query->where('client_id', $cliente);
            });
        })
            ->where('certpdf', '!=', null)	
            ->join('hojasasistencias', 'detallehojas.hojasasistencia_id', '=', 'hojasasistencias.id')
            ->join('asistencias', 'hojasasistencias.asistencia_id', '=', 'asistencias.id')
            ->select('detallehojas.id as did','detallehojas.*', 'asistencias.fecha', 'hojasasistencias.*')
            ->orderBy('asistencias.fecha', 'desc')
            ->orderBy('hojasasistencia_id')
            ->get();

        
        return view('livewire.clientecert');
        
    }

    public function downlCertsHoja($hoja_id)
    {
        $hojasasistencia = Hojasasistencia::with('detalles')->find($hoja_id);

        $zip = new ZipArchive();
        $zipFilename = 'archivo.zip';
        //dd($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE));

        if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($hojasasistencia->detalles as $detalle) {
                if ($detalle->certpdf == null) {
                    continue;
                }

                $rutaArchivo =  storage_path('/app/public/' . $detalle->certpdf);
                //dd(file_exists($rutaArchivo), $detalle->certpdf, $rutaArchivo);
                if (file_exists($rutaArchivo)) {
                    $zip->addFile($rutaArchivo, $detalle->id . '.pdf');
                    //dd($zip);
                }
            }

            $zip->close();

            return response()->download($zipFilename)->deleteFileAfterSend();
        } else {
            // Manejar el caso en el que no se pueda crear el archivo zip
        }
    }

    public function mesCount($anio, $mes)
    {
        $certCount = $this->detallehojas->filter(function ($detallehoja) use ($anio, $mes) {
            $fechaAsistencia = Carbon::createFromFormat('Y-m-d', $detallehoja->asistencia->fecha);
            
            return $fechaAsistencia->format('Y') == $anio &&
                   $fechaAsistencia->format('m') == $mes && $detallehoja->certpdf != null;
        })->count();

        return $certCount;
    }

    public function downlCertMes($anio, $mes)
    {
        $cliente = auth()->user()->client_id;
        $detallehojas = Detallehoja::with('hojasasistencia.asistencia')->whereHas('hojasasistencia', function ($query) use ($cliente) {
            $query->whereHas('asistencia', function ($query) use ($cliente) {
                $query->where('client_id', $cliente);
            });
        })
            ->where('certificado', 1)
            ->join('hojasasistencias', 'detallehojas.hojasasistencia_id', '=', 'hojasasistencias.id')
            ->join('asistencias', 'hojasasistencias.asistencia_id', '=', 'asistencias.id')
            ->select('detallehojas.id as did','detallehojas.*', 'asistencias.fecha', 'hojasasistencias.*')
            ->orderBy('asistencias.fecha', 'desc')
            ->orderBy('hojasasistencia_id')
            ->get();

        $zip = new ZipArchive();
        $zipFilename = 'archivo.zip';

        if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($detallehojas as $detalle) {
                if ($detalle->certpdf == null) {
                    continue;
                }
                $fechaAsistencia = Carbon::createFromFormat('Y-m-d', $detalle->fecha);
                if($fechaAsistencia->format('Y') != $anio || $fechaAsistencia->format('m') != $mes){
                    continue;
                }
                $rutaArchivo =  storage_path('/app/public/' . $detalle->certpdf);
                if (file_exists($rutaArchivo)) {
                    $zip->addFile($rutaArchivo, $detalle->did . '.pdf');
                }
            }

            $zip->close();

            return response()->download($zipFilename)->deleteFileAfterSend();
        } else {
            // Manejar el caso en el que no se pueda crear el archivo zip
        }
    }
}
