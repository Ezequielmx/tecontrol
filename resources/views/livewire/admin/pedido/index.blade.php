<div>
    <div class="card">
        <div class="card-body">
            <div class="row" style="align-items: center;">
                <div class="col col-md-1">
                    <div class="form-group">
                        <label for="pedido_nro">N° Pedido</label>
                        <input type="text" wire:model="pedido_nro" class="form-control">
                    </div>
                </div>
                <div class="col col-md-3">
                    <div class="form-group">
                        <label for="supplier_id">Proveedor</label>
                        <select wire:model="supplier_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->razon_social }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col col-md-2">
                    <div class="form-group">
                        <label for="estado_id">Estado</label>
                        <select wire:model="estado_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach ($pedidoStates as $pedidoState)
                            <option value="{{ $pedidoState->id }}">{{ $pedidoState->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col col-md-2">
                    <div class="form-group">
                        <label for="nroPedido">N° Pedido Prov.</label>
                        <input type="text" wire:model="nroPedido" class="form-control">
                    </div>
                </div>
                <div class="col col-md-1 text-center">
                    <div class="form-group">
                        <label for="finalizados">Finalizados</label>
                        <input wire:model="finalizados" type="checkbox" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button wire:click="borrarFiltros" class="btn btn-outline-secondary mt-4"><i
                                class="fas fa-eraser"></i> Borrar Filtros</button>
                    </div>
                </div>
                <div class="col text-right">
                    <a href="{{ route('admin.pedidos.create') }}" class="btn btn-success btn-sm mt-4">Nuevo Pedido</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>id</th>
                        <th>Creado por</th>
                        <th>Fecha</th>
                        <th>Tiempo</th>
                        <th>Nro</th>
                        <th>Proveedor</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th style="width: 10px;">Acciones</th>
                    </tr>
                </thead>
                @foreach ($pedidos as $pedido)
                <tr wire:click='selPed({{ $pedido->id }})'>
                    <td>
                        <button class="btn btn-default btn-xs"><i class="fa-regular fa-eye"></i></button>
                    </td>
                    <td>{{ $pedido->id }}</td>
                    <td>{{ $pedido->user->name }}</td>
                    <td>{{ date('d/m/Y', strtotime($pedido->fecha)) }}</td>
                    <td>{{ intval((time() - strtotime($pedido->fecha)) / 86400) }} días</td>
                    <td>{{ $pedido->nro }}</td>
                    <td style="width:30%">{{ isset($pedido->supplier)? $pedido->supplier->razon_social : '' }}
                    </td>
                    <td class="text-right">$ {{ number_format($pedido->total(), 2, ",", ".") }}</td>
                    <td>{{ $pedido->pedidoState->nombre }}</td>
                    <td style="white-space:nowrap">
                        <a href="{{ route('admin.pedidos.edit', $pedido) }}"
                            class="btn btn-sm btn-primary">Editar</a>
                        <button wire:click="$emit('deletePed',{{ $pedido->id }})"
                            class="btn btn-sm btn-danger">Eliminar</button>
                    </td>
                </tr>
                <tr></tr>
                <tr class={{ ($selected_id==$pedido->id)? '' : 'hiddenRow' }}>
                    <td></td>
                    <td colspan="9">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th style="width: 10%">Precio Unit</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Destino</th>
                                    <th>Recibido</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detallePedidos as $detalle)
                                <tr>
                                    <td>
                                        {{ $detalle->product ? $detalle->product->descripcion_pedido : $detalle->descripcion }}
                                    </td>
                                    <td style="min-width: 180px;">
                                        $ {{ number_format($detalle->precio,2,",",".") }}
                                    </td>
                                    <td style="width: 1%">
                                        {{ $detalle->cantidad }}
                                    </td>
                                    <td style="white-space: nowrap; text-align:end">
                                        $ {{ number_format($detalle->precio * $detalle->cantidad,2,",",".")}}
                                    </td>
                                    <td>
                                        {{ $detalle->destino }}
                                    </td>
                                    <td style="width: 1%">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-control" {{ $detalle->recibido?
                                            'checked' : '' }}
                                            style="width:50%" disabled>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="card-footer">
            {{ $pedidos->links() }}
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
