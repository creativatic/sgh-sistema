@extends('layouts.plantilla')

@section('title', 'Adelanto de Volquetes')

@section('content')

<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">Gestión de Volquetes - Adelantos</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Volquetes Adelantos</a>
            </li>
            <li class="breadcrumb-item active">Listado</li>
        </ol>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body table-responsive">

        <table class="table table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Fecha Programada</th>
                    <th>Proveedor</th>
                    <th>Cuenta Bancaria</th>
                    <th>Cuenta CCI</th>
                    <th>Banco</th>
                    <th>Frente</th>
                    <th>Lampadas</th>
                    <th>Peso Total</th>
                    <th>Deposito a Proveer S/</th>
                    <th>Conformidad</th>
                    <th>Fecha de Pago</th>
                    <th>Notas</th>
                    <th width="120">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($volquetes as $v)
                <tr>
                    
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $v->fecha }}</td>

                    {{-- proveedor --}}
                    <td>{{ $v->proveedor->razon_social ?? '-' }}</td>

                    {{-- cuenta bancaria --}}
                    <td>{{ $v->proveedor->cuenta_banco ?? '-' }}</td>

                    {{-- cuenta cci --}}
                    <td>{{ $v->proveedor->cci_banco ?? '-' }}</td>

                    {{-- banco del proveedor --}}
                    <td>{{ $v->proveedor->banco ?? '-' }}</td>

                    {{-- frente --}}
                    <td>{{ $v->detalleProgramacion->frente ?? '-' }}</td>

                    {{-- Lampadas --}}
                    <td>
                        {{ ($v->lampadas_vuelta_1 ?? 0) + ($v->lampadas_vuelta_2 ?? 0) }}
                    </td>

                    {{-- peso total --}}
                    <td>{{ number_format($v->total_peso_dia ?? 0, 2) }}</td>

                    {{-- total --}}
                    <td>{{ number_format($v->deposito_total ?? 0, 2) }}</td> 
                    
                    {{-- conformidad --}}
                    <td>
                        @if($v->conformidad === 'Pendiente')
                            <span class="badge bg-warning">Pendiente</span>
                        @else
                            <span class="badge bg-success">{{ $v->conformidad }}</span>
                        @endif
                    </td>

                    {{-- fecha de pago --}}
                    <td>{{ $v->fecha_pago ?? '-' }}</td>

                    {{-- observaciones --}}
                    <td>{{ $v->observaciones ?? '-' }}</td>

                    {{-- acciones --}}
                    <td>
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalShowVolquete{{ $v->id }}">
                            <i class="ri-eye-line"></i>
                        </button>

                        <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditAdelanto{{ $v->id }}"
                                title="Editar Adelanto">
                            <i class="ri-edit-line"></i>
                        </button>
                    </td>
                </tr>

                {{-- 🔵 MODAL SHOW (REUTILIZADO) --}}
                @include('volquetes.show', ['volquete' => $v])

                {{-- 🟠 MODAL EDITAR ADELANTO --}}
                @include('volquetes_adelantos.edit', ['volquete' => $v])

                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted">
                        No hay registros de adelantos
                    </td>
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
