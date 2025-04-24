<div>
    <h4>Personal</h4>
    <div class="text-right">
        <button wire:click="newTask" class="btn btn-primary btn-sm">
            Nueva
        </button>
    </div>


    <div class="row mt-3">
        <div class="col">
            @foreach ($tasks as $tarea)
            <div class="card mb-2">
                <div class="card-body py-3">
                    <div class="row">
                        <!-- Columna izquierda -->
                        <div class="col-md-6 pe-4">

                            <div class="mb-2">
                                <span class="text-muted small">Título:</span>
                                <span style="font-weight: bold;">{{ $tarea['title'] }}</span>
                            </div>

                            <div class="mb-2">
                                <span class="text-muted small">Descripción:</span>
                                <span class="fw-semibold">{{ $tarea['description'] }}</span>
                            </div>

                            <div class="text-muted small mt-3">
                                <span class="text-muted small">Última actualización:</span>
                                <span class="fw-semibold">{{ \Carbon\Carbon::parse($tarea['updated_at'])->format('d M
                                    Y') }}</span>
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
                                <span class="text-muted small">Observaciones:</span>

                                @php
                                $updates = collect($tarea['updates'] ?? [])->sortByDesc('created_at');
                                @endphp

                                @if ($updates->count())
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
                                @else
                                <p class="text-muted"><em>Sin observaciones aún.</em></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tareaPersModal" tabindex="-1" aria-labelledby="tareaModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg"> <!-- Ancho amplio para comodidad -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $selectedTask ? 'Editar Tarea' : 'Nueva Tarea' }}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Cerrar">X</button>
                </div>
                <div class="modal-body">
    
                    <div class="form-group row mb-3">
                        <label for="title" class="col-sm-4 col-form-label">Título</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model.defer="title" id="title" class="form-control" placeholder="Título de la tarea">
                        </div>
                    </div>
    
                    <div class="form-group row mb-3">
                        <label for="description" class="col-sm-4 col-form-label">Descripción</label>
                        <div class="col-sm-8">
                            <textarea wire:model.defer="description" id="description" class="form-control" rows="3" placeholder="Descripción detallada"></textarea>
                        </div>
                    </div>
    
                    @if ($selectedTask)
                    <div class="form-group row mb-2">
                        <label class="col-sm-4 col-form-label">Observaciones</label>
                        <div class="col-sm-8">
                            @foreach (collect($tasks)->where('id', $selectedTask)->first()['updates'] as $update)
                            <div class="d-flex justify-content-between align-items-start mb-2 border rounded px-3 py-2 bg-light">
                                <div>
                                    <div class="text-muted small">{{ \Carbon\Carbon::parse($update['created_at'])->format('d-m-Y H:i') }}</div>
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
                            <input type="text" wire:model.defer="detail" id="detail" class="form-control" placeholder="Agregar observación">
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
        window.addEventListener('abrir-modalp', () => {
            var modal = new bootstrap.Modal(document.getElementById('tareaPersModal'));
            modal.show();
        });
    </script>

</div>