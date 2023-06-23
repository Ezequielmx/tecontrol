<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1">
                            <!--input for id-->
                            <div class="form-group">
                                <label for="nro" class="form-label">Nro</label>
                                <input type="text" wire:model.defer="asistencia.nro" class="form-control" id="nro">
                            </div>
                            @error('asistencia.id')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <!--input for fecha-->
                            <div class="form-group">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" wire:model="asistencia.fecha" class="form-control" id="fecha">
                            </div>
                            @error('asistencia.fecha')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <!--select for diatipo-->
                            <div class="form-group">
                                <label for="diatipo_id" class="form-label">Tipo de Dia</label>
                                <select wire:model.defer="asistencia.diatipo_id" class="form-control" id="diatipo_id">
                                    <option value="">Seleccione</option>
                                    @foreach($diatipos as $diatipo)
                                    <option value="{{$diatipo->id}}">{{$diatipo->tipo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('asistencia.diatipo_id')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <!--select for client-->
                                <label for="client_id" class="form-label">Cliente</label>
                                <select wire:model.defer="asistencia.client_id" class="form-control" id="client_id">
                                    <option value="">Seleccione</option>
                                    @foreach($clients as $client)
                                    <option value="{{$client->id}}">{{$client->razon_social}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('asistencia.client_id')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <!--select for trabajotipo_id -->
                                <label for="trabajotipo_id" class="form-label">Tipo de trabajo</label>
                                <select wire:model.defer="asistencia.trabajotipo_id" class="form-control"
                                    id="trabajotipo_id">
                                    <option value="">Seleccione</option>
                                    @foreach($trabajotipos as $trabajotipo)
                                    <option value="{{$trabajotipo->id}}">{{$trabajotipo->tipo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('asistencia.trabajotipo_id')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group text-center">
                                <!--checkbox for programado-->
                                <label for="programado" class="form-label">Programado</label>
                                <input type="checkbox" wire:model.defer="asistencia.programado" class="form-control"
                                    id="programado">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <!--input for horas_trabajo-->
                                <label for="horas_trabajo" class="form-label">Horas</label>
                                <input type="number" wire:model.defer="asistencia.horas_trabajo" class="form-control"
                                    id="horas_trabajo" min=0>
                            </div>
                            @error('asistencia.horas_trabajo')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-md-1">
                            <div class="form-group text-center">
                                <!--checkbox for programado-->
                                <label for="tecnico_she" class="form-label">Técnico SHE</label>
                                <input style="height: 20px;" type="checkbox" wire:model="asistencia.tecnico_she"
                                    class="form-control" id="tecnico_she">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="horas_she" class="form-label">Horas SHE</label>
                                <input type="number" wire:model.defer="asistencia.horas_she" class="form-control"
                                    id="horas_she" {{ !$asistencia->tecnico_she? 'disabled' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <!--input for horas_espera-->
                                <label for="horas_espera" class="form-label">Horas Espera</label>
                                <input type="number" wire:model.defer="asistencia.horas_espera" class="form-control"
                                    id="horas_espera" min=0>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <b>Tecnicos</b>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                            @foreach($tecnicos_selected as $tecnico)
                            <tr>
                                <td>{{$tecnico['name']}}</td>
                                <td>
                                    <!-- button for delete tecnico-->
                                    <button wire:click="removeTecnico({{$tecnico['id']}})"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>
                                    <!--select for tecnico_id-->
                                    <select wire:model.defer="new_tecnico_id" class="form-control" id="new_tecnico_id">
                                        <option value="">Seleccione</option>
                                        @foreach($tecnicos as $tecnico)
                                        <option value="{{$tecnico->id}}">{{$tecnico->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <!-- button for add tecnico-->
                                    <button wire:click="addTecnico" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card {{ !$asistencia->reclamo? 'bg-light' : 'bg-warning' }}">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <b>Reclamo</b>
                        </div>
                        <div class="col-md-2">
                            <input style="height: 20px" type="checkbox" wire:model="asistencia.reclamo"
                                class="form-control" id="reclamo">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <!-- text area for reclamo-->
                        <textarea wire:model.defer="asistencia.reclamo_detalle" class="form-control" id="reclamo"
                            rows="8" {{ !$asistencia->reclamo? 'disabled' : '' }}></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card {{ !$asistencia->accidente? 'bg-light' : 'bg-danger' }}">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <b>Accidente</b>
                        </div>
                        <div class="col-md-2">
                            <input style="height: 20px" type="checkbox" wire:model="asistencia.accidente"
                                class="form-control" id="accidente">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <!-- text area for accidente-->
                        <textarea wire:model.defer="asistencia.accidente_detalle" class="form-control" id="reclamo"
                            rows="8" {{ !$asistencia->accidente? 'disabled' : '' }}></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <b>Encuesta</b>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="encuesta_conformidad" class="col-sm-8 col-form-label">Conformidad del
                            servicio</label>
                        <div class="col-sm-4">
                            <select wire:model.defer="asistencia.encuesta_conformidad" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="encuesta_personal" class="col-sm-8 col-form-label">Atención Personal Técnico</label>
                        <div class="col-sm-4">
                            <select wire:model.defer="asistencia.encuesta_personal" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="encuesta_tiempo" class="col-sm-8 col-form-label">Tiempo de Ejecución del
                            Servicio</label>
                        <div class="col-sm-4">
                            <select wire:model.defer="asistencia.encuesta_tiempo" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" style="display: flex;
        background-color: rgba(0,0,0,.03);">
            <div style="width: 65%">
                <ul class="nav nav-tabs card-header-tabs">
                    @foreach ($asistencia->hojas as $hoja)
                    <li class="nav-item">
                        <button class="nav-link  {{ $tabActivo == $hoja->id? 'active' : '' }}" id="{{ $hoja->id }}-tab"
                            data-bs-toggle="tab" data-bs-target="#{{ $hoja->id }}" type="button" role="tab"
                            aria-controls="vales" aria-selected="true" style="font-weight: bold;font-size: large;"
                            wire:click="activaTab('{{ $hoja->id }}')">
                            {{ $hoja->nro }}
                        </button>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="text-right" style="width: 35%">
                <div class="form-group row" style="margin-bottom: -6px;">
                    <label for="newNro" class="col-sm-3 col-form-label">Nueva Hoja</label>
                    <div class="col-sm-6">
                        <input type="text" wire:model.defer="newNro" class="form-control" id="newNro">
                        @error('newNro')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-sm btn-primary" wire:click="addHoja">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @isset($hojaActiva)
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group row">
                        <label for="hojaActiva.nro" class="col-sm-4 col-form-label">Nro. Hoja</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model.defer="hojaActiva.nro" class="form-control"
                                id="hojaActiva.nro">
                            @error('hojaActiva.nro')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group row">
                        <label for="pdf" class="col-sm-2 col-form-label" style="text-align: end;">Pdf
                            @if ($hojaActiva->pdf)
                            <a href="{{ asset('storage/'.$hojaActiva->pdf) }}" target="_blank"> Abrir</a>
                            @endif
                        </label>
                        <div class="col-sm-8" style="display: flex; align-content: center; align-items: center;">
                            <input type="file" wire:model="pdf" class="form-control-file">
                        </div>
                        <!-- if isset ordenCompra show link for download-->
                    </div>
                </div>
                <div class="col-md-2" style="text-align: end;">
                    <!--button for delete hoja-->
                    <button class="btn btn-sm btn-danger" wire:click="deleteHoja">Eliminar Hoja</button>
                </div>
            </div>
            <div class="row">
                <table class="table table-striped table-sm" style="font-size: 13px;">
                    <thead>
                        <tr>
                            <th>Detalle</th>
                            <th>Cert</th>
                            <th>Cotizacion</th>
                            <th>Tecnico</th>
                            <th>Fecha Borrador</th>
                            <th>Fecha Cliente</th>
                            <th>Dias Borr</th>
                            <th>Dias Cert</th>
                            <th>Dias Cte</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hojaActiva->detalles as $detalle)
                        <tr class="{{ !$detalle->certificado || $detalle->fechacliente? 'table-success' : '' }}">
                            <td style="min-width: 500px;">
                                <input type="text" class="form-control" value="{{ $detalle->detalle }}"
                                    style="font-size: 13px; height: 26px;"
                                    wire:change='changeDetalle({{ $detalle->id }}, $event.target.value)'>
                            </td>
                            <!-- checkbox for detalle->certificado-->
                            <td>
                                <input type="checkbox" class="form-control" {{ $detalle->certificado? 'checked' : '' }}
                                style="height: 20px;"
                                wire:change='changeCert({{ $detalle->id }}, $event.target.checked)'>
                            </td>
                            <td>
                                <!-- select for cotizaciones -->
                                <select class="form-control" style="font-size: 13px; height: 26px; padding: 0px 6px;"
                                    wire:change='changeCotizacion({{ $detalle->id }}, $event.target.value)'>
                                    <option value="">Seleccione</option>
                                    @foreach ($cotizaciones as $cotizacion)
                                    <option value="{{ $cotizacion->id }}" {{ $detalle->quotation_id == $cotizacion->id?
                                        'selected' : '' }}>
                                        {{ $cotizacion->nro }} - {{ $cotizacion->quotationState->state }}
                                    </option>
                                    @endforeach
                            </td>
                            <td>
                                @isset($detalle->user)
                                {{ $detalle->user->name }}
                                @endisset
                            </td>
                            <td>
                                @isset($detalle->fechaborrador)
                                {{ date('d-m-Y', strtotime($detalle->fechaborrador)) }}
                                @endisset
                            </td>
                            <td>
                                @isset($detalle->fechacliente)
                                {{ date('d-m-Y', strtotime($detalle->fechacliente)) }}
                                @endisset
                            </td>
                            @if($detalle->certificado)
                            <td>
                                @if($detalle->fechaborrador)
                                {{ date_diff(date_create($asistencia->fecha),
                                date_create($detalle->fechaborrador))->format('%R%a') }}
                                @else
                                {{ date_diff(date_create($asistencia->fecha),
                                date_create(date('Y-m-d')))->format('%R%a') }}
                                @endif

                            </td>
                            <td>
                                @if($detalle->fechacliente)
                                {{ date_diff(date_create($detalle->fechaborrador),
                                date_create($detalle->fechacliente))->format('%R%a') }}
                                @endif
                            </td>
                            <td>
                                @if($detalle->fechacliente)
                                {{ date_diff(date_create($asistencia->fecha),
                                date_create($detalle->fechacliente))->format('%R%a') }}
                                @endif
                            </td>
                            @else
                            <td></td>
                            <td></td>
                            <td></td>
                            @endif
                            <td>
                                <button class="btn btn-sm btn-danger" wire:click="deleteDetalle({{ $detalle->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control" wire:model.defer="newDetalle">
                                </div>
                                @error('newDetalle')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="checkbox" class="form-control" style="height: 20px;"
                                        wire:model.defer="newCert">
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary" wire:click="addDetalle">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endisset
        </div>
    </div>


    <div class="row">
        <div class="col text-right">
            <button wire:click="save" class="btn btn-sm btn-success">Guardar</button>
            <a href="{{ route('admin.asistencias.index') }}" class="btn btn-sm btn-secondary">Cancelar</a>
        </div>
    </div>


    <div wire:loading>
        <div class="modload">
            <div class="spinload">
                <i class="fa-solid fa-temperature-three-quarters fa-bounce2"></i>
            </div>
        </div>
    </div>
</div>