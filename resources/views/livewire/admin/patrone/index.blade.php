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
                        <label for="anio">Año</label>
                        <select wire:model="anio" class="form-control">
                            @for ($i = date('Y')-10; $i <= date('Y')+1; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                        </select>
                    </div>
                </div>
                @if($client_id)
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="pdf">Pdf </label>
                        <input type="file" wire:model="pdf" class="form-control-file">
                    </div>
                </div>
                @if($pdf)
                <div class="col-md-1">
                    <button wire:click="agregar" class="btn btn-success btn-sm">Agregar</button>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($patrones as $patron)
        <!--show pdf icon with pdfname and button for remove-->
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <a href="{{ asset('storage/'.$patron->pdf) }}" target="_blank">
                        <i class="fa-solid fa-file-pdf"></i> {{ basename($patron->pdf) }}
                    </a>
                </div>
                <div class="card-footer">
                    <button wire:click="eliminar({{ $patron->id }})" class="btn btn-danger btn-sm">Eliminar</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div wire:loading>
        <div class="modload">
            <div class="spinload">
                <i class="fa-solid fa-temperature-three-quarters fa-bounce2"></i>
            </div>
        </div>
    </div>
</div>