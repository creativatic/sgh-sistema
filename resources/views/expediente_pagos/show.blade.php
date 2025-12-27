<!-- Modal Show Expediente Pago -->
<div class="modal fade"
     id="showExpedientePagoModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="ri-eye-line"></i> Detalle de Pago de Expediente
                </h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                <h6 class="text-warning">📄 Programación</h6>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Guía Remisión</th>
                        <td id="show_guia_remision"></td>
                    </tr>
                    <tr>
                        <th>Placa Tracto</th>
                        <td id="show_placa"></td>
                    </tr>
                    <tr>
                        <th>Frente</th>
                        <td id="show_frente"></td>
                    </tr>
                    <tr>
                        <th>Tipo Mineral</th>
                        <td id="show_tipo_mineral"></td>
                    </tr>
                </table>

                <h6 class="text-warning mt-3">🏢 Proveedor</h6>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Razón Social</th>
                        <td id="show_razon_social"></td>
                    </tr>
                    <tr>
                        <th>RUC</th>
                        <td id="show_ruc"></td>
                    </tr>
                    <tr>
                        <th>Banco</th>
                        <td id="show_banco"></td>
                    </tr>
                    <tr>
                        <th>Cuenta</th>
                        <td id="show_cuenta"></td>
                    </tr>
                    <tr>
                        <th>CCI</th>
                        <td id="show_cci"></td>
                    </tr>
                </table>

                <h6 class="text-warning mt-3">💰 Pago</h6>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>N° Ticket (Tisur)</th>
                        <td id="show_ticket"></td>
                    </tr>
                    <tr>
                        <th>Fecha de Carga</th>
                        <td id="show_fecha_carga"></td>
                    </tr>
                    <tr>
                        <th>Depósito a Proveer</th>
                        <td id="show_deposito"></td>
                    </tr>
                    <tr>
                        <th>Fecha de Pago</th>
                        <td id="show_fecha_pago"></td>
                    </tr>
                    <tr>
                        <th>Notas</th>
                        <td id="show_comentarios"></td>
                    </tr>
                    <tr>
                        <th>Factura</th>
                        <td id="show_archivo"></td>
                    </tr>
                    <tr>
                        <th>Comprobante</th>
                        <td id="show_comprobante"></td>
                    </tr>
                </table>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-warning"
                        data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>
