<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $pageTitle = 'Dashboard Analítico de Operaciones';

        // ==========================
        // 📅 FILTRO POR FECHAS
        // ==========================
        $fechaInicio = $request->fecha_inicio 
            ? Carbon::parse($request->fecha_inicio)->startOfDay()
            : Carbon::now()->startOfMonth();

        $fechaFin = $request->fecha_fin
            ? Carbon::parse($request->fecha_fin)->endOfDay()
            : Carbon::now()->endOfMonth();

        // ==========================
        // 📊 KPIs PRINCIPALES
        // ==========================
        $kpis = DB::table('expedientes as e')
            ->leftJoin('tisurs as t', 'e.tisur_id', '=', 't.id')
            ->whereBetween('t.fecha_hora_ingreso', [$fechaInicio, $fechaFin])
            ->selectRaw("
                COALESCE(SUM(t.peso_neto),0) as total_peso_neto,
                COUNT(e.id) as total_viajes,
                COALESCE(SUM(e.deposito_a_proveer),0) as total_pago_proveedores,
                COALESCE(SUM(e.total_con_detraccion),0) as total_facturado
            ")
            ->first();

        $kpis->margen_bruto = 
            $kpis->total_facturado - $kpis->total_pago_proveedores;

        // ==========================
        // 📦 PESO POR FRENTE
        // ==========================
        $dataPorFrente = DB::table('expedientes as e')
            ->leftJoin('tisurs as t', 'e.tisur_id', '=', 't.id')
            ->leftJoin('programacions as p', 'e.programacion_id', '=', 'p.id')
            ->leftJoin('detalle_programacions as dp', 'p.detalle_programacion_id', '=', 'dp.id')
            ->whereBetween('t.fecha_hora_ingreso', [$fechaInicio, $fechaFin])
            ->whereNotNull('dp.frente')
            ->groupBy('dp.frente')
            ->selectRaw('dp.frente, SUM(t.peso_neto) as total_peso')
            ->get();

        // ==========================
        // 📈 TENDENCIA DE PESO
        // ==========================
        $tendenciaCarga = DB::table('tisurs as t')
            ->whereBetween('t.fecha_hora_ingreso', [$fechaInicio, $fechaFin])
            ->groupBy(DB::raw('DATE(t.fecha_hora_ingreso)'))
            ->orderBy(DB::raw('DATE(t.fecha_hora_ingreso)'), 'asc')
            ->selectRaw('
                DATE(t.fecha_hora_ingreso) as fecha,
                SUM(t.peso_neto) as peso_total
            ')
            ->get();

        return view('dashboard', compact(
            'user',
            'pageTitle',
            'kpis',
            'dataPorFrente',
            'tendenciaCarga',
            'fechaInicio',
            'fechaFin'
        ));
    }
}