<div>
    <div class="row" style="flex-wrap: nowrap;">
        @foreach($states as $state)
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ $state->state }}</div>
                    <div class="card-body">
                        <ul id="sortable-{{ $state->id }}" class="sortable-list">
                            @foreach($state->quotations as $quotation)
                                <li id="quotation-{{ $quotation->id }}" class="quotation-card">
                                    <div class="quotation-content">
                                        {{ $quotation->nro }}
                                        {{ $quotation->client? $quotation->client->razon_social : 'Sin cliente' }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

<script>
    // Inicializar Sortable.js para columnas y cotizaciones
    @foreach($states as $state)
        new Sortable(document.getElementById('sortable-{{ $state->id }}'), {
            group: 'state',
            animation: 150,
            onEnd: function (evt) {
                // Obtener el ID de la cotización y la nueva columna
                var quotationId = evt.item.id.replace('quotation-', '');
                var newStateId = evt.to.id.replace('sortable-', '');

                // Aquí debes enviar una solicitud Ajax a tu backend para actualizar el estado de la cotización
                // y luego volver a cargar los datos de cotización si es necesario.
            }
        });
    @endforeach

    // Función para cambiar el estado al hacer clic en los botones
    function changeState(direction, quotationId) {
        // Lógica para cambiar el estado
        // Actualiza la base de datos y, si es necesario, vuelve a cargar los datos.
    }
</script>
</div>