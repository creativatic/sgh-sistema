@extends('layouts.plantilla')

@section('title', 'Expediente Pagos')

@section('content')
@include('expediente_pagos.edit')
@include('expediente_pagos.show')

<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">Listado de Expediente Pagos</h4>
</div>

<form method="GET" action="{{ route('expediente_pagos.index') }}" class="mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-md-5">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Buscar por Guía, Ticket, Placa, RUC, Razón Social o Banco..."
                value="{{ request('search') }}"
            >
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="ri-search-line"></i> Buscar
            </button>
        </div>

        @if(request('search'))
            <div class="col-md-2">
                <a href="{{ route('expediente_pagos.index') }}" class="btn btn-outline-primary w-100">
                    <i class="ri-refresh-line"></i> Limpiar
                </a>
            </div>
        @endif
    </div>
</form>

<div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Guía Remisión</th>
                        <th>N° Ticket (Tisur)</th>
                        <th>Fechas de carga (Tisur)</th>
                        <th>Placa Tracto</th>
                        <th>Tipo Mineral</th>
                        <th>Frente</th>
                        <th>Ruc</th>
                        <th>Razón Social</th>
                        <th>Cuenta Bancaria</th>
                        <th>CCI</th>
                        <th>Banco</th>
                        <th>Deposito a proveer</th>
                        <th>Fecha de pago</th>
                        <th>Notas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($programaciones as $index => $programacion)

                    @php
                        $expediente = $programacion->expedientes->first();
                    @endphp

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $programacion->guia_remision ?? '-' }}</td>
                        <td>{{ $expediente?->tisur?->numero_ticket ?? '-' }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($programacion->fecha_hora_salida)->format('Y-m-d') }}
                        </td>
                        <td>{{ $programacion->proveedor?->unidades?->first()?->placa_tracto ?? '-' }}</td>
                        <td>{{ $programacion->tipo_mineral ?? '-' }}</td>
                        <td>{{ $programacion->detalleProgramacion?->frente ?? '-' }}</td>
                        <td>{{ $programacion->proveedor?->ruc_transporte ?? '-' }}</td>
                        <td>{{ $programacion->proveedor?->razon_social ?? '-' }}</td>
                        <td>{{ $programacion->proveedor?->cuenta_banco ?? '-' }}</td>
                        <td>{{ $programacion->proveedor?->cci_banco ?? '-' }}</td>
                        <td>{{ $programacion->proveedor?->banco ?? '-' }}</td>
                        <td>{{ $expediente?->deposito_a_proveer ?? '-' }}</td>
                        <td>{{ $expediente?->fecha_pago ?? '-' }}</td>
                        <td>{{ $expediente?->comentarios ?? '-' }}</td>

                        <td>
                            @if($expediente)

                                <button
                                    class="btn btn-info btn-sm mb-1"
                                    onclick="verExpedientePago({{ $expediente->id }})">
                                    <i class="ri-eye-line"></i> Ver
                                </button>

                                <button
                                    class="btn btn-warning btn-sm"
                                    onclick="editarExpedientePago({{ $expediente->id }})">
                                    <i class="ri-edit-line"></i> Editar Pago
                                </button>

                            @else
                                <span class="badge bg-secondary">Sin expediente</span>
                            @endif
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No se encontraron registros
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $programaciones->links() }}
        </div>
    </div>
</div>

<script>
function editarExpedientePago(id) {

    fetch(`/expediente-pagos/${id}/edit`)
        .then(res => {
            if (!res.ok) throw new Error('Error al obtener datos');
            return res.json();
        })
        .then(resp => {

            const data = resp.data;

            // ===============================
            // DATOS SOLO VISUALIZACIÓN
            // ===============================
            document.getElementById('view_guia_remision').value =
                data.programacion?.guia_remision ?? '-';

            document.getElementById('view_ticket').value =
                data.tisur?.numero_ticket ?? '-';

            document.getElementById('view_placa').value =
                data.programacion?.proveedor?.unidades?.[0]?.placa_tracto ?? '-';

            document.getElementById('view_ruc').value =
                data.programacion?.proveedor?.ruc_transporte ?? '-';

            document.getElementById('view_razon_social').value =
                data.programacion?.proveedor?.razon_social ?? '-';

            document.getElementById('view_banco').value =
                data.programacion?.proveedor?.banco ?? '-';

            document.getElementById('view_cuenta').value =
                data.programacion?.proveedor?.cuenta_banco ?? '-';

            document.getElementById('view_cci').value =
                data.programacion?.proveedor?.cci_banco ?? '-';

            document.getElementById('view_deposito').value =
                data.deposito_a_proveer ?? '-';


            document.getElementById('expediente_pago_id').value = data.id;
            document.getElementById('fecha_pago').value = data.fecha_pago ?? '';
            document.getElementById('comentarios').value = data.comentarios ?? '';

            const modal = new bootstrap.Modal(
                document.getElementById('editExpedientePagoModal')
            );
            modal.show();
        })
        .catch(err => {
            console.error(err);
            alert('No se pudo cargar el expediente');
        });
}

