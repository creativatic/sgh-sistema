<!-- Modal Editar Programación -->
<div class="modal fade" id="editProgramacionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <form method="POST" id="editProgramacionForm" class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Editar Programación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    <!-- FECHA -->
                    <div class="col-md-4">
                        <label class="form-label">Fecha Programación</label>
                        <input type="datetime-local"
                               id="edit-fecha_programacion"
                               name="fecha_programacion"
                               class="form-control"
                               required>
                    </div>

                    <!-- FRENTE -->
                    <!-- FRENTE (SOLO VISUAL) -->
                    <div class="col-md-4">
                        <label class="form-label">Frente</label>
                        <input type="text"
                            id="edit-frente_text"
                            class="form-control"
                            readonly>

                        <input type="hidden"
                            name="detalle_programacion_id"
                            id="edit-detalle_programacion_id">
                    </div>


                    <!-- GUIA REMISION -->
                    <div class="col-md-4">
                        <label class="form-label">Guía Remisión</label>
                        <input type="text"
                               id="edit-guia_remision"
                               name="guia_remision"
                               class="form-control">
                    </div>

                    <!-- PROVEEDOR (SOLO VISUAL) -->
                    <div class="col-md-4">
                        <label class="form-label">Proveedor</label>
                        <input type="text"
                               id="edit-proveedor_text"
                               class="form-control"
                               readonly>
                        <input type="hidden" name="proveedor_id" id="edit-proveedor_id">
                    </div>

                    <!-- UNIDAD (SOLO VISUAL) -->
                    <div class="col-md-4">
                        <label class="form-label">Unidad</label>
                        <input type="text"
                               id="edit-unidad_text"
                               class="form-control"
                               readonly>
                        <input type="hidden" name="unidad_id" id="edit-unidad_id">
                    </div>

                    <!-- CONDUCTOR (SOLO VISUAL) -->
                    <div class="col-md-4">
                        <label class="form-label">Conductor</label>
                        <input type="text"
                               id="edit-conductor_text"
                               class="form-control"
                               readonly>
                        <input type="hidden" name="conductor_id" id="edit-conductor_id">
                    </div>

                    <!-- TIPO MINERAL -->
                    <div class="col-md-4">
                        <label class="form-label">Tipo Mineral</label>
                        <input type="text"
                               id="edit-tipo_mineral"
                               name="tipo_mineral"
                               class="form-control">
                    </div>

                    <!-- TIPO OPERACIÓN -->
                    <div class="col-md-4">
                        <label class="form-label">Tipo Operación</label>
                        <select name="tipo_operacion"
                                id="edit-tipo_operacion"
                                class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="nacional">Nacional</option>
                            <option value="internacional">Internacional</option>
                        </select>
                    </div>

                    <!-- MONTO -->
                    <div class="col-md-4">
                        <label class="form-label">Monto Adelanto</label>
                        <input id="edit-monto_view"
                               class="form-control"
                               readonly>
                        <input type="hidden"
                               name="monto_adelanto"
                               id="edit-monto">
                    </div>

                    <!-- GUIA TRANSPORTISTA -->
                    <div class="col-md-4">
                        <label class="form-label">Guía Transportista</label>
                        <input type="text"
                               id="edit-guia_transportista"
                               name="guia_transportista"
                               class="form-control">
                    </div>

                    <!-- GRUPO CARGUIO -->
                    <div class="col-md-4">
                        <label class="form-label">Grupo Carguío</label>
                        <input type="text"
                               id="edit-grupo_cargio"
                               name="grupo_cargio"
                               class="form-control">
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary">Actualizar</button>
            </div>

        </form>
    </div>
</div>


<script>
function editarProgramacion(id) {

    fetch(`/programacions/${id}/json`)
        .then(r => r.json())
        .then(({ programacion, proveedor, unidad, conductor }) => {

            if (!programacion) return;

            // FORM ACTION
            const form = document.getElementById('editProgramacionForm');
            form.action = `/programacions/${programacion.id}`;

            // FECHA
            document.getElementById('edit-fecha_programacion').value =
                programacion.fecha_programacion.replace(' ', 'T').substring(0, 16);

            // SIMPLES
            document.getElementById('edit-guia_remision').value = programacion.guia_remision ?? '';
            document.getElementById('edit-tipo_mineral').value = programacion.tipo_mineral ?? '';
            document.getElementById('edit-tipo_operacion').value = programacion.tipo_operacion ?? '';
            document.getElementById('edit-guia_transportista').value = programacion.guia_transportista ?? '';
            document.getElementById('edit-grupo_cargio').value = programacion.grupo_cargio ?? '';

            // FRENTE
            // FRENTE (VISUAL + ID)
            document.getElementById('edit-frente_text').value =
                programacion.detalle_programacion
                    ? programacion.detalle_programacion.frente
                    : '';

            document.getElementById('edit-detalle_programacion_id').value =
                programacion.detalle_programacion_id ?? '';

            // PROVEEDOR (VISUAL + ID)
            document.getElementById('edit-proveedor_text').value =
                proveedor ? proveedor.razon_social : '';
            document.getElementById('edit-proveedor_id').value =
                proveedor?.id ?? '';

            // UNIDAD (VISUAL + ID)
            document.getElementById('edit-unidad_text').value =
                unidad ? `${unidad.placa_tracto} / ${unidad.placa_carreta}` : '';
            document.getElementById('edit-unidad_id').value =
                unidad?.id ?? '';

            // CONDUCTOR (VISUAL + ID)
            document.getElementById('edit-conductor_text').value =
                conductor ? `${conductor.nombres} ${conductor.apellidos}` : '';
            document.getElementById('edit-conductor_id').value =
                conductor?.id ?? '';

            // MONTO
            document.getElementById('edit-monto').value = programacion.monto_adelanto ?? 0;
            document.getElementById('edit-monto_view').value =
                `S/. ${parseFloat(programacion.monto_adelanto ?? 0).toFixed(2)}`;

            // SHOW MODAL
            new bootstrap.Modal(
                document.getElementById('editProgramacionModal')
            ).show();
        })
        .catch(console.error);
}
</script>
