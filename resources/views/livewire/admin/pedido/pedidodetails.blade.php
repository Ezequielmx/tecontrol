<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th style="width: 10%">Precio Unit</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Destino</th>
                                <th>Cotización</th>
                                <th>Recibido</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detallePedidos as $detalle)
                            <tr>
                                <td>
                                    {{ $detalle->product ? $detalle->product->descripcion_pedido : $detalle->descripcion }}
                                </td>
                                <td style="min-width: 180px;">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">$</div>
                                        </div>
                                        <input type="number"
                                            wire:change="cambioPrecio($event.target.value, {{ $detalle->id }})"
                                            class="form-control text-right" value="{{ $detalle->precio }}" step="0.01">
                                    </div>
                                </td>
                                <td style="width: 10%">
                                    <input type="number"
                                        wire:change="cambioCantidad($event.target.value, {{ $detalle->id }})"
                                        class="form-control text-right" value="{{ $detalle->cantidad }}" step="0.01">
                                </td>
                                <td style="white-space: nowrap; text-align:end">
                                    $ {{ number_format($detalle->precio * $detalle->cantidad,2,",",".")}}
                                </td>
                                <td style="width: 15%">
                                    <select wire:change="cambioDestino($event.target.value, {{ $detalle->id }})" class="form-control">
                                        <option value="">Seleccione cliente</option>
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" {{ $detalle->destino == $client->id ? 'selected' : '' }}>
                                            {{ $client->razon_social }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="width: 10%">
                                    <input type="text" wire:change="cambioCotizacion($event.target.value, {{ $detalle->id }})"
                                        class="form-control" value="{{ $detalle->cotizacion }}" placeholder="N° Cotiz.">
                                </td>
                                <td style="width: 5%">
                                    <div class="form-check">
                                        <input type="checkbox"
                                            wire:change="cambioRecibido($event.target.checked, {{ $detalle->id }})"
                                            class="form-control" {{ $detalle->recibido? 'checked' : '' }}
                                        style="width:50%">
                                    </div>
                                </td>
                                <td>
                                    <button wire:click="$emit('deleteDet', {{ $detalle->id }})"
                                        class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#productModal">Agregar
                        Producto</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="max-height: 90vh; overflow: scroll;">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="productModalLabel">Productos</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" wire:model="searchTerm" class="form-control" placeholder="Buscar...">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Descripcion</th>
                                <th>Precio Compra</th>
                                <th>Stock</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->descripcion_pedido }}</td>
                                <td>$ {{ number_format($product->precio_compra,2,",",".") }}</td>
                                <td>{{ $product->stock_inicial }}</td>
                                <td>
                                    <button wire:click="addProduct({{ $product->id }})" data-dismiss="modal"
                                        class="btn btn-primary btn-sm">Agregar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
