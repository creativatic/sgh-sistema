<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expediente;
use App\Models\Programacion;
use Illuminate\Support\Facades\DB;

class ExpedientePagoController extends Controller
{
    public function index()
    {
        $programaciones = Programacion::with([
            'seguimiento',
            'detalleProgramacion',
            'expedientes.tisur',
            'proveedor.unidades.conductores'
        ])
        ->where('conformidad_adelanto', 'Ok')
        ->latest()
        ->paginate(10);

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
            $expediente = Expediente::findOrFail($id);
            $expediente->fecha_pago = $request->fecha_pago;
            $expediente->comentarios = $request->comentarios;

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