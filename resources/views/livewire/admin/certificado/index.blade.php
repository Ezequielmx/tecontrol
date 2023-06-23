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
                <div class="col text-right">
                    <!--button create route creat-->
                    <a href="{{ route('admin.asistencias.create') }}" class="btn btn-success btn-sm">Nueva
                        Asistencia</a>
                </div>
            </div>


        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nro</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Hoja Asist</th>
                        <th>Detalle</th>
                        <th>Tecnico</th>
                        <th>Fecha Borrador</th>
                        <th>Fecha Envio Cliente</th>
                        <th>Dias Borr</th>
                        <th>Dias Cert</th>
                        <th>DIas Cte</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asistencias as $asistencia)
                    @foreach ($asistencia->hojas as $hoja)
                    @foreach ($hoja->detalles as $detalle)
                    @if($detalle->certificado)
                    <tr>
                        <td>{{ $asistencia->nro }}</td>
                        <td style="white-space: nowrap">{{ date('d-m-Y', strtotime($asistencia->fecha)) }}</td>
                        <td>{{ $asistencia->client->razon_social }}</td>
                        <td>{{ $hoja->nro }}</td>
                        <td>{{ $detalle->detalle }}</td>
                        <td>
                            <!-- select for tecnico -->
                            <select class="form-control"
                                wire:change="changeVal({{ $detalle->id }}, 'user_id' ,$event.target.value)">
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
                                value={{ $detalle->fechaborrador }}>
                        </td>
                        <td>
                            <!-- input for fecha envio cliente -->
                            <input type="date" class="form-control"
                                wire:change="changeVal({{ $detalle->id }}, 'fechacliente' ,$event.target.value)"
                                value={{ $detalle->fechacliente }}>
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