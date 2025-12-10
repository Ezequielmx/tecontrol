<div>
    <div class="row">
        <div class="col col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-1">
                            <div class="form-group">
                                <label for="nro">Nro</label>
                                <input type="text" wire:model.defer="pedido.nro" class="form-control"
                                    placeholder="Nro. Pedido">
                            </div>
                        </div>
                        <div class="col col-md-2">
                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input type="date" wire:model.defer="pedido.fecha" class="form-control"
                                    placeholder="Fecha">
                            </div>
                        </div>
                        @if (auth()->user()->hasRole('Admin'))
                        <div class="col col-md-2">
                            <div class="form-group">
                                <label for="user_id">Usuario</label>
                                <select wire:model="pedido.user_id" class="form-control">
                                    <option value="">Seleccione un usuario</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('pedido.user_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col col-md-4">
                        @else
                        <div class="col col-md-6">
                        @endif
                            <div class="form-group">
                                <label for="supplier_id">Proveedor</label>
                                <select wire:model="pedido.supplier_id" class="form-control">
                                    <option value="">Seleccione un proveedor</option>
                                    @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->razon_social }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col col-md-3">
                            <div class="form-group">
                                <label for="pedido_state_id">Estado</label>
                                <select wire:model.defer="pedido.pedido_state_id" class="form-control">
                                    @foreach ($pedidoStates as $pedidoState)
                                    <option value="{{ $pedidoState->id }}">{{ $pedidoState->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3">
                            <div class="form-group">
                                <label for="contacto_id">Contacto</label>
                                <select wire:model.defer="pedido.contacto" class="form-control">
                                    <option value="">Seleccione un contacto</option>
                                    @foreach ($contacts as $contacto)
                                    <option value="{{ $contacto->id }}">{{ $contacto->apellido_nombre }} - {{
                                        $contacto->mail }}
                                        -
                                        {{ $contacto->puesto }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col col-md-7">
                            <div class="form-group">
                                <label for="ref">Ref.</label>
                                <input type="text" wire:model="pedido.ref" class="form-control" placeholder="Ref.">
                            </div>
                        </div>
                        <div class="col col-md-2">
                            <div class="form-group">
                                <label for="nroPedido">Nro Pedido Prov.</label>
                                <input type="text" wire:model.defer="pedido.nroPedido" class="form-control"
                                    placeholder="Nro Pedido">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-2">
                            <div class="form-group">
                                <label for="fecha_contacto">Fecha Contacto</label>
                                <input type="date" wire:model.defer="pedido.fechaContacto" class="form-control"
                                    placeholder="Fecha Contacto">
                            </div>
                        </div>
                        <div class="col col-md-10">
                            <div class="form-group">
                                <label for="detalle_contacto">Detalle Contacto</label>
                                <input type="text" wire:model.defer="pedido.detalleContacto" class="form-control"
                                    placeholder="Detalle Contacto">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Total</label>
                                <span class="badge badge-success" style="font-size: 1.2em;
                                width:100%;
                                height:38px;
                                display: flex;
                                align-items: center;
                                justify-content: flex-end;">
                                    $ {{ number_format($total,2,",",".") }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Recibido</label>
                                <span class="badge badge-primary" style="font-size: 1.2em;
                                    width:100%;
                                    height:38px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: flex-end;">
                                    $ {{ number_format($recibido,2,",",".") }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Pendiente Recibir</label>
                                <span class="badge {{ $difRecibido!=0? 'badge-danger' : 'badge-success' }}" style="font-size: 1.2em;
                                width:100%;
                                height:38px;
                                display: flex;
                                align-items: center;
                                justify-content: flex-end;">
                                    $ {{ number_format($difRecibido,2,",",".") }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('admin.pedido.pedidodetails', ['pedido' => $pedido])

    <div class="row">
        <div class="col col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="plazoEntrega">Plazo Entrega</label>
                                <input type="text" wire:model.defer="pedido.plazoEntrega" class="form-control"
                                    placeholder="Plazo Entrega">
                            </div>
                            <div class="form-group">
                                <label for="lugarEntrega">Lugar Entrega</label>
                                <input type="text" wire:model.defer="pedido.lugarEntrega" class="form-control"
                                    placeholder="Lugar Entrega">
                            </div>
                            <div class="form-group">
                                <label for="condicion">Condicion</label>
                                <input type="text" wire:model.defer="pedido.condicion" class="form-control"
                                    placeholder="Condicion">
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="nota">Nota</label>
                                <textarea wire:model.defer="pedido.nota"
                                    class="form-control" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea wire:model.defer="pedido.observaciones"
                                    class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label for="solicitudPedido">Solicitud Pedido
                                    @if ($pedido->solicitudPedido)
                                    <a href="{{ asset('storage/'.$pedido->solicitudPedido) }}"
                                        target="_blank">Abrir</a>
                                    @endif
                                </label>
                                <input type="file" wire:model.defer="solicitudPedido" class="form-control-file"
                                    style="font-size: 12px;">
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label for="pedidoFile">Pedido
                                    @if ($pedido->pedido)
                                    <a href="{{ asset('storage/'.$pedido->pedido) }}" target="_blank">Abrir</a>
                                    @endif
                                </label>
                                <input type="file" wire:model="pedidoFile" class="form-control-file"
                                    style="font-size: 12px;">
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label for="ordenCompra">Orden Compra
                                    @if ($pedido->ordenCompra)
                                    <a href="{{ asset('storage/'.$pedido->ordenCompra) }}" target="_blank">Abrir</a>
                                    @endif
                                </label>
                                <input type="file" wire:model="ordenCompra" class="form-control-file"
                                    style="font-size: 12px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-right pt-2 pb-2">
        <button class="btn btn-primary" wire:click="guardar">Guardar</button>
        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>

    <div wire:loading>
        <div class="modload">
            <div class="spinload">
                <i class="fa-solid fa-temperature-three-quarters fa-bounce2"></i>
            </div>
        </div>
    </div>
</div>
