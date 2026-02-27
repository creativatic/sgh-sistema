<?php

namespace App\Exports;

use App\Models\Expediente;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpedienteExport implements FromCollection, WithHeadings
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
        return DB::table('expedientes as e')
            ->leftJoin('tisurs as t', 'e.tisur_id', '=', 't.id')
            ->leftJoin('programacions as p', 'e.programacion_id', '=', 'p.id')
            ->leftJoin('unidades as u', 'p.unidad_id', '=', 'u.id')
            ->leftJoin('proveedores as prov', 'p.proveedor_id', '=', 'prov.id')
            ->leftJoin('conductores as c', 'p.conductor_id', '=', 'c.id')
            ->leftJoin('detalle_programacions as dp', 'p.detalle_programacion_id', '=', 'dp.id')
            ->whereBetween('p.fecha_programacion', [
                $this->fechaInicio . ' 00:00:00',
                $this->fechaFin . ' 23:59:59'
            ])
            ->orderBy('e.id')
            ->select(
                'p.fecha_programacion',
                'p.guia_remision',
                'u.placa_tracto',
                'u.placa_carreta',
                'prov.razon_social',
                'prov.ruc_transporte',
                'c.nombres',
                'c.apellidos',
                'c.licencia',
                'c.telefono',
                'prov.cuenta_banco',
                'prov.cci_banco',
                'prov.banco',
                'p.guia_transportista',
                'dp.frente',
                't.numero_ticket',
                'p.guia_remision as guia_remision_repetida',
                'e.numero_factura_exped',
                't.fecha_hora_ingreso',
                't.primer_peso',
                't.segundo_peso',
                't.peso_neto',
                'dp.precio_tn',
                't.total_tisur',
                'e.detraccion',
                'e.estado_pago_detraccion',
                'e.total_con_detraccion',
                'e.deposito_a_proveer',
                'e.fecha_pago',
                'e.conformidad_exped',
                'p.grupo_cargio',
                'e.archivo',
                'dp.frente as frente_repetido',
                'p.glosa_banco',
                'e.fecha_pago as fecha_pago_repetida',
                'e.comentarios'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Fecha Programación',
            'Guía Remisión',
            'Placa Tracto',
            'Placa Carreta',
            'Razón Social',
            'RUC',
            'Nombres',
            'Apellidos',
            'Licencia',
            'Teléfono',
            'Cuenta Banco',
            'CCI Banco',
            'Banco',
            'Guía Transportista',
            'Frente',
            'Número Ticket',
            'Guía Remisión (Rep)',
            'Factura',
            'Fecha Ingreso',
            'Primer Peso',
            'Segundo Peso',
            'Peso Neto',
            'Precio TN',
            'Total Tisur',
            'Detracción',
            'Estado Pago Detracción',
            'Total con Detracción',
            'Depósito a Proveer',
            'Fecha Pago',
            'Conformidad Expediente',
            'Grupo Cargio',
            'Archivo',
            'Frente (Rep)',
            'Glosa Banco',
            'Fecha Pago (Rep)',
            'Comentarios'
        ];
    }
}