<div>
    <div class="card">
        <div class="card-body">
            <div class="row" style="align-items: center;">
                <div class="col col-md-2">
                    <div class="form-group">
                        <label for="desde">Desde</label>
                        <input wire:model="desde" type="date" class="form-control">
                    </div>
                </div>
                <div class="col col-md-2">
                    <div class="form-group">
                        <label for="hasta">Hasta</label>
                        <input wire:model="hasta" type="date" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div id="container-graph"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div id="container-graph2"></div>
                </div>
            </div>
        </div>
    </div>


</div>