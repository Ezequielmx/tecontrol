<div>
    <div class="card">
        <div class="card-body">
            <div class="row" style="align-items: center;">
                <div class="col col-md-2">
                    <!--client select-->
                    <div class="form-group">
                        <label for="cliente_id">Cliente</label>
                        <select wire:model="cliente_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->razon_social }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col col-md-2">
                    <!--state select-->
                    <div class="form-group">
                        <label for="estado_id">Estado</label>
                        <select wire:model="estado_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach ($quotationStates as $quotationState)
                            <option value="{{ $quotationState->id }}">{{ $quotationState->state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col col-md-2">
                    <!--priority select-->
                    <div class="form-group">
                        <label for="prioridad_id">Prioridad</label>
                        <select wire:model="prioridad_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach ($quotationPriorities as $quotationPriority)
                            <option value="{{ $quotationPriority->id }}">{{ $quotationPriority->priority }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col col-md-1 text-center">
                    <!--checkbox finalizadas-->
                    <div class="form-group">
                        <label for="finalizadas">Finalizadas</label>
                        <input wire:model="finalizadas" type="checkbox" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <!--buton clean filters with eraser icon-->
                        <button wire:click="borrarFiltros" class="btn btn-outline-secondary mt-4"><i
                                class="fas fa-eraser"></i>Borrar Filtros</button>
                    </div>
                </div>
                <div class="col text-right">
                    <!--button create route creat-->
                    <a href="{{ route('admin.cotizaciones.create') }}" class="btn btn-success btn-sm">Nueva
                        Cotización</a>
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
                        <th>Fecha</th>
                        <th>Tiempo</th>
                        <th>Nro</th>
                        <th>Cliente</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th style="width: 10px;">Acciones</th>
                    </tr>
                </thead>
                @foreach ($cotizaciones as $cotizacion)
                <tr wire:click='selCot({{ $cotizacion->id }})'>
                    <td>
                        <button class="btn btn-default btn-xs"><i class="fa-regular fa-eye"></i></button>
                    </td>
                    <td>{{ $cotizacion->id }}</td>
                    <td>{{ date('d/m/Y', strtotime($cotizacion->fecha)) }}</td>
                    <td>{{ intval((time() - strtotime($cotizacion->fecha)) / 86400) }} días</td>
                    <td>{{ $cotizacion->nro }}</td>
                    <td style="width:30%">{{ isset($cotizacion->client)? $cotizacion->client->razon_social : '' }}</td>
                    <td class="text-right">$ {{ number_format($cotizacion->total(), 2, ",", ".") }}</td>
                    <td>{{ $cotizacion->quotationState->state }}</td>
                    <td>{{ $cotizacion->quotationPriority->priority }}</td>
                    <td style="white-space:nowrap">
                        <a href="{{ route('admin.cotizaciones.edit', $cotizacion) }}"
                            class="btn btn-sm btn-primary">Editar</a>
                        <button wire:click="$emit('deleteCot',{{ $cotizacion->id }})"
                            class="btn btn-sm btn-danger">Eliminar</button>
                        <!-- a href print button with pdf icon-->
                        <a href="{{ route('admin.cotizaciones.print', $cotizacion) }}" target="_blank"
                            class="btn btn-secondary"><i class="fa fa-file-pdf"></i></a>
                    </td>
                </tr>
                <tr></tr>
                <tr class={{ ($selected_id==$cotizacion->id)? '' : 'hiddenRow' }}>
                    <td></td>
                    <td colspan="9" >
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th style="width: 10%">Precio Unit</th>
                                    <th>Moneda</th>
                                    <th>Cotizacion</th>
                                    <th>Precio Ars</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Facturado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quotationDetails as $detalle)
                                <tr>
                                    <td>
                                        {{ $detalle->product->descripcion_cotizacion }}
                                    </td>
                                    <td style="min-width: 180px;">
                                        $ {{ number_format($detalle->precio,2,",",".") }}
                                    </td>
                                    <td style="white-space: nowrap; text-align:center">
                                        {{ $detalle->currency->moneda}}
                                    </td>
                                    <td style="white-space: nowrap; text-align:end">
                                        {{ $detalle->cotizacion }}
                                    </td>
                                    <td style="white-space: nowrap; text-align:end">
                                        $ {{ number_format($detalle->precio * $detalle->cotizacion,2,",",".") }}
                                    </td>
                                    <td style="width: 1%">
                                        {{ $detalle->cantidad }}
                                    </td>
                                    <td style="white-space: nowrap; text-align:end">
                                        $ {{ number_format($detalle->precio * $detalle->cotizacion *
                                        $detalle->cantidad,2,",",".")}}
                                    </td>

                                    <td style="width: 1%">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-control" {{ $detalle->facturado?
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
        <!--pagination-->
        <div class="card-footer">
            {{ $cotizaciones->links() }}
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