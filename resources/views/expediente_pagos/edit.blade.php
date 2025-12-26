<!-- Modal Editar Expediente Pago -->
<div class="modal fade" id="editExpedientePagoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <form id="editExpedientePagoForm" class="modal-content" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" id="expediente_pago_id">

            <div class="modal-header">
                <h5 class="modal-title">
                    Editar Pago de Expediente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- Fecha de pago --}}
                <div class="mb-3">
                    <label class="form-label">Fecha de Pago</label>
                    <input type="date" class="form-control" id="fecha_pago" name="fecha_pago">
                </div>

                {{-- Comentarios --}}
                <div class="mb-3">
                    <label class="form-label">Comentarios</label>
                    <textarea class="form-control" id="comentarios" name="comentarios" rows="3"></textarea>
                </div>

                {{-- Archivo comprobante --}}
                <div class="mb-3">
                    <label class="form-label">Comprobante de Pago</label>
                    <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">
                        PDF o imagen (máx. 5MB)
                    </small>
                </div>

                {{-- Archivo actual --}}
                <div id="archivoActual" class="mt-2"></div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-primary">
                    Guardar Cambios
                </button>
            </div>

        </form>
    </div>
</div>
