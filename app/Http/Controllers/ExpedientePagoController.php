<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expediente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Programacion;


class ExpedientePagoController extends Controller
{
    /**
     * Listado de expedientes para contabilidad
     */
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
     * Obtener datos del expediente para editar (modal / onclick)
     */
    public function edit($id)
    {
        $expediente = Expediente::with(['programacion', 'tisur'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $expediente
        ]);
    }

    /**
     * Actualizar datos de pago del expediente
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_pago'   => 'nullable|date',
            'comentarios'  => 'nullable|string|max:500',
            'archivo'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
        ]);

        DB::beginTransaction();

        try {
            $expediente = Expediente::findOrFail($id);

            // Fecha de pago
            $expediente->fecha_pago = $request->fecha_pago;

            // Comentarios
            $expediente->comentarios = $request->comentarios;

            // Archivo comprobante de pago
            if ($request->hasFile('archivo')) {

                // Eliminar archivo anterior si existe
                if ($expediente->archivo && Storage::disk('public')->exists($expediente->archivo)) {
                    Storage::disk('public')->delete($expediente->archivo);
                }

                $ruta = $request->file('archivo')
                    ->store('expedientes/pagos', 'public');

                $expediente->archivo = $ruta;
            }

            $expediente->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Información de pago actualizada correctamente'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el expediente',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
