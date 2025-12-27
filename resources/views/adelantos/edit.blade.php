<!-- Modal Editar Adelanto -->
<div class="modal fade" id="editAdelantoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">

        <form id="editAdelantoForm"
              method="POST"
              class="modal-content">
            @csrf
            @method('PUT')

            {{-- HEADER --}}
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    Editar Adelanto
                </h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                <h5 class="fw-bold">Datos del Adelanto</h5>
                <hr>

                {{-- ID oculto --}}
                <input type="hidden"
                       id="edit_programacion_id"
                       name="id">

                {{-- Número de factura --}}
                <div class="mb-3">
                    <label class="form-label">
                        N° Factura / Expediente
                    </label>
                    <input type="text"
                           id="edit_numero_factura"
                           class="form-control"
                           readonly>
                </div>

                {{-- Monto de adelanto --}}
                <div class="mb-3">
                    <label class="form-label">
                        Monto de Adelanto (S/)
                    </label>
                    <input type="number"
                           id="edit_monto_adelanto"
                           class="form-control"
                           readonly>
                </div>

                {{-- Fecha de pago --}}
                <div class="mb-3">
                    <label class="form-label">
                        Fecha de Pago Adelanto
                    </label>
                    <input type="date"
                           name="fecha_pago_adelantos"
                           id="edit_fecha_pago_adelantos"
                           class="form-control">
                </div>

                {{-- Notas --}}
                <div class="mb-3">
                    <label class="form-label">
                        Notas / Observaciones
                    </label>
                    <textarea name="notas"
                              id="edit_notas"
                              class="form-control"
                              rows="3"></textarea>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button type="submit"
                        class="btn btn-warning">
                    Actualizar
                </button>
            </div>

        </form>
    </div>
</div>
