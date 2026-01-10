<div class="modal fade" id="modalShowVolquete{{ $volquete->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detalle del Volquete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- =========================
                DATOS GENERALES
                ========================= --}}
                <h5 class="fw-bold">Datos Generales</h5>
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Fecha:</strong> {{ $volquete->fecha }}</p>
                        <p><strong>Proveedor:</strong> {{ $volquete->proveedor->razon_social ?? '-' }}</p>
                        <p><strong>Frente:</strong> {{ $volquete->detalleProgramacion->frente ?? '-' }}</p>
                        <p><strong>Conformidad:</strong> 
                            <span class="fw-bold
                                {{ $volquete->conformidad === 'Ok' ? 'text-success' : 'text-danger' }}">
                                {{ $volquete->conformidad === 'Ok' ? 'OK' : 'Pendiente' }}
                            </span>                                                              
                    </div>

                    <div class="col-md-6">
                        <p><strong>Observaciones:</strong> {{ $volquete->observaciones ?? '-' }}</p>

                        {{-- FACTURA --}}
                        <p>
                            <strong>Factura:</strong>
                            @if($volquete->factura)
                                <a href="{{ asset($volquete->factura) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary ms-2">
                                    Ver PDF
                                </a>

                                <a href="{{ asset($volquete->factura) }}"
                                    download
                                    class="btn btn-sm btn-outline-secondary ms-1">
                                    Descargar
                                </a>
                            @else
                                <span class="text-muted">No adjunto</span>
                            @endif
                        </p>

                        {{-- COMPROBANTE DE PAGO --}}
                        <p>
                            <strong>Comprobante de Pago:</strong>
                            @if($volquete->comprobante_pago)
                                <a href="{{ asset($volquete->comprobante_pago) }}" 
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary ms-2">
                                    Ver PDF
                                </a>
                                <a href="{{ asset($volquete->comprobante_pago) }}" 
                                    download
                                    class="btn btn-sm btn-outline-secondary ms-1">
                                    Descargar
                                </a>
                            @else
                                <span class="text-muted">No adjunto</span>
                            @endif
                        </p>
                        <p>
                            <strong>Estado Impresión Factura:</strong>
                            <span class="fw-bold
                                {{ $volquete->estado_impresion_volquetes === 'Ok' ? 'text-success' : 'text-danger' }}">
                                {{ $volquete->estado_impresion_volquetes === 'Ok' ? 'OK' : 'Pendiente' }}
                            </span>
                        </p>
                    </div>
                </div>

                {{-- =========================
                DETALLES DE VUELTAS
                ========================= --}}
                <h5 class="fw-bold mt-4">Detalles de Vueltas</h5>
                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Hora Vuelta 1:</strong> {{ $volquete->hora_vuelta_1 ?? '-' }}</p>
                        <p><strong>Lampadas Vuelta 1:</strong> {{ $volquete->lampadas_vuelta_1 ?? 0 }}</p>
                        <p><strong>Peso Vuelta 1:</strong> {{ $volquete->peso_vuelta_1 ?? 0 }}</p>
                    </div>

                    <div class="col-md-4">
                        <p><strong>Hora Vuelta 2:</strong> {{ $volquete->hora_vuelta_2 ?? '-' }}</p>
                        <p><strong>Lampadas Vuelta 2:</strong> {{ $volquete->lampadas_vuelta_2 ?? 0 }}</p>
                        <p><strong>Peso Vuelta 2:</strong> {{ $volquete->peso_vuelta_2 ?? 0 }}</p>
                    </div>

                    <div class="col-md-4">
                        <p><strong>Total Lampadas Día:</strong> {{ $volquete->total_lampadas_dia ?? 0 }}</p>
                        <p><strong>Total Peso Día:</strong> {{ $volquete->total_peso_dia ?? 0 }}</p>
                        <p><strong>Pasadas:</strong> {{ $volquete->pasadas ?? 0 }}</p>
                    </div>
                </div>

                {{-- =========================
                MONTOS
                ========================= --}}
                <h5 class="fw-bold mt-4">Montos</h5>
                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Detracción:</strong> {{ number_format($volquete->detraccion, 2) }}</p>
                        <p><strong>Total - detraccion y retencion:</strong> {{ number_format($volquete->deposito_a_proveer, 2) }}</p>

                    </div>

                    <div class="col-md-4">
                        <p><strong>Total S/:</strong> {{ number_format($volquete->total, 2) }}</p>
                        <p><strong>Detracción:</strong> {{ number_format($volquete->detraccion, 2) }}</p>
                        <p><strong>Depósito a Proveer:</strong> {{ number_format($volquete->deposito_total, 2) }}</p>
                    </div>


                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>
