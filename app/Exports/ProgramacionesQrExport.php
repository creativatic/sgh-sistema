<?php

namespace App\Exports;

use App\Models\Programacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class ProgramacionesQrExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fechaInicio;
    protected $fechaFin;

    public function __construct($fechaInicio = null, $fechaFin = null)
    {
        $this->fechaInicio = $fechaInicio ? Carbon::parse($fechaInicio)->startOfDay() : null;
        $this->fechaFin    = $fechaFin ? Carbon::parse($fechaFin)->endOfDay() : null;
    }

    /**
     * Colección EXACTAMENTE igual al reporte
     */
    public function collection()
    {
        return Programacion::with([
                'unidad',
                'conductor',
                'proveedor'
            ])
            ->where('conformidad_adelanto', 'Ok')
            ->when($this->fechaInicio, fn ($q) =>
                $q->whereDate('fecha_programacion', '>=', $this->fechaInicio)
            )
            ->when($this->fechaFin, fn ($q) =>
                $q->whereDate('fecha_programacion', '<=', $this->fechaFin)
            )
            ->orderBy('fecha_programacion', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Placa Tracto',
            'Licencia',
            'DNI',
            'Nombres',
            'Apellidos',
            'RUC',
            'Razón Social',
            'Tipo Operación',
            'Placa Carreta',
            'Guía Remisión',
            'Grupo Carguío',
        ];
    }

    public function map($p): array
    {
        return [
            $p->unidad?->placa_tracto ?? '',
            $p->conductor?->licencia ?? '',
            $p->conductor?->dni ?? '',
            $p->conductor?->nombres ?? '',
            $p->conductor?->apellidos ?? '',
            $p->proveedor?->ruc_transporte ?? '',
            $p->proveedor?->razon_social ?? '',
            ucfirst($p->tipo_operacion ?? ''),
            $p->unidad?->placa_carreta ?? '',
            $p->guia_remision ?? '',
            $p->grupo_cargio ?? '',
        ];
    }
}
