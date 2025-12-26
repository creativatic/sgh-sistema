<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programacion;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProgramacionesQrExport;

class ReporteController extends Controller
{
    /**
     * Muestra el reporte QR con filtro por fechas
     */
    public function reporteQr(Request $request)
    {
        $fechaInicio = $request->fecha_inicio;
        $fechaFin    = $request->fecha_fin;

        $programaciones = Programacion::with([
                'proveedor',
                'conductor',
                'unidad'
            ])
            ->where('conformidad_adelanto', 'Ok')
            ->when($fechaInicio, fn ($q) =>
                $q->whereDate('fecha_programacion', '>=', $fechaInicio)
            )
            ->when($fechaFin, fn ($q) =>
                $q->whereDate('fecha_programacion', '<=', $fechaFin)
            )
            ->orderBy('fecha_programacion', 'desc')
            ->get();

        return view('reportes.reporte_qr', compact(
            'programaciones',
            'fechaInicio',
            'fechaFin'
        ));
    }

    /**
     * Exporta EXACTAMENTE lo filtrado a Excel
     */
    public function exportQr(Request $request)
    {
        $fechaInicio = $request->fecha_inicio;
        $fechaFin    = $request->fecha_fin;

        $nombreArchivo = 'reporte_programaciones_qr_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(
            new ProgramacionesQrExport($fechaInicio, $fechaFin),
            $nombreArchivo
        );
    }
}
