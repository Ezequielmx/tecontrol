<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-4">
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $cliente->razon_social }}</h1>
                </div>
                <div class="col-md-3">
                    @if($sectores->count() > 0)
                    <div class="form-group">
                        <label for="sector_id">Sector</label>
                        <select wire:model="sector_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach ($sectores as $sector)
                            <option value="{{ $sector->id }}">{{ $sector->sector }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sector_id">Buscar</label>
                        <div class="input-group mb-3">
                            <input wire:model="search" type="text" class="form-control" placeholder="Buscar...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" wire:click="clear"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Certificados</div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tbody>
                                    @php
                                    setlocale(LC_TIME, "es_ES");
                                    $anio = '';
                                    $mes = '';
                                    $hojanro = '';

                                    $meses = [
                                    1 => 'enero',
                                    2 => 'febrero',
                                    3 => 'marzo',
                                    4 => 'abril',
                                    5 => 'mayo',
                                    6 => 'junio',
                                    7 => 'julio',
                                    8 => 'agosto',
                                    9 => 'septiembre',
                                    10 => 'octubre',
                                    11 => 'noviembre',
                                    12 => 'diciembre',
                                    ];
                                    @endphp
                                    @foreach ($detallehojas as $detalles)
                                    @if($anio != date('Y', strtotime($detalles->fecha)) || $mes != date('m',
                                    strtotime($detalles->fecha)))
                                    <tr class="table-primary">
                                        <td colspan="5">
                                            <div style="display:flex;">
                                                <div style="width: 50%">
                                                    <strong>{{ date('Y', strtotime($detalles->fecha)) }} - {{
                                                        $meses[date('n', strtotime($detalles->fecha))] }}
                                                    </strong>
                                                </div>
                                                <div style="width: 50%; text-align:right">

                                                    <button
                                                        wire:click="downlCertMes({{ date('Y', strtotime($detalles->fecha)) }}, {{ date('m', strtotime($detalles->fecha)) }})"
                                                        class="btn btn-primary btn-sm" style="padding: 2px 6px;
                                                                            margin-right: 5px;">
                                                        <i class="fa fa-download"></i> Descargar
                                                        certificados del mes
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                    $anio = date('Y', strtotime($detalles->fecha));
                                    $mes = date('m', strtotime($detalles->fecha));
                                    @endphp
                                    @endif
                                    @if($hojanro != $detalles->hojasasistencia_id)
                                    <tr class="table-warning">
                                        <td style="width:5%"></td>
                                        <td colspan="4">
                                            <div style="display:flex;">
                                                <div style="width:5%">
                                                    @if($detalles->hojasasistencia->pdf)

                                                    <a href="{{ asset('storage/'.$detalles->hojasasistencia->pdf) }}"
                                                        target="_blank" class="btn btn-danger btn-sm" style="padding: 2px 6px;
                                                                        margin-right: 5px;">
                                                        <i class="fa fa-file-pdf"></i>
                                                    </a>
                                                    @endif
                                                </div>
                                                <div style="width: 45%">
                                                    <strong>Hoja Asistencia:
                                                        {{ $detalles->hojasasistencia->nro
                                                        }}</strong>
                                                </div>

                                                <div style="width: 50%; text-align:right">
                                                    @if($detalles->hojasasistencia->detalles->where('certpdf','!=',
                                                    null)->count()>0)
                                                    <button
                                                        wire:click="downlCertsHoja({{ $detalles->hojasasistencia->id }})"
                                                        class="btn btn-warning btn-sm" style="padding: 2px 6px;
                                                                            margin-right: 5px;">
                                                        <i class="fa fa-download"></i> Descargar
                                                        certificados de la hoja
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                    $hojanro = $detalles->hojasasistencia_id;
                                    @endphp
                                    @endif
                                    <tr>
                                        <td style="width:5%"></td>
                                        <td style="width:5%"></td>
                                        <td>{{ $detalles->detalle }}</td>
                                        <td style="white-space: nowrap">{{ date('d-m-Y',
                                            strtotime($detalles->fecha)) }}
                                        </td>
                                        <td>
                                            @if ($detalles->certpdf)
                                            <div>
                                                <a href="{{ asset('storage/'.$detalles->certpdf) }}" target="_blank"
                                                    class="btn btn-danger btn-sm" style="padding: 2px 6px;
                                                    margin-right: 5px;">
                                                    <i class="fa fa-file-pdf"></i>
                                                </a>
                                            </div>
                                            @endif
                                        </td>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Patrones</div>
                        </div>
                        <div class="card-body">
                            @foreach ($anios as $anio)
                            <!--button for download patrones from year-->
                            <button wire:click="downlPatrones({{ $anio->anio }})" class="btn btn-primary btn-sm mb-2"
                                style="padding: 2px 6px; margin-right: 5px;">
                                <i class="fa fa-download"></i> {{ $anio->anio }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--show loading when wire is working-->
    <div wire:loading>
        <div
            style=" position: fixed;  top:0; left: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #00000080; width: 100vw;">
            <div class="text-white">Cargando...</div>
        </div>
    </div>
</div>