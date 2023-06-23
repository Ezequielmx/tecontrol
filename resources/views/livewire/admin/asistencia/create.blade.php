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
                                <select wire:model.defer="asistencia.trabajotipo_id" class="form-control" id="trabajotipo_id">
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
                        <textarea wire:model.defer="asistencia.reclamo_detalle" class="form-control" id="reclamo" rows="8" {{
                            !$asistencia->reclamo? 'disabled' : '' }}></textarea>
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
                        <textarea wire:model.defer="asistencia.accidente_detalle" class="form-control" id="reclamo" rows="8"
                            {{ !$asistencia->accidente? 'disabled' : '' }}></textarea>
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