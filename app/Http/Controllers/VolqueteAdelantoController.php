<?php

namespace App\Http\Controllers;

use App\Models\Volquete;
use Illuminate\Http\Request;

class VolqueteAdelantoController extends Controller
{
    public function index()
    {
        $volquetes = Volquete::with(['proveedor', 'detalleProgramacion'])
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('volquetes_adelantos.index', compact('volquetes'));
    }

    public function edit($id)
    {
        $volquete = Volquete::with(['proveedor', 'detalleProgramacion'])
            ->findOrFail($id);

        return view('volquetes_adelantos.edit', compact('volquete'));
    }

    public function update(Request $request, $id)
    {
        $volquete = Volquete::findOrFail($id);

        $request->validate([
            'fecha_pago' => 'nullable|date',
            'observaciones' => 'nullable|string',
            'comprobante_pago' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $data = $request->only([
            'fecha_pago',
            'observaciones',
        ]);

        /* ==========================
           COMPROBANTE DE PAGO
        ========================== */
        if ($request->hasFile('comprobante_pago')) {
            $file = $request->file('comprobante_pago');
            $name = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('uploads/volquetes/comprobantes'),
                $name
            );

            $data['comprobante_pago'] = 'uploads/volquetes/comprobantes/'.$name;
        }

        $volquete->update($data);

        return redirect()
            ->route('volquetes_adelantos.index')
            ->with('success', 'Adelanto actualizado correctamente');
    }
}
