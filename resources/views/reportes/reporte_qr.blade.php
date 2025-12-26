@extends('layouts.plantilla')
@section('title','Reporte QR')
@section('content')

<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">Reporte de Programaciones con QR</h4>
</div>

<form action="{{ route('reportes.qr') }}" method="GET" class="d-flex align-items-center mb-3">

    <div class="me-2">
        <input type="date"
               name="fecha_inicio"
               class="form-control form-control-sm"
               value="{{ $fechaInicio ?? '' }}"
               required>
    </div>

    <div class="me-2">
        <input type="date"
               name="fecha_fin"
               class="form-control form-control-sm"
               value="{{ $fechaFin ?? '' }}"
               required>
    </div>

    <button type="submit" class="btn btn-primary btn-sm me-2">
        <i class="ri-filter-3-line"></i> Filtrar
    </button>

    <a href="{{ route('reportes.export_qr', request()->query()) }}"
       class="btn btn-success btn-sm me-2">
        <i class="ri-file-excel-2-line"></i> Exportar
    </a>

    <a href="{{ route('programacions.index') }}" class="btn btn-secondary btn-sm">
        Volver
    </a>

</form>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Placa Tracto</th>
                    <th>Licencia</th>
                    <th>DNI</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>RUC</th>
                    <th>Razón Social</th>
                    <th>Tipo Operación</th>
                    <th>Placa Carreta</th>
                    <th>Guía Remisión</th>
                    <th>Grupo Carguío</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programaciones as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    {{-- Placa Tracto --}}
                    <td>{{ $p->unidad?->placa_tracto ?? '-' }}</td>

                    {{-- Licencia --}}
                    <td>{{ $p->conductor?->licencia ?? '-' }}</td>

                    {{-- DNI --}}
                    <td>{{ $p->conductor?->dni ?? '-' }}</td>

                    {{-- Nombres --}}
                    <td>{{ $p->conductor?->nombres ?? '-' }}</td>

                    {{-- Apellidos --}}
                    <td>{{ $p->conductor?->apellidos ?? '-' }}</td>

                    {{-- RUC --}}
                    <td>{{ $p->proveedor?->ruc_transporte ?? '-' }}</td>

                    {{-- Razón Social --}}
                    <td class="text-start">
                        {{ $p->proveedor?->razon_social ?? '-' }}
                    </td>

                    {{-- Tipo Operación --}}
                    <td>{{ ucfirst($p->tipo_operacion ?? '-') }}</td>

                    {{-- Placa Carreta --}}
                    <td>{{ $p->unidad?->placa_carreta ?? '-' }}</td>

                    {{-- Guía Remisión --}}
                    <td>{{ $p->guia_remision ?? '-' }}</td>

                    {{-- Grupo Carguío --}}
                    <td>{{ $p->grupo_cargio ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" class="text-center text-muted">
                        No hay registros
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
