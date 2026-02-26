@extends('layouts.plantilla')
@section('title','Volquetes')
@section('content')
@include('volquetes.create') {{-- Modal Crear Volquete --}}



<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">Gestion de Volquetes</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Volquetes</a></li>
            <li class="breadcrumb-item active">Listado</li>
        </ol>
    </div>
</div>

<form method="GET" action="{{ route('volquetes.index') }}" class="mb-3">
    <div class="row g-2 align-items-center">

        <div class="col-md-4">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Buscar por Proveedor o Placa Tracto..."
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
                <a href="{{ route('volquetes.index') }}" class="btn btn-outline-primary w-100">
                    <i class="ri-refresh-line"></i> Limpiar
                </a>
            </div>
        @endif

    </div>
</form>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreateVolquete">
    <i class="ri-add-circle-line"></i> Nuevo Volquete
</button>

<div class="card mt-3">
    <div class="card-body table-responsive">

        <table class="table table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Fecha Programada</th>
                    <th>Proveedor</th>
                    <th>Placa Tracto</th>
                    <th>Cuenta Bancaria</th>
                    <th>Cuenta CCI</th>
                    <th>Banco</th>
                    <th>Frente</th>
                    <th>Lampadas</th>
                    <th>Peso Total</th>
                    <th>Deposito a Proveer S/</th>
                    <th>Conformidad Pago</th>
                    
                                        
                    <th>Fecha de Pago</th>
                    <th>Notas</th>
                    <th>Impresion Factura</th>
                    <th width="120">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($volquetes as $v)
                <tr>
                    <td>{{ $v->fecha }}</td>
                    
                    {{-- proveedor --}}
                    <td>{{ $v->proveedor->razon_social ?? '-' }}</td>

                    <td>
                        {{ $v->unidad->placa_tracto ?? '-' }}
                    </td>

                    {{-- cuenta bancaria --}}
                    <td>{{ $v->proveedor->cuenta_banco ?? '-' }}</td>

                    {{-- cuenta cci --}}
                    <td>{{ $v->proveedor->cci_banco ?? '-' }}</td>

                    {{-- banco del proveedor --}}
                    <td>{{ $v->proveedor->banco ?? '-' }}</td>

                    {{-- frente --}}
                    <td>{{ $v->detalleProgramacion->frente ?? '-' }}</td>

                    {{-- lampadas --}}
                    <td>{{ ($v->lampadas_vuelta_1 ?? 0) + ($v->lampadas_vuelta_2 ?? 0) }}</td>

                    {{-- peso total --}}
                    <td>{{ number_format($v->total_peso_dia ?? 0, 2) }}</td>
                    <td>{{ number_format($v->deposito_total, 2) }}</td>
                    
                    {{-- conformidad --}}
                    <td class="text-center">
                        @role('Administrador')
                            <form action="{{ route('volquetes.conformidad', $v->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        name="conformidad"
                                        value="Ok"
                                        {{ $v->conformidad === 'Ok' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                    >
                                </div>
                            </form>

                            <small class="fw-bold d-block mt-1
                                {{ $v->conformidad === 'Ok' ? 'text-success' : 'text-danger' }}">
                                {{ $v->conformidad === 'Ok' ? 'OK' : 'Pendiente' }}
                            </small>
                        @else
                            {{-- Otros roles: solo lectura --}}
                            <span class="badge
                                {{ $v->conformidad === 'Ok' ? 'bg-success' : 'bg-danger' }}">
                                {{ $v->conformidad === 'Ok' ? 'OK' : 'Pendiente' }}
                            </span>
                        @endrole
                    </td>
                    <td>{{ $v->fecha_pago }}</td>
                    <td>{{ $v->observaciones }}</td>
                    
                    {{-- estado impresión factura --}}
                    <td class="text-center">
                        @php
                            $estadoImpresion = $v->estado_impresion_volquetes ?? 'Pendiente';
                        @endphp

                        @role('Administrador')
                            <form action="{{ route('volquetes.estado_impresion', $v->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        name="estado_impresion_volquetes"
                                        value="Ok"
                                        {{ $estadoImpresion === 'Ok' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                    >
                                </div>
                            </form>

                            <small class="fw-bold d-block mt-1
                                {{ $estadoImpresion === 'Ok' ? 'text-success' : 'text-danger' }}">
                                {{ $estadoImpresion === 'Ok' ? 'OK' : 'Pendiente' }}
                            </small>
                        @else
                            <span class="badge
                                {{ $estadoImpresion === 'Ok' ? 'bg-success' : 'bg-danger' }}">
                                {{ $estadoImpresion === 'Ok' ? 'OK' : 'Pendiente' }}
                            </span>
                        @endrole
                    </td>

                    <td>

                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalShowVolquete{{ $v->id }}">
                            <i class="ri-eye-line"></i>
                        </button>

                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditVolquete{{ $v->id }}">
                            <i class="ri-edit-line"></i>
                        </button>

                        <form action="{{ route('volquetes.destroy', $v->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar volquete?')">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                {{-- Modal Editar --}}
                @include('volquetes.edit', [
                    'volquete' => $v,
                    'proveedores' => $proveedores,
                    'frentes' => $frentes
                ])

                @include('volquetes.show', [
                    'volquete' => $v
                ])

                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No hay registros de volquetes</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $volquetes->links() }}
        </div>

    </div>
</div>

@endsection
