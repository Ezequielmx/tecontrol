<div>
    <div class="row">
        <div class="col col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-1">
                            <div class="form-group">
                                <label for="nro">Nro</label>
                                <input type="text" wire:model.defer="quotation.nro" class="form-control"
                                    placeholder="Nro. Cotización">
                            </div>
                        </div>
                        <div class="col col-md-2">
                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input type="date" wire:model.defer="quotation.fecha" class="form-control"
                                    placeholder="Fecha">
                            </div>
                        </div>
                        <div class="col col-md-5">
                            <div class="form-group">
                                <!--select for clientes-->
                                <label for="client_id">Cliente</label>
                                <select wire:model="quotation.client_id" class="form-control">
                                    <option value="">Seleccione un cliente</option>
                                    @foreach ($clients as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->razon_social }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col col-md-2">
                            <div class="form-group">
                                <!--select for quotationTypes-->
                                <label for="quotation_type_id">Tipo</label>
                                <select wire:model.defer="quotation.quotation_type_id" class="form-control">
                                    @foreach ($quotationTypes as $quotationType)
                                    <option value="{{ $quotationType->id }}">{{ $quotationType->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col col-md-2">
                            <div class="form-group">
                                <!--select for quotationStates-->
                                <label for="quotation_state_id">Estado</label>
                                <select wire:model.defer="quotation.quotation_state_id" class="form-control">
                                    @foreach ($quotationStates as $quotationState)
                                    <option value="{{ $quotationState->id }}">{{ $quotationState->state }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!--select for contacto-->
                        <div class="col col-md-3">
                            <div class="form-group">
                                <label for="contacto_id">Contacto</label>
                                <select wire:model.defer="quotation.contacto" class="form-control">
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
                        <!--input trex for ref   -->
                        <div class="col col-md-7">
                            <div class="form-group">
                                <label for="ref">Ref.</label>
                                <input type="text" wire:model="quotation.ref" class="form-control" placeholder="Ref.">
                            </div>
                        </div>
                        <div class="col col-md-2">
                            <div class="form-group">
                                <!--select for quotationPriorities-->
                                <label for="quotation_priority_id">Prioridad</label>
                                <select wire:model.defer="quotation.quotation_priority_id" class="form-control">
                                    @foreach ($quotationPriorities as $quotationPriority)
                                    <option value="{{ $quotationPriority->id }}">{{ $quotationPriority->priority }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <!-- input date for fechaCOntacto -->
                        <div class="col col-md-2">
                            <div class="form-group">
                                <label for="fecha_contacto">Fecha Contacto</label>
                                <input type="date" wire:model.defer="quotation.fechaContacto" class="form-control"
                                    placeholder="Fecha Contacto">
                            </div>
                        </div>
                        <!-- input date for detalleContacto -->
                        <div class="col col-md-10">
                            <div class="form-group">
                                <label for="detalle_contacto">Detalle Contacto</label>
                                <input type="text" wire:model.defer="quotation.detalleContacto" class="form-control"
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
                                <label>Facturado</label>
                                <span class="badge badge-primary" style="font-size: 1.2em; 
                                    width:100%; 
                                    height:38px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: flex-end;">
                                    $ {{ number_format($facturado,2,",",".") }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Diferencia Facturas</label>
                                <span class="badge {{ $difFact!=0? 'badge-danger' : 'badge-success' }}" style="font-size: 1.2em; 
                                width:100%; 
                                height:38px;
                                display: flex;
                                align-items: center;
                                justify-content: flex-end;">
                                    $ {{ number_format($difFact,2,",",".") }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @livewire('admin.quotation.quotationdetails', ['quotation' => $quotation])

    <div class="row">
        <div class="col col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <!--input for validezOferta-->
                                <label for="validezOferta">Validez Oferta</label>
                                <input type="text" wire:model.defer="quotation.validezOferta" class="form-control"
                                    placeholder="Validez Oferta">
                            </div>
                            <div class="form-group">
                                <!--input for plazoEntrega-->
                                <label for="plazoEntrega">Plazo Entrega</label>
                                <input type="text" wire:model.defer="quotation.plazoEntrega" class="form-control"
                                    placeholder="Plazo Entrega">
                            </div>
                            <div class="form-group">
                                <!--input for lugarEntrega-->
                                <label for="lugarEntrega">Lugar Entrega</label>
                                <input type="text" wire:model.defer="quotation.lugarEntrega" class="form-control"
                                    placeholder="Lugar Entrega">
                            </div>
                            <div class="form-group">
                                <!--input for condicion-->
                                <label for="condicion">Condicion</label>
                                <input type="text" wire:model.defer="quotation.condicion" class="form-control"
                                    placeholder="Condicion">
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <!--input for nota-->
                                <label for="nota">Nota</label>
                                <textarea style="/*max-height: 125px;*/" wire:model.defer="quotation.nota"
                                    class="form-control" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <!--input for observaciones-->
                                <label for="observaciones">Observaciones</label>
                                <textarea style="/*max-height: 211px;*/" wire:model.defer="quotation.observaciones"
                                    class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="form-group">
                                <!--select file solicitudCotizacion-->
                                <label for="solicitudCotizacion">Solicitud Cot.
                                    @if ($quotation->solicitudCotizacion)
                                    <a href="{{ asset('storage/'.$quotation->solicitudCotizacion) }}"
                                        target="_blank">Abrir</a>
                                    @endif
                                </label>
                                <input type="file" wire:model.defer="solicitudCotizacion" class="form-control-file"
                                    style="font-size: 12px;">
                                <!-- if isset solicitudCotizacion show link for download-->
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <!--select file cotizacion-->
                                <label for="cotizacion">Cotizacion
                                    @if ($quotation->cotizacion)
                                    <a href="{{ asset('storage/'.$quotation->cotizacion) }}" target="_blank">Abrir</a>
                                    @endif
                                </label>
                                <input type="file" wire:model="cotizacion" class="form-control-file"
                                    style="font-size: 12px;">
                                <!-- if isset cotizacion show link for download-->
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <!--select file ordenCompra-->
                            <div class="form-group">
                                <label for="ordenCompra">Orden Compra
                                    @if ($quotation->ordenCompra)
                                    <a href="{{ asset('storage/'.$quotation->ordenCompra) }}" target="_blank">Abrir</a>
                                    @endif
                                </label>
                                <input type="file" wire:model="ordenCompra" class="form-control-file"
                                    style="font-size: 12px;">
                                <!-- if isset ordenCompra show link for download-->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!--input for nroPedido-->
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="nroPedido">Nro Pedido</label>
                                <input type="text" wire:model.defer="quotation.nroPedido" class="form-control"
                                    placeholder="Nro Pedido">
                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </div>

        <div class="col col-md-6">
            @livewire('admin.quotation.quotationdocs', ['quotation' => $quotation])
        </div>
    </div>

    <div class="text-right pt-2 pb-2">
        <button class="btn btn-primary" wire:click="guardar">Guardar</button>
        <a href="{{ route('admin.cotizaciones.index') }}" class="btn btn-secondary">Cancelar</a>
        <a href="{{ route('admin.cotizaciones.print', $quotation) }}" target="_blank" class="btn btn-danger"><i
                class="fa fa-file-pdf">
            </i></a>
    </div>




    <div wire:loading>
        <div class="modload">
            <div class="spinload">
                <i class="fa-solid fa-temperature-three-quarters fa-bounce2"></i>
            </div>
        </div>
    </div>
</div>