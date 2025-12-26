@extends('layouts.plantilla')

@section('title', 'Expediente Pagos')

@section('content')
@include('expediente_pagos.edit')

<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">Listado de Expediente Pagos</h4>
</div>

<div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Guía Remisión</th>
                        <th>Placa Tracto</th>
                        <th>Tipo Mineral</th>
                        <th>Frente</th>
                        <th>Razón Social</th>
                        <th>Banco</th>
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
                        <td>{{ $programacion->proveedor?->unidades?->first()?->placa_tracto ?? '-' }}</td>
                        <td>{{ $programacion->tipo_mineral ?? '-' }}</td>
                        <td>{{ $programacion->detalleProgramacion?->frente ?? '-' }}</td>
                        <td>{{ $programacion->proveedor?->razon_social ?? '-' }}</td>
                        <td>{{ $programacion->proveedor?->banco ?? '-' }}</td>

                        <td>
                            @if($expediente)
                                <button
                                    class="btn btn-primary btn-sm"
                                    onclick="editarExpedientePago({{ $expediente->id }})">
                                    Editar Pago
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

            document.getElementById('expediente_pago_id').value = data.id;
            document.getElementById('fecha_pago').value = data.fecha_pago ?? '';
            document.getElementById('comentarios').value = data.comentarios ?? '';

            const archivoDiv = document.getElementById('archivoActual');
            archivoDiv.innerHTML = '';

            if (data.archivo) {
                archivoDiv.innerHTML = `
                    <a href="/storage/${data.archivo}"
                       target="_blank"
                       class="btn btn-outline-primary btn-sm">
                        📄 Ver comprobante actual
                    </a>
                `;
            }

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
document.getElementById('editExpedientePagoForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('expediente_pago_id').value;
    const formData = new FormData(this);

    fetch(`/expediente-pagos/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(res => res.json())
    .then(resp => {
        if (resp.success) {
            alert(resp.message);
            location.reload();
        } else {
            alert(resp.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error al guardar');
    });
});
</script>


@endsection
