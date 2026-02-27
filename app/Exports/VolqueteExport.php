<?php

namespace App\Exports;

use App\Models\Volquete;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VolqueteExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fechaInicio;
    protected $fechaFin;

    public function __construct($fechaInicio, $fechaFin)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    public function collection()
    {
        return Volquete::with(['proveedor', 'unidad', 'detalleProgramacion'])
            ->whereBetween('fecha', [
                $this->fechaInicio,
                $this->fechaFin
            ])
            ->orderBy('id', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Placa',
            'Razon Social',
            'Hora Vuelta descarga',
            'N° Lampadas vuelta N°1',
            'Peso vuelta N°1',
            'Hora Vuelta N° 2',
            'N° Lampadas vuelta N°2',
            'Peso vuelta N°2',
            'Conformidad',
            'Frente',
            'Total Lampadas por Día',
            'Total Peso por Día',
            'Precio por Frente',
            'Pasadas',
            'Total',
            'Detracción',
            'Retención',
            'Deposito a Proveer',
            'Fecha de Pago',
            'Factura',
        ];
    }

    public function map($v): array
    {
        return [
            $v->fecha,
            optional($v->unidad)->placa_tracto,
            optional($v->proveedor)->razon_social,
            $v->hora_vuelta_1,
            $v->lampadas_vuelta_1,
            $v->peso_vuelta_1,
            $v->hora_vuelta_2,
            $v->lampadas_vuelta_2,
            $v->peso_vuelta_2,
            $v->conformidad,
            optional($v->detalleProgramacion)->frente,
            $v->total_lampadas_dia,
            $v->total_peso_dia,
            optional($v->detalleProgramacion)->precio_frente,
            $v->pasadas,
            $v->total,
            $v->detraccion,
            $v->retencion,
            $v->deposito_a_proveer,
            $v->fecha_pago
                ? Carbon::parse($v->fecha_pago)->format('Y-m-d')
                : null,
            $v->factura,
        ];
    }
}