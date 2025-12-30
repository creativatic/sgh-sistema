<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expediente;
use App\Models\Programacion;
use Illuminate\Support\Facades\DB;

class ExpedientePagoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $programaciones = Programacion::query()
            ->leftJoin('expedientes', 'expedientes.programacion_id', '=', 'programacions.id')
            ->leftJoin('tisurs', 'tisurs.id', '=', 'expedientes.tisur_id')
            ->leftJoin('proveedores', 'proveedores.id', '=', 'programacions.proveedor_id')

            ->with([
                'seguimiento',
                'detalleProgramacion',
                'expedientes.tisur',
                'proveedor.unidades.conductores'
            ])

            ->where('programacions.conformidad_adelanto', 'Ok')

            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {

                    // Guía de Remisión
                    $q->where('programacions.guia_remision', 'like', "%{$search}%")

                    // N° Ticket TISUR
                    ->orWhere('tisurs.numero_ticket', 'like', "%{$search}%")

                    // RUC
                    ->orWhere('proveedores.ruc_transporte', 'like', "%{$search}%")

                    // Razón Social
                    ->orWhere('proveedores.razon_social', 'like', "%{$search}%")

                    // Banco
                    ->orWhere('proveedores.banco', 'like', "%{$search}%")

                    // Placa Tracto (relación unidades)
                    ->orWhereHas('proveedor.unidades', function ($u) use ($search) {
                        $u->where('placa_tracto', 'like', "%{$search}%");
                    });

                });
            })

            ->orderByRaw('expedientes.id IS NULL ASC') // prioridad sin expediente
            ->orderBy('programacions.created_at', 'DESC')
            ->select('programacions.*') // ⚠️ CLAVE para evitar conflictos
            ->paginate(10)
            ->withQueryString(); // mantiene el search al paginar

        return view('expediente_pagos.index', compact('programaciones'));
    }
    /**
     * Se unificaron las cargas para que SHOW y EDIT tengan la misma data
     */
    public function show($id)
    {
        $expediente = Expediente::with([
            'programacion.detalleProgramacion',
            'programacion.proveedor.unidades',
            'tisur'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $expediente
        ]);
    }

    public function edit($id)
    {
        // CAMBIO CLAVE: Agregamos las relaciones profundas para el proveedor y sus unidades
        $expediente = Expediente::with([
            'programacion.proveedor.unidades', // Para Razón Social, RUC y Placa
            'programacion.detalleProgramacion', // Para el Frente
            'tisur' // Para el N° de Ticket
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $expediente
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_pago'   => 'nullable|date',
            'comentarios'  => 'nullable|string|max:500',
            'archivo'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:20480',
        ]);

        try {
            $expediente = Expediente::with('tisur')->findOrFail($id);

            $expediente->fecha_pago  = $request->fecha_pago;
            $expediente->comentarios = $request->comentarios;

            // 📄 Comprobante de pago
            if ($request->hasFile('archivo')) {
                $folder = 'uploads/expedientes/comprobante';
                $rutaDestino = public_path($folder);

                if (!file_exists($rutaDestino)) {
                    mkdir($rutaDestino, 0755, true);
                }

                if ($expediente->archivo_comprobante_pago && file_exists(public_path($expediente->archivo_comprobante_pago))) {
                    @unlink(public_path($expediente->archivo_comprobante_pago));
                }

                $nombreArchivo = time() . '_' . $request->file('archivo')->getClientOriginalName();
                $request->file('archivo')->move($rutaDestino, $nombreArchivo);

                $expediente->archivo_comprobante_pago = $folder . '/' . $nombreArchivo;
            }

            /* =====================================================
            🔥 SINCRONIZAR TISUR
            ===================================================== */
            if ($expediente->tisur) {
                if ($request->fecha_pago) {
                    $expediente->tisur->update([
                        'fecha_pago' => $request->fecha_pago,
                        'estado'     => 'PAGADO',
                    ]);
                } else {
                    $expediente->tisur->update([
                        'fecha_pago' => null,
                        'estado'     => 'Pendiente',
                    ]);
                }
            }

            $expediente->save();

            return response()->json([
                'success' => true,
                'message' => 'Información de pago actualizada correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

}