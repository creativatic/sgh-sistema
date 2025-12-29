@extends('layouts.plantilla')

@section('title','Dashboard Analítico')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="h4 font-weight-bold text-dark">Resumen Ejecutivo de Operaciones</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-4 shadow border-0">
                <div class="card-body text-center">
                    <h6 class="text-uppercase small">Volumen Total (Peso Neto)</h6>
                    <h2 class="display-5 font-weight-bold">{{ number_format($kpis->total_peso_neto, 2) }}</h2>
                    <i class="fas fa-truck-moving fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-4 shadow border-0">
                <div class="card-body text-center">
                    <h6 class="text-uppercase small">Total de Expedientes</h6>
                    <h2 class="display-5 font-weight-bold">{{ $kpis->total_viajes }}</h2>
                    <i class="fas fa-file-invoice fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white mb-4 shadow border-0">
                <div class="card-body text-center">
                    <h6 class="text-uppercase small">Dispersión a Proveedores</h6>
                    <h2 class="display-5 font-weight-bold">S/ {{ number_format($kpis->total_pago_proveedores, 2) }}</h2>
                    <i class="fas fa-coins fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header bg-white border-0">
                    <h6 class="font-weight-bold text-primary m-0">Análisis de Carga por Frente de Trabajo</h6>
                </div>
                <div class="card-body">
                    <canvas id="chartFrentes" height="150"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card-header bg-white border-0">
                    <h6 class="font-weight-bold text-primary m-0">% Participación de Volumen</h6>
                </div>
                <div class="card-body">
                    <canvas id="chartParticipacion" height="215"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labelsFrentes = @json($dataPorFrente->pluck('frente'));
    const dataFrentes = @json($dataPorFrente->pluck('total_peso'));

    // Gráfico de Barras
    new Chart(document.getElementById('chartFrentes'), {
        type: 'bar',
        data: {
            labels: labelsFrentes,
            datasets: [{
                label: 'Peso Neto (TN)',
                data: dataFrentes,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // Gráfico Circular
    new Chart(document.getElementById('chartParticipacion'), {
        type: 'doughnut',
        data: {
            labels: labelsFrentes,
            datasets: [{
                data: dataFrentes,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                hoverOffset: 4
            }]
        }
    });
</script>
@endsection