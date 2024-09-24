<div>
    <div class="card">
        <div class="card-body">
            <div class="row" style="align-items: center;">
                <div class="col col-md-5">
                    <!--client select-->
                    <div class="form-group">
                        <label for="client_id">Cliente</label>
                        <select wire:model="client_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->razon_social }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col col-md-2">
                    <div class="form-group">
                        <label for="desde">Desde</label>
                        <input wire:model="desde" type="date" class="form-control">
                    </div>
                </div>
                <div class="col col-md-2">
                    <div class="form-group">
                        <label for="hasta">Hasta</label>
                        <input wire:model="hasta" type="date" class="form-control">
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th>Nro Asist</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Sector</th>
                        <th>Hoja Asist</th>
                        <th>Detalle</th>
                        <th>Tecnico</th>
                        <th>Fecha Borrador</th>
                        <th>Fecha Envio Cliente</th>
                        <th>Dias Borr</th>
                        <th>Dias Cert</th>
                        <th>DIas Cte</th>
                        <th>Cert</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asistencias as $asistencia)
                        @foreach ($asistencia->hojas as $hoja)
                            @foreach ($hoja->detalles as $detalle)
                                @if($detalle->certificado)
                                    <tr class="{{ $detalle->fechacliente? 'table-success' : '' }}">
                                        <td>{{ $asistencia->nro }}</td>
                                        <td style="white-space: nowrap">{{ date('d-m-Y', strtotime($asistencia->fecha)) }}</td>
                                        <td>{{ $asistencia->client->razon_social }}</td>
                                        <td>
                                            <!-- select for sector -->
                                            <select class="form-control"
                                                wire:change="changeVal({{ $detalle->id }}, 'clientssector_id' ,$event.target.value)"
                                                style="font-size: 12px; padding: 0px 2px; height: 30px; min-width: 100px;">
                                                <option value="">Seleccione</option>
                                                @foreach ($asistencia->client->sectors as $sector)
                                                <option value="{{ $sector->id }}" {{ $detalle->clientssector_id == $sector->id? 'selected' : ''
                                                    }}>
                                                    {{ $sector->sector }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>{{ $hoja->nro }}</td>
                                        <td>{{ $detalle->detalle }}</td>
                                        <td>
                                            <!-- select for tecnico -->
                                            <select class="form-control"
                                                wire:change="changeVal({{ $detalle->id }}, 'user_id' ,$event.target.value)"
                                                style="font-size: 12px; padding: 0px 2px; height: 30px;">
                                                <option value="">Seleccione</option>
                                                @foreach ($tecnicos as $tecnico)
                                                <option value="{{ $tecnico->id }}" {{ $detalle->user_id == $tecnico->id? 'selected' : ''
                                                    }}>
                                                    {{ $tecnico->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <!-- input for fecha borrador -->
                                            <input type="date" class="form-control"
                                                wire:change="changeVal({{ $detalle->id }}, 'fechaborrador' ,$event.target.value)"
                                                value='{{ $detalle->fechaborrador }}' 
                                            style="font-size: 12px; padding: 0px 2px; height: 30px;">
                                        </td>
                                        <td>
                                            <!-- input for fecha envio cliente -->
                                            <input type="date" class="form-control"
                                                wire:change="changeVal({{ $detalle->id }}, 'fechacliente' ,$event.target.value)"
                                                value='{{ $detalle->fechacliente }}' 
                                            style="font-size: 12px; padding: 0px 2px; height: 30px;">
                                        </td>
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
                                        <td>
                                            <div style="display: flex">
                                                @if ($detalle->certpdf)
                                                <div>
                                                    <a href="{{ asset('storage/'.$detalle->certpdf) }}" target="_blank"
                                                        class="btn btn-danger btn-sm"
                                                        style="padding: 2px 6px;
                                                        margin-right: 5px;">
                                                        <i class="fa fa-file-pdf"></i>
                                                    </a>
                                                </div>
                                                @endif

                                                <div class="custom-file-input">
                                                    <input type="file" wire:model="certpdf" id="file-input" class="input-file">
                                                    <label for="file-input" class="btn btn-sm"
                                                        style="margin-bottom: 0px; padding: 2px 6px;"
                                                        wire:click="seldet({{ $detalle->id }})">
                                                        <i class="fas fa-upload"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
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