<!-- Modal Mostrar Expediente -->
<div class="modal fade" id="showExpedienteModal" tabindex="-1" aria-labelledby="showExpedienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="showExpedienteModalLabel">
                    <i class="ri-eye-line"></i> Detalle del Expediente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <h6 class="text-primary mb-3">馃搵 Datos de la Programaci贸n</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">N掳 Gu铆a Remisi贸n:</label>
                        <p id="show_guia_remision" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Placa Tracto:</label>
                        <p id="show_placa_tracto" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tipo Mineral:</label>
                        <p id="show_tipo_mineral" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Frente:</label>
                        <p id="show_frente" class="form-control-plaintext"></p>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Raz贸n Social:</label>
                        <p id="show_razon_social" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">RUC:</label>
                        <p id="show_ruc" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Conductor:</label>
                        <p id="show_conductor" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tel茅fono:</label>
                        <p id="show_telefono" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Cuenta Banco:</label>
                        <p id="show_cuenta_banco" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Banco:</label>
                        <p id="show_banco" class="form-control-plaintext"></p>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="text-primary mb-3">馃搼 Datos del Expediente</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">N掳 Ticket (Tisur):</label>
                        <p id="show_tisur" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha Carga:</label>
                        <p id="show_fecha_carga" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha Pago:</label>
                        <p id="show_fecha_pago" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Total:</label>
                        <p id="show_total" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Detracci贸n:</label>
                        <p id="show_detraccion" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Dep贸sito a Proveer:</label>
                        <p id="show_deposito" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">N掳 Factura:</label>
                        <p id="show_factura" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Comentarios:</label>
                        <p id="show_comentarios" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Estado Impresion Factura:</label>
                        <p id="show_estado_impresion" class="form-control-plaintext"></p>
                    </div>

                    {{-- Aqu铆 se insertar谩n los PDF --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Archivos adjuntos PDF:</label>
                        <div id="show_archivos"></div>
                    </div>
                    
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

