@extends('layouts.plantilla')

@section('title','Proveedores')

@section('content')

{{-- Modal Crear --}}
@include('proveedores.create')

<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">Gestión de Proveedores</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Proveedores</a></li>
            <li class="breadcrumb-item active">Gestión de Proveedores</li>
        </ol>
    </div>
</div>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreateProveedor">
    <i class="ri-add-circle-line"></i> Nuevo Proveedor
</button>

<form method="GET" action="{{ route('proveedores.index') }}" class="mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-md-4">
            <input 
                type="text"
                name="search"
                class="form-control"
                placeholder="Buscar por Razón Social o RUC..."
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
                <a href="{{ route('proveedores.index') }}" class="btn btn-outline-primary w-100">
                    <i class="ri-refresh-line"></i> Limpiar
                </a>
            </div>
        @endif
    </div>
</form>


<div class="card mt-3">
    <div class="card-body table-responsive">
        <table class="table table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Razón Social</th>
                    <th>RUC</th>
                    <th>Banco</th>
                    <th>Cuenta</th>
                    <th>CCI</th>
                    <th width="120">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proveedores as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->razon_social }}</td>
                    <td>{{ $p->ruc_transporte }}</td>
                    <td>{{ $p->banco }}</td>
                    <td>{{ $p->cuenta_banco }}</td>
                    <td>{{ $p->cci_banco }}</td>

                    <td class="text-center">
                        <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditProveedor{{ $p->id }}">
                            <i class="ri-edit-line"></i>
                        </button>

                        <form action="{{ route('proveedores.destroy', $p) }}"
                              method="POST"
                              class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Eliminar proveedor?')">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                {{-- Modal Editar --}}
                @include('proveedores.edit', ['proveedor' => $p])

                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay proveedores registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $proveedores->links() }}
        </div>
    </div>
</div>

@endsection

{{-- Script para evitar que los modales muestren datos viejos --}}
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function () {
                const form = this.querySelector('form');
                if (form) form.reset();
            });
        });
    });
</script>
@endsection
