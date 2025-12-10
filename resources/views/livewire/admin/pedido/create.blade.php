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
                        <div class="col col-md-6">
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
                                    <option value="{{ $contacto->id }}">{{ $contacto->apellido_nombre }} - {{ $contacto->mail }} - {{ $contacto->puesto }}</option>
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
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>Productos del Pedido</h5>
            <div class="row">
                <div class="col col-md-12">
                    <div class="form-group">
                        <input type="text" wire:model="searchTerm" class="form-control" placeholder="Buscar productos...">
                    </div>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Destino</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detallePedidos as $index => $detalle)
                    <tr>
                        <td>{{ $detalle['descripcion'] }}</td>
                        <td>
                            <input type="number" wire:model="detallePedidos.{{ $index }}.precio" class="form-control" step="0.01">
                        </td>
                        <td>
                            <input type="number" wire:model="detallePedidos.{{ $index }}.cantidad" class="form-control" step="0.01">
                        </td>
                        <td>
                            <input type="text" wire:model="detallePedidos.{{ $index }}.destino" class="form-control">
                        </td>
                        <td>$ {{ number_format($detalle['precio'] * $detalle['cantidad'], 2, ",", ".") }}</td>
                        <td>
                            <button wire:click="removeDetallePedido({{ $index }})" class="btn btn-sm btn-danger">Eliminar</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay productos agregados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <h6>Agregar Productos</h6>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio Compra</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->descripcion_pedido }}</td>
                        <td>$ {{ number_format($product->precio_compra, 2, ",", ".") }}</td>
                        <td>
                            <button wire:click="addProduct({{ $product->id }})" class="btn btn-sm btn-success">Agregar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="plazoEntrega">Plazo Entrega</label>
                                <input type="text" wire:model.defer="pedido.plazoEntrega" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="lugarEntrega">Lugar Entrega</label>
                                <input type="text" wire:model.defer="pedido.lugarEntrega" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="condicion">Condicion</label>
                                <input type="text" wire:model.defer="pedido.condicion" class="form-control">
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="nota">Nota</label>
                                <textarea wire:model.defer="pedido.nota" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea wire:model.defer="pedido.observaciones" class="form-control" rows="3"></textarea>
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
