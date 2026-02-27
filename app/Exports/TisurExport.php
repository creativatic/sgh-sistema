<?php

namespace App\Exports;

use App\Models\Tisur;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TisurExport implements FromCollection, WithHeadings, WithMapping
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
        return Tisur::whereBetween('fecha_hora_ingreso', [
                $this->fechaInicio . ' 00:00:00',
                $this->fechaFin . ' 23:59:59'
            ])
            ->orderBy('id', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'N° Ticket',
            'Fecha - Hora de Ingreso',
            'Placa Tracto',
            'Fecha - Hora de Salida',
            '1° Peso',
            '2° Peso',
            'Razon Social',
            'Transportista',
            'Carga',
            'N° Bultos',
            'Peso Neto',
            'Tipo',
            'Documento de Origen',
            'Precio',
            'Total',
            'Retención',
            'Pago',
            'Factura',
            'Estado',
            'Guia de Remision',
            'Fecha de Pago',
            'Orden',
        ];
    }

    public function map($t): array
    {
        return [
            $t->numero_ticket,
            $t->fecha_hora_ingreso 
                ? Carbon::parse($t->fecha_hora_ingreso)->format('Y-m-d H:i:s') 
                : null,
            $t->placa_tracto,
            $t->fecha_hora_salida 
                ? Carbon::parse($t->fecha_hora_salida)->format('Y-m-d H:i:s') 
                : null,
            $t->primer_peso,
            $t->segundo_peso,
            $t->razon_social,
            $t->transportista,
            $t->tipo_carga_tisur,
            $t->numero_bultos,
            $t->peso_neto,
            $t->tipo_plataforma,
            $t->documento_origen,
            $t->precio_tisur,
            $t->total_tisur,
            $t->retencion_tisur,
            $t->pago_tisur,
            $t->factura_tisur,
            $t->estado,
            $t->guia_remision,
            $t->fecha_pago 
                ? Carbon::parse($t->fecha_pago)->format('Y-m-d') 
                : null,
            $t->orden_tisur,
        ];
    }
}