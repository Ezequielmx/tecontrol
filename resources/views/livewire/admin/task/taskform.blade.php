<div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Tarea">Nueva Tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for new task o edit task -->
                <form>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <!-- textarea for tarea -->
                                <label for="tarea">Tarea</label>
                                <textarea class="form-control" id="tarea" wire:model.defer="task.tarea"
                                    rows="4"></textarea>
                                @error('task.tarea') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <!--input for fecha_ini-->
                                <label for="fecha_ini">Fecha Inicio</label>
                                <input type="date" class="form-control" id="fecha_ini"
                                    wire:model.defer="task.fecha_ini">
                                @error('task.fecha_ini') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col">

                            <div class="form-group">
                                <!--input for fecha_fin-->
                                <label for="fecha_fin">Fecha Fin</label>
                                <input type="date" class="form-control" id="fecha_fin"
                                    wire:model.defer="task.fecha_fin">
                                @error('task.fecha_fin') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <div class="form-check">
                                    <!-- checkbox for check -->
                                    <input class="form-check-input" type="checkbox" id="check"
                                        wire:model.defer="task.check">
                                    <label class="form-check-label" for="check">
                                        Realizada
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" wire:click='guardar'>Guardar</button>
            </div>
        </div>
    </div>
</div>