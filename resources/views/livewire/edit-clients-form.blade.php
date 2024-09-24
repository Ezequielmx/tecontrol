<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Cliente</h3>
            <div class="card-tools">
                <button wire:click="saveClient" class="btn btn-primary btn-sm">Guardar</button>
            </div>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="razon-social">Razón Social</label>
                            <input type="text" wire:model="client.razon_social" class="form-control" id="razon-social">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="tipo-cliente">Tipo de Cliente</label>
                            <select wire:model="client.tipo_cliente" class="form-control" id="tipo-cliente">
                                <option value="">Seleccione un estado</option>
                                <option value="1">PENDIENTE</option>
                                <option value="2">CONFIRMADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="cuit">CUIT</label>
                            <input type="text" wire:model="client.cuit" class="form-control" id="cuit">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" wire:model="client.telefono" class="form-control" id="telefono">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" wire:model="client.direccion" class="form-control" id="direccion">
                        </div>

                        <div class="form-group">
                            <label for="condicion">Condición</label>
                            <input type="text" wire:model="client.condicion" class="form-control" id="condicion">
                        </div>
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea wire:model="client.observaciones" class="form-control"
                                id="observaciones"></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        @if($selectedClientId)
                        <div class="form-group">
                            <label for="observaciones">Sectores</label>
                            <table>
                                @foreach($client->sectors as $sector)
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" value="{{ $sector->sector }}" 
                                        wire:change = 'changeNombre({{ $sector->id }}, $event.target.value)'>
                                    </td>
                                    <td>
                                        <button wire:click="removeSector({{ $sector->id }})" class="btn btn-danger btn-sm" {{ $sector->certificados->count() > 0? 'disabled' : '' }}>X</button>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" wire:model="newSector">
                                    </td>
                                    <td>
                                         <button wire:click="addSector" class="btn btn-success btn-sm" {{ $newSector == null? 'disabled' : '' }}>+</button>
                                    </td>
                            </table>
                        </div>
                        @endif
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>