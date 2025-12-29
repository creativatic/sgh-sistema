<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Mostrar el panel principal (Dashboard)
     */
    public function index()
    {
        $user = Auth::user();
        $pageTitle = 'Dashboard Analítico de Operaciones';

        // 1. KPIs Principales (Cards)
        $kpis = DB::table('expedientes as e')
            ->leftJoin('tisurs as t', 'e.tisur_id', '=', 't.id')
            ->select([
                DB::raw('SUM(t.peso_neto) as total_peso_neto'),
                DB::raw('COUNT(e.id) as total_viajes'),
                DB::raw('SUM(e.deposito_a_proveer) as total_pago_proveedores')
            ])->first();

        // 2. Análisis por Frente (Para Gráfico de Barras y Pastel)
        $dataPorFrente = DB::table('expedientes as e')
            ->leftJoin('tisurs as t', 'e.tisur_id', '=', 't.id')
            ->leftJoin('programacions as p', 'e.programacion_id', '=', 'p.id')
            ->leftJoin('detalle_programacions as dp', 'p.detalle_programacion_id', '=', 'dp.id')
            ->select('dp.frente', DB::raw('SUM(t.peso_neto) as total_peso'))
            ->groupBy('dp.frente')
            ->whereNotNull('dp.frente')
            ->get();

        // 3. Tendencia de Carga (Últimos 7 días)
        $tendenciaCarga = DB::table('programacions')
            ->select(DB::raw('DATE(fecha_programacion) as fecha'), DB::raw('COUNT(*) as cantidad'))
            ->groupBy('fecha')
            ->orderBy('fecha', 'asc')
            ->limit(7)
            ->get();

        return view('dashboard', compact(
            'user', 
            'pageTitle', 
            'kpis', 
            'dataPorFrente', 
            'tendenciaCarga'
        ));
    }
    /**
     * Ejemplo de otra sección dentro del dashboard (opcional)
     */
    public function analytics()
    {
        $pageTitle = 'Reportes y Analíticas';
        return view('dashboard.analytics', compact('pageTitle'));
    }
}