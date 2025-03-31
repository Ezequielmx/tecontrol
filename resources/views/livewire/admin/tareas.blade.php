<div>
    <button wire:click="newTask" class="btn btn-primary">
        Nueva Tarea
    </button>

    <div class="row mt-3">
        @foreach (['Personal', 'Empresa'] as $categoria)
        <div class="col-md-6">
            <h4>{{ $categoria }}</h4>
            @if (!empty($tasks[$categoria]))
            @foreach ($tasks[$categoria] as $tarea)
            <div class="card mb-2">
                <div class="card-body">
                    <h5>{{ $tarea['title'] }}</h5>
                    <p>{{ $tarea['description'] }}</p>
                    @if (!empty($tarea['value']))
                    <p><strong>Valor:</strong> ${{ number_format($tarea['value'], 2) }}</p>
                    @endif
                    <p><small>Última actualización: {{ \Carbon\Carbon::parse($tarea['updated_at'])->format('d M')
                            }}</small></p>
                    <p><small>Observaciones: {{ $tarea['updates_count'] ?? 0 }}</small></p>
                    <button wire:click="selectTask({{ $tarea['id'] }})" data-bs-toggle="modal"
                        data-bs-target="#tareaModal" class="btn btn-sm btn-outline-secondary">Editar</button>
                    <button wire:click="deleteTask({{ $tarea['id'] }})" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            @endforeach
            @else
            <p>No hay tareas en esta categoría.</p>
            @endif
        </div>
        @endforeach
    </div>

    <div class="modal fade" id="tareaModal" tabindex="-1" aria-labelledby="tareaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $selectedTask ? 'Editar Tarea' : 'Nueva Tarea' }}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"> X </button>
                </div>
                <div class="modal-body">
                    <input type="text" wire:model.defer="title" class="form-control mb-2" placeholder="Título">
                    <textarea wire:model.defer="description" class="form-control mb-2"
                        placeholder="Descripción"></textarea>
                    <input type="number" wire:model.defer="value" class="form-control mb-2" placeholder="Valor">
                    <select wire:model.defer="category" class="form-control mb-2">
                        <option value="Personal">Personal</option>
                        <option value="Empresa">Empresa</option>
                    </select>

                    @if ($selectedTask)
                    <h6>Observaciones</h6>
                    @foreach (collect($tasks[$category])->where('id', $selectedTask)->first()['updates'] as $update)
                        <p>{{ \Carbon\Carbon::parse($update['created_at'])->format('d-m-Y') }}: {{ $update['detail'] }}</p>
                    @endforeach
                    <input type="text" wire:model.defer="detail" class="form-control mb-2" placeholder="Nueva observación">
                    <button wire:click="addUpdate" class="btn btn-sm btn-outline-success" data-dismiss="modal">Agregar
                        Observación</button>
                    @endif
                </div>
                <div class="modal-footer">
                    <button wire:click="saveTask" class="btn btn-primary"  data-dismiss="modal">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('abrir-modal', () => {
            var modal = new bootstrap.Modal(document.getElementById('tareaModal'));
            modal.show();
        });
    </script>

</div>