/* SUBMIT FORM */
/* Reemplaza el bloque SUBMIT FORM en index.blade.php */
/* Reemplaza este bloque en tu archivo index.blade.php */
document.getElementById('editExpedientePagoForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('expediente_pago_id').value;
    const formData = new FormData(this);

    // Forzamos el método PUT dentro del FormData para que Laravel lo reconozca
    formData.set('_method', 'PUT'); 

    fetch(`/expediente-pagos/${id}`, {
        method: 'POST', // <--- CAMBIO CLAVE: Aquí debe ser POST
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
            // NOTA: No agregues 'Content-Type', el navegador lo configurará 
            // automáticamente como multipart/form-data con el boundary correcto.
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) {
            console.error('Errores del servidor:', data);
            throw new Error(data.message || 'Error en la validación');
        }
        return data;
    })
    .then(resp => {
        alert(resp.message);
        location.reload();
    })
    .catch(err => {
        console.error('ERROR DETALLADO:', err);
        alert('Error al guardar: ' + err.message);
    });
});

function verExpedientePago(id) {

    fetch(`/expediente-pagos/${id}`)
        .then(res => {
            if (!res.ok) throw new Error('Error al obtener datos');
            return res.json();
        })
        .then(resp => {

            const d = resp.data;

            // ==== PROGRAMACIÓN ====
            document.getElementById('show_guia_remision').textContent = d.programacion?.guia_remision ?? '-';
            document.getElementById('show_placa').textContent = d.programacion?.proveedor?.unidades?.[0]?.placa_tracto ?? '-';
            document.getElementById('show_frente').textContent = d.programacion?.detalle_programacion?.frente ?? '-';
            document.getElementById('show_tipo_mineral').textContent = d.programacion?.tipo_mineral ?? '-';

            // ==== PROVEEDOR ====
            document.getElementById('show_razon_social').textContent = d.programacion?.proveedor?.razon_social ?? '-';
            document.getElementById('show_ruc').textContent = d.programacion?.proveedor?.ruc_transporte ?? '-';
            document.getElementById('show_banco').textContent = d.programacion?.proveedor?.banco ?? '-';
            document.getElementById('show_cuenta').textContent = d.programacion?.proveedor?.cuenta_banco ?? '-';
            document.getElementById('show_cci').textContent = d.programacion?.proveedor?.cci_banco ?? '-';

            // ==== EXPEDIENTE ====
            document.getElementById('show_ticket').textContent = d.tisur?.numero_ticket ?? '-';
            document.getElementById('show_fecha_carga').textContent =
                d.fecha_carga ? d.fecha_carga.split(' ')[0] : '-';

            document.getElementById('show_deposito').textContent = d.deposito_a_proveer ?? '-';
            document.getElementById('show_fecha_pago').textContent = d.fecha_pago ?? '-';
            document.getElementById('show_comentarios').textContent = d.comentarios ?? '-';

            // =====================
            // FACTURA (EXPEDIENTE)
            // =====================
            const facturaDiv = document.getElementById('show_archivo');
            facturaDiv.innerHTML = '';

            let facturas = [];

            if (Array.isArray(d.archivo)) {
                facturas = d.archivo;
            } else if (typeof d.archivo === 'string') {
                try {
                    facturas = JSON.parse(d.archivo);
                } catch (e) {
                    facturas = [d.archivo];
                }
            }

            if (facturas.length > 0) {
                facturas.forEach(file => {
                    if (!file) return;

                    const nombre = file.split('/').pop();
                    const url = `/expediente/archivo/${nombre}`;

                    facturaDiv.innerHTML += `
                        <a href="${url}"
                        target="_blank"
                        class="btn btn-outline-warning btn-sm d-block mb-1">
                            📄 Ver factura 
                        </a>
                    `;
                });
            } else {
                facturaDiv.innerHTML = `<span class="text-muted">No adjunta</span>`;
            }


            // =====================
            // COMPROBANTE DE PAGO
            // =====================
            const comprobanteDiv = document.getElementById('show_comprobante');
            comprobanteDiv.innerHTML = '';

            if (d.archivo_comprobante_pago) {
                comprobanteDiv.innerHTML = `
                    <a href="/${d.archivo_comprobante_pago}"
                    target="_blank"
                    class="btn btn-outline-warning btn-sm d-block mb-1">
                        📄 Ver comprobante
                    </a>
                `;
            } else {
                comprobanteDiv.innerHTML = `<span class="text-muted">No adjunto</span>`;
            }

            const modal = new bootstrap.Modal(
                document.getElementById('showExpedientePagoModal')
            );
            modal.show();
        })
        .catch(err => {
            console.error(err);
            alert('No se pudo cargar el expediente');
        });
}
</script>


@endsection
