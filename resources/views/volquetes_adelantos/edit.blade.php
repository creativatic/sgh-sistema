<div class="modal fade"
     id="modalEditAdelanto{{ $volquete->id }}"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <form method="POST"
              action="{{ route('volquetes_adelantos.update', $volquete->id) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">
                        Editar Adelanto de Volquete
                    </h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">

                    {{-- DATOS GENERALES --}}
                    <h5 class="fw-bold">Datos Generales</h5>
                    <hr>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label>Fecha de Programación</label>
                            <input type="date"
                                   class="form-control"
                                   value="{{ $volquete->fecha }}"
                                   readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Proveedor</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $volquete->proveedor->razon_social ?? '-' }}"
                                   readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Frente</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $volquete->detalleProgramacion->frente ?? '-' }}"
                                   readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Precio por Tonelada</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $volquete->detalleProgramacion->precio_tn ?? '-' }}"
                                   readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Factura (PDF)</label><br>

                            @if($volquete->factura)
                                <a href="{{ asset($volquete->factura) }}"
                                target="_blank"
                                class="btn btn-outline-primary btn-sm me-1">
                                    <i class="ri-eye-line"></i> Ver PDF
                                </a>

                                <a href="{{ asset($volquete->factura) }}"
                                download
                                class="btn btn-outline-secondary btn-sm">
                                    <i class="ri-download-line"></i> Descargar
                                </a>
                            @else
                                <span class="text-muted">No registrado</span>
                            @endif
                        </div>


                    </div>

                    {{-- DETALLES DE VUELTAS --}}
                    <h5 class="fw-bold mt-4">Detalles de Vueltas</h5>
                    <hr>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label>Hora Vuelta 1</label>
                            <input class="form-control"
                                   value="{{ $volquete->hora_vuelta_1 }}"
                                   readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Lampadas 1</label>
                            <input class="form-control"
                                   value="{{ $volquete->lampadas_vuelta_1 }}"
                                   readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Peso 1</label>
                            <input class="form-control"
                                   value="{{ $volquete->peso_vuelta_1 }}"
                                   readonly>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label>Hora Vuelta 2</label>
                            <input class="form-control"
                                   value="{{ $volquete->hora_vuelta_2 }}"
                                   readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Lampadas 2</label>
                            <input class="form-control"
                                   value="{{ $volquete->lampadas_vuelta_2 }}"
                                   readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Peso 2</label>
                            <input class="form-control"
                                   value="{{ $volquete->peso_vuelta_2 }}"
                                   readonly>
                        </div>
                    </div>

                    {{-- MONTOS --}}
                    <h5 class="fw-bold mt-4">Montos</h5>
                    <hr>

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label>Total S/</label>
                            <input class="form-control"
                                   value="{{ $volquete->total }}"
                                   readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Detracción</label>
                            <input class="form-control"
                                   value="{{ $volquete->detraccion }}"
                                   readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Retención</label>
                            <input class="form-control"
                                   value="{{ $volquete->retencion }}"
                                   readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Depósito a Proveer</label>
                            <input class="form-control"
                                   value="{{ $volquete->deposito_a_proveer }}"
                                   readonly>
                        </div>

                        <div class="col-md-3">
                            <label>Depósito Total</label>
                            <input class="form-control"
                                   value="{{ $volquete->deposito_total }}"
                                   readonly>
                        </div>

                        <div class="col-md-3">
                            <label>Conformidad</label>
                            <input class="form-control"
                                   value="{{ $volquete->conformidad }}"
                                   readonly>
                        </div>
                    </div>

                    {{-- CAMPOS EDITABLES --}}
                    <h5 class="fw-bold mt-4">Pago</h5>
                    <hr>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label>Fecha de Pago</label>
                            <input type="date"
                                   name="fecha_pago"
                                   class="form-control"
                                   value="{{ $volquete->fecha_pago }}">
                        </div>

                        <div class="col-md-4">
                            <label>Comprobante de Pago (PDF)</label>

                            <input type="file"
                                   name="comprobante_pago"
                                   class="form-control"
                                   accept="application/pdf">

                            <h1></h1>

                            @if($volquete->comprobante_pago)
                                <div class="mb-1">
                                    <a href="{{ asset($volquete->comprobante_pago) }}"
                                       target="_blank"
                                       class="btn btn-outline-primary btn-sm">
                                        Ver PDF
                                    </a>
                                </div>
                            @endif
                            
                        </div>

                        <div class="col-md-4">
                            <label>Notas</label>
                            <textarea name="observaciones"
                                      class="form-control"
                                      rows="2">{{ $volquete->observaciones }}</textarea>
                        </div>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="modal-footer">
                    <button class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button class="btn btn-warning">
                        Guardar Adelanto
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>
