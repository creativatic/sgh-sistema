<div class="modal fade" id="editExpedientePagoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <form id="editExpedientePagoForm" class="modal-content" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <input type="hidden" id="expediente_pago_id" name="expediente_pago_id">
            
            {{-- HEADER --}}
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="ri-edit-line"></i> Editar Pago de Expediente
                </h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                {{-- SECCIÓN: DATOS GENERALES DEL PROVEEDOR --}}
                <h5 class="fw-bold text-warning">Información del Proveedor y Expediente</h5>
                <hr>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">Guía Remisión</label>
                        <input type="text" id="view_guia_remision" class="form-control bg-light" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">N° Ticket (Tisur)</label>
                        <input type="text" id="view_ticket" class="form-control bg-light" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">Placa Tracto</label>
                        <input type="text" id="view_placa" class="form-control bg-light" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">RUC</label>
                        <input type="text" id="view_ruc" class="form-control bg-light" readonly>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold small text-muted">Razón Social</label>
                        <input type="text" id="view_razon_social" class="form-control bg-light" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">Banco</label>
                        <input type="text" id="view_banco" class="form-control bg-light" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">Cuenta Bancaria</label>
                        <input type="text" id="view_cuenta" class="form-control bg-light" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">CCI</label>
                        <input type="text" id="view_cci" class="form-control bg-light" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-danger small">Depósito a Proveer S/.</label>
                        <input type="text" id="view_deposito" class="form-control fw-bold border-danger bg-light text-danger" readonly>
                    </div>
                </div>

                {{-- SECCIÓN: FORMULARIO DE PAGO (EDITABLE) --}}
                <h5 class="fw-bold text-warning">Datos del Pago</h5>
                <hr>

                <div class="row g-3">
                    {{-- Fecha de pago --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha de Pago</label>
                        <input type="date"
                               class="form-control"
                               id="fecha_pago"
                               name="fecha_pago">
                    </div>

                    {{-- Archivo comprobante --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Comprobante de Pago (PDF/Imagen)</label>
                        <input type="file"
                               class="form-control"
                               id="archivo"
                               name="archivo"
                               accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Máx. 5MB</small>
                        
                        {{-- Contenedor para el botón de ver archivo actual --}}
                        <div id="archivoActual" class="mt-2"></div>
                    </div>

                    {{-- Comentarios --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Comentarios / Notas</label>
                        <textarea class="form-control"
                                  id="comentarios"
                                  name="comentarios"
                                  rows="2"
                                  placeholder="Opcional..."></textarea>
                    </div>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer bg-light">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    <i class="ri-close-line"></i> Cancelar
                </button>

                <button type="submit"
                        class="btn btn-warning">
                    <i class="ri-save-line"></i> Guardar Cambios
                </button>
            </div>

        </form>
    </div>
</div>