<?php

namespace App\Exports;

use App\Models\Programacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class ProgramacionExport implements FromCollection, WithHeadings, WithMapping
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
        return Programacion::with([
            'unidad',
            'proveedor',
            'conductor',
            'detalleProgramacion'
        ])
        ->whereBetween('fecha_programacion', [
            Carbon::parse($this->fechaInicio)->startOfDay(),
            Carbon::parse($this->fechaFin)->endOfDay()
        ])
        ->orderBy('id','asc')
        ->get();
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Guía',
            'Placa Tracto',
            'Placa Carreta',
            'Marca',
            'Tipo Plataforma',
            'Constancia MTC Tracto',
            'Constancia MTC Carreta',
            'Razón Social',
            'RUC',
            'Nombre Conductor',
            'Apellidos Conductor',
            'Licencia',
            'Teléfono',
            'Cuenta Banco',
            'CCI',
            'Banco',
            'Frente',
            'Conformidad',
            'Guía Transportista',
            'Grupo Carguio',
            'Monto Adelanto',
            'Fecha Pago Adelanto',
            'Notas'
        ];
    }

    public function map($p): array
    {
        return [
            $p->fecha_programacion,
            $p->guia_remision,
            $p->unidad?->placa_tracto,
            $p->unidad?->placa_carreta,
            $p->unidad?->marca_vehiculo,
            $p->unidad?->tipo_plataforma,
            $p->unidad?->constancia_mtc_tracto,
            $p->unidad?->constancia_mtc_carreta,
            $p->proveedor?->razon_social,
            $p->proveedor?->ruc_transporte,
            $p->conductor?->nombres,
            $p->conductor?->apellidos,
            $p->conductor?->licencia,
            $p->conductor?->telefono,
            $p->proveedor?->cuenta_banco,
            $p->proveedor?->cci_banco,
            $p->proveedor?->banco,
            $p->detalleProgramacion?->frente,
            $p->conformidad_adelanto,
            $p->guia_transportista,
            $p->grupo_cargio,
            $p->monto_adelanto,
            $p->fecha_pago_adelantos,
            $p->notas
        ];
    }
}