<div>
    <h4>Empresa</h4>
    <div>
        <div class="row">
            <div class="col">
                <div class="mb-2">
                    <span class="text-muted text-lg">Total:</span>
                    <span class="badge bg-primary text-white text-lg">${{ number_format($taskTotal, 0,
                        ",", ".") }}</span>
                </div>
            </div>
            <div class="col text-right">
                <button wire:click="newTask" class="btn btn-primary btn-sm">
                    Nueva
                </button>
            </div>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col">
            @foreach ($tasks as $tarea)
            <div class="card mb-2">
                <div class="card-body py-3">
                    <div class="row">
                        <!-- Columna izquierda -->
                        <div class="col-md-6 pe-4">

                            @if ($tarea['quotation_id'])
                            @php
                            $cotizacion = $quotations->firstWhere('id', $tarea['quotation_id']);
                            $estado = $cotizacion->quotationState->state;
                            @endphp

                            <div class="mb-2">
                                <span class="text-muted small">Cliente:</span>
                                <span style="font-weight: bold;">{{ $cotizacion->client->razon_social ?? '' }}</span>
                            </div>

                            <div class="mb-2">
                                <span class="text-muted small">Cotización:</span>
                                <span class="fw-semibold">{{ $cotizacion->nro }}</span><br>
                                <span class="text-muted small">ref:</span>
                                <span class="fw-semibold">{{ $cotizacion->ref }}</span>
                            </div>

                            <div class="mb-2">
                                <span class="text-muted small">Monto:</span>
                                <span class="fw-semibold text-success">${{ number_format($cotizacion->total(), 0,
                                    ",", ".") }}</span>
                            </div>

                            <div class="mb-2">
                                <span class="text-muted small">Estado:</span>
                                <span class="badge bg-secondary text-white text-uppercase">{{ $estado }}</span>
                            </div>
                            @endif

                            @if($tarea['title'])
                                <div class="mb-2">
                                    <span class="text-muted small">Titulo:</span>
                                    <span style="font-weight: bold;">{{ $tarea['title'] }}</span>
                                </div>
                            @endif

                            <div class="text-muted small mt-3">
                                <div>Última actualización: {{ \Carbon\Carbon::parse($tarea['updated_at'])->format('d
                                    M Y') }}</div>
                            </div>

                            <div class="mt-3 d-flex gap-2">
                                <button wire:click="selectTask({{ $tarea['id'] }})" data-bs-toggle="modal"
                                    data-bs-target="#tareaModal"
                                    class="btn btn-sm btn-outline-secondary">Editar</button>
                                <button wire:click="deleteTask({{ $tarea['id'] }})"
                                    class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>

                        </div>

                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <div class="mb-2">
                                <span class="text-muted small">Descripción:</span>
                                <span class="fw-semibold">{{ $tarea['description'] }}</span>
                            </div>


                            @php
                            $updates = collect($tarea['updates'] ?? [])->sortByDesc('created_at');
                            @endphp

                            @if ($updates->count())
                            <div class="mt-2">
                                <span class="fw-bold">Observaciones:</span>

                                <ul class="list-unstyled ps-3 border-start border-2 border-secondary-subtle mt-1">
                                    @foreach ($updates as $update)
                                    <li class="mb-2 position-relative">
                                        <div class="position-absolute top-0 start-0 translate-middle-y bg-secondary rounded-circle"
                                            style="width: 8px; height: 8px; left: -14px; top: 6px;"></div>
                                        <small class="text-muted d-block">{{
                                            \Carbon\Carbon::parse($update['created_at'])->format('d-m-Y H:i') }}</small>
                                        <div class="border rounded px-2 py-1 bg-light small">
                                            {{ $update['detail'] }}
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @else
                            <p class="text-muted"><em>Sin observaciones aún.</em></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="Modal2" tabindex="-1" aria-labelledby="tareaModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $selectedTask ? 'Editar Tarea' : 'Nueva Tarea' }}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"> X </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="client" class="col-sm-4 col-form-label">Cliente</label>
                        <div class="col-sm-8">
                            <select wire:model="selectedClient" id="client" class="form-control mb-2">
                                <option value=''>Seleccionar Cliente</option>
                                @foreach ($clients as $client )
                                <option value="{{ $client['id'] }}">{{ $client['razon_social'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="quotation" class="col-sm-4 col-form-label">Cotización</label>
                        <div class="col-sm-8">
                            <select wire:model="quotation_id" id="quotation" class="form-control mb-2">
                                <option value=''>Seleccionar Cotización</option>
                                @foreach ($quotationsClient as $quotation)
                                <option value="{{ $quotation->id }}">{{ $quotation->nro }}{{ $quotation->ref ? ' - ' .
                                    $quotation->ref : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if ($quotation_id)
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Valor</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext mb-1">
                                <strong>${{ number_format($quotations->firstWhere('id', $quotation_id)->total(), 0, ',',
                                    '.') }}</strong>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Estado</label>
                        <div class="col-sm-8">
                            @php
                            $estado = $quotations->firstWhere('id', $quotation_id)->quotationState->state;
                            $badgeClass = match($estado) {
                            'Aprobado' => 'badge-success',
                            'Pendiente' => 'badge-warning',
                            'Rechazado' => 'badge-danger',
                            default => 'badge-secondary'
                            };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $estado }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row mb-3">
                        <label for="title" class="col-sm-4 col-form-label">Título</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model.defer="title" id="title" class="form-control" placeholder="Título de la tarea">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-sm-4 col-form-label">Descripción</label>
                        <div class="col-sm-8">
                            <textarea wire:model.defer="description" id="description" class="form-control mb-2"
                                placeholder="Descripción"></textarea>
                        </div>
                    </div>

                    @if ($selectedTask)
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Observaciones</label>
                        <div class="col-sm-8">
                            @php
                            $updates = collect($tasks)->where('id', $selectedTask)->first()['updates'] ?? [];
                            $updates = collect($updates)->sortByDesc('created_at');
                            @endphp

                            @foreach ($updates as $update)
                            <div
                                class="d-flex justify-content-between align-items-start mb-2 border rounded px-3 py-2 bg-light">
                                <div>
                                    <div class="text-muted small">{{
                                        \Carbon\Carbon::parse($update['created_at'])->format('d-m-Y H:i') }}</div>
                                    <div>{{ $update['detail'] }}</div>
                                </div>
                                <button wire:click="deleteUpdateFromTask({{ $update['id'] }})"
                                    class="btn btn-sm btn-outline-danger ms-2">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="detail" class="col-sm-4 col-form-label">Nueva observación</label>
                        <div class="col-sm-8 d-flex gap-2">
                            <input type="text" wire:model.defer="detail" id="detail" class="form-control"
                                placeholder="Agregar observación">
                            <button wire:click="addUpdate" class="btn btn-outline-success" data-dismiss>+</button>
                        </div>
                    </div>

                    @endif
                </div>
                <div class="modal-footer">
                    <button wire:click="saveTask" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('abrir-modal', () => {
            var modal = new bootstrap.Modal(document.getElementById('Modal2'));
            modal.show();
        });
    </script>

</div>