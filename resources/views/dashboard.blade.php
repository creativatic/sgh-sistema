@extends('layouts.plantilla')

@section('title','Dashboard Analítico')

@section('content')
<div class="container-fluid">

    {{-- ================= FILTRO FECHAS ================= --}}
    <form method="GET" class="row mb-4">
        <div class="col-md-3">
            <input type="date" name="fecha_inicio" 
                   value="{{ $fechaInicio->format('Y-m-d') }}" 
                   class="form-control">
        </div>
        <div class="col-md-3">
            <input type="date" name="fecha_fin" 
                   value="{{ $fechaFin->format('Y-m-d') }}" 
                   class="form-control">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                Filtrar
            </button>
        </div>
    </form>

    {{-- ================= KPIs ================= --}}
    <div class="row">

        <div class="col-md-3">
            <div class="card bg-primary text-white shadow border-0 mb-4">
                <div class="card-body text-center">
                    <small class="text-uppercase">Peso Total (TN)</small>
                    <h4>{{ number_format($kpis->total_peso_neto,2) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white shadow border-0 mb-4">
                <div class="card-body text-center">
                    <small class="text-uppercase">Expedientes</small>
                    <h4>{{ $kpis->total_viajes }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white shadow border-0 mb-4">
                <div class="card-body text-center">
                    <small class="text-uppercase">Facturado</small>
                    <h4>S/ {{ number_format($kpis->total_facturado,2) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark text-white shadow border-0 mb-4">
                <div class="card-body text-center">
                    <small class="text-uppercase">Margen Bruto</small>
                    <h4>S/ {{ number_format($kpis->margen_bruto,2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= GRÁFICOS PRINCIPALES ================= --}}
    <div class="row">

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-white">
                    <strong>Peso por Frente</strong>
                </div>
                <div class="card-body">
                    <canvas id="chartFrentes"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-white">
                    <strong>Tendencia de Peso</strong>
                </div>
                <div class="card-body">
                    <canvas id="chartTendencia"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= PARTICIPACIÓN DE VOLUMEN ================= --}}
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header bg-white text-center">
                    <strong>% Participación de Volumen por Frente</strong>
                </div>
                <div class="card-body text-center">
                    <canvas id="chartParticipacion" style="max-height:220px;"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const frentesLabels = @json($dataPorFrente->pluck('frente'));
    const frentesData = @json($dataPorFrente->pluck('total_peso'));

    new Chart(document.getElementById('chartFrentes'), {
        type: 'bar',
        data: {
            labels: frentesLabels,
            datasets: [{
                label: 'Peso Neto (TN)',
                data: frentesData,
                borderRadius: 6
            }]
        }
    });

    const tendenciaLabels = @json($tendenciaCarga->pluck('fecha'));
    const tendenciaData = @json($tendenciaCarga->pluck('peso_total'));

    new Chart(document.getElementById('chartTendencia'), {
        type: 'line',
        data: {
            labels: tendenciaLabels,
            datasets: [{
                label: 'Peso Diario (TN)',
                data: tendenciaData,
                tension: 0.3,
                fill: false
            }]
        }
    });

    new Chart(document.getElementById('chartParticipacion'), {
        type: 'doughnut',
        data: {
            labels: frentesLabels,
            datasets: [{
                data: frentesData,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection