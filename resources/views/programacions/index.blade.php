@extends('layouts.plantilla')

@section('title', 'Programación')

@section('content')
@include('programacions.create')
@include('programacions.show')
@include('programacions.edit')


<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">Gestión de Programaciones</h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Programación</a></li>
            <li class="breadcrumb-item active">Gestión de Programaciones</li>
        </ol>
    </div>
</div>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createProgramacionModal">
    <i class="ri-add-circle-line"></i> Nueva Programación
</button>

<form method="GET" action="{{ route('programacions.index') }}" class="mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-md-4">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Buscar por Guía, Proveedor o Placa Tracto..."
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
                <a href="{{ route('programacions.index') }}" class="btn btn-outline-primary w-100">
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
                        <th>#</th>
                        <th>Fecha Programación</th>
                        <th>Guía Remisión</th>

                        <!-- Conductor -->
                        <th>Proveedor Razon Social</th>
                        <th>Nombres Conductor</th>
                        <th>Apellidos Conductor</th>
                        <th>Teléfono</th>
                        <th>Placa Tracto</th>

                        <!-- Servicio -->
                        <th>Tipo Mineral</th>
                        <th>Operación</th>
                        <th>Frente</th>

                        <!-- Adelantos -->
                        
                        <th>Monto Adelanto</th>

                        <th>Guía Transportista</th>

                        <th>Conformidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                        @forelse($programaciones as $programacion)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($programacion->fecha_programacion)->format('d/m/Y') }}</td>
                                <td>{{ $programacion->guia_remision ?? '-' }}</td>

                              
                                <td>{{ $programacion->proveedor?->razon_social ?? '-' }}</td>

                                <td>{{ $programacion->conductor?->nombres ?? '-' }}</td>
                                <td>{{ $programacion->conductor?->apellidos ?? '-' }}</td>
                                <td>{{ $programacion->conductor?->telefono ?? '-' }}</td>

                                <td>{{ $programacion->unidad?->placa_tracto ?? '-' }}</td>

                                <td>{{ $programacion->tipo_mineral ?? '-' }}</td>
                                <td>{{ $programacion->tipo_operacion ?? '-' }}</td>
                                <td>{{ $programacion->detalleProgramacion?->frente ?? '—' }}</td>

                                <td>{{ $programacion->monto_adelanto ? 'S/ '.number_format($programacion->monto_adelanto,2) : '-' }}</td>
                                <td>{{ $programacion->guia_transportista ?? '-' }}</td>

                                <td class="text-center">
                                    @role('Administrador')
                                        <form action="{{ route('programacions.conformidad', $programacion->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    role="switch"
                                                    name="conformidad_adelanto"
                                                    value="Ok"
                                                    {{ $programacion->conformidad_adelanto === 'Ok' ? 'checked' : '' }}
                                                    onchange="this.form.submit()"
                                                >
                                            </div>
                                        </form>

                                        {{-- TEXTO DE ESTADO --}}
                                        <small class="fw-bold d-block mt-1
                                            {{ $programacion->conformidad_adelanto === 'Ok' ? 'text-success' : 'text-danger' }}">
                                            {{ $programacion->conformidad_adelanto === 'Ok' ? 'OK' : 'Pendiente' }}
                                        </small>

                                    @else
                                        {{-- Supervisor y otros roles: solo lectura --}}
                                        <span class="badge 
                                            {{ $programacion->conformidad_adelanto === 'Ok' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $programacion->conformidad_adelanto === 'Ok' ? 'OK' : 'Pendiente' }}
                                        </span>
                                    @endrole
                                </td>

                                <td>
                                    {{-- Botones de acciones --}}

                                    <button type="button" class="btn btn-info btn-sm"
                                        onclick="verProgramacion({{ $programacion->id }})">
                                        <i class="fas fa-eye"></i> Ver
                                    </button>

                                    {{-- COMENTAR BOTON--}}
                                    <button type="button"
                                            class="btn btn-warning btn-sm"
                                            onclick="editarProgramacion({{ $programacion->id }})">
                                        <i class="ri-edit-2-line"></i>
                                    </button>

                                    
                                    <form action="{{ route('programacions.destroy', $programacion->id) }}" 
                                        method="POST" style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="20" class="text-muted">No hay registros.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Mostrando 
                    {{ $programaciones->firstItem() }} 
                    a 
                    {{ $programaciones->lastItem() }} 
                    de 
                    {{ $programaciones->total() }} registros
                </div>

                <div>
                    {{ $programaciones->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
</div>

@endsection

