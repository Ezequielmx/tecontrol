<div>
    <div class="card">
        <div class="card-body">
            <div class="row" style="align-items: center;">
                <div class="col col-md-4">
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
                        <label for="hojanro">Hoja nro</label>
                        <input wire:model="hojanro" type="text" class="form-control">
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
                        <th>Hojas</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Programada</th>
                        <th>Tipo Trabajo</th>
                        <th>Horas</th>
                        <th>Horas Espera</th>
                        <th>Tecnicos</th>
                        <th style="width: 10px;">Acciones</th>
                    </tr>
                </thead>
                @foreach ($asistencias as $asistencia)
                <tr>
                    <td>{{ $asistencia->id }}</td>
                    <td>
                        @foreach ($asistencia->hojas as $hoja)
                        {{ $hoja->nro }}<br>
                        @endforeach
                    </td>
                    <td>{{ $asistencia->client->razon_social }}</td>
                    <td>{{ date('d-m-Y', strtotime($asistencia->fecha)) }}</td>
                    <td>{{ $asistencia->programado? 'SI' : 'NO' }}</td>
                    <td>{{ $asistencia->trabajotipo->tipo }}</td>
                    <td>{{ $asistencia->horas_trabajo }}</td>
                    <td>{{ $asistencia->horas_espera }}</td>
                    <td>{{ $asistencia->tecnicos->count() }}</td>
                    <td>
                        <a href="{{ route('admin.asistencias.edit', $asistencia) }}"
                            class="btn btn-primary btn-sm">Editar</a>
                    </td>
                </tr>
                @endforeach
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