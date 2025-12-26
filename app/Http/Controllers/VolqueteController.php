<?php

namespace App\Http\Controllers;

use App\Models\Volquete;
use App\Models\Proveedor;
use App\Models\DetalleProgramacion;
use App\Models\Unidad;
use Illuminate\Http\Request;

class VolqueteController extends Controller
{
    public function index()
    {
        $volquetes = Volquete::with(['proveedor'])->paginate(10);
        $proveedores = Proveedor::orderBy('razon_social')->get();
        $frentes = DetalleProgramacion::orderBy('descripcion')->get();
        $unidades = Unidad::orderBy('placa_tracto')->get(); // 🔥 Esto es necesario

        return view('volquetes.index', compact('volquetes', 'proveedores', 'frentes', 'unidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'factura' => 'nullable|file|mimes:pdf|max:2048',
            'comprobante_pago' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $data = $request->all();

        // ==========================
        // GUARDAR FACTURA
        // ==========================
        if ($request->hasFile('factura')) {

            $file = $request->file('factura');
            $name = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('uploads/volquetes/facturas'),
                $name
            );

            $data['factura'] = 'uploads/volquetes/facturas/'.$name;
        }


        // ==========================
        // GUARDAR COMPROBANTE
        // ==========================
        if ($request->hasFile('comprobante_pago')) {

            $file = $request->file('comprobante_pago');
            $name = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('uploads/volquetes/comprobantes'),
                $name
            );

            $data['comprobante_pago'] = 'uploads/volquetes/comprobantes/'.$name;
        }

        Volquete::create($data);

        return back()->with('success', 'Volquete registrado correctamente');
    }


    public function update(Request $request, $id)
    {
        $volquete = Volquete::findOrFail($id);

        $request->validate([
            'fecha' => 'required|date',
            'proveedor_id' => 'required|exists:proveedores,id',
            'detalle_programacion_id' => 'nullable|exists:detalle_programacions,id',

            'factura' => 'nullable|file|mimes:pdf|max:2048',
            'comprobante_pago' => 'nullable|file|mimes:pdf|max:2048',

            'conformidad' => 'nullable|string',
            'observaciones' => 'nullable|string',

            'hora_vuelta_1' => 'nullable',
            'hora_vuelta_2' => 'nullable',
            'lampadas_vuelta_1' => 'nullable|numeric',
            'lampadas_vuelta_2' => 'nullable|numeric',
            'peso_vuelta_1' => 'nullable|numeric',
            'peso_vuelta_2' => 'nullable|numeric',

            'pasadas' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'detraccion' => 'nullable|numeric',
            'retencion' => 'nullable|numeric',
            'deposito_a_proveer' => 'nullable|numeric',
            'deposito_total' => 'nullable|numeric',
            'fecha_pago' => 'nullable|date',
        ]);

        $data = $request->all();

        /* ==========================
        ACTUALIZAR FACTURA
        ========================== */
        if ($request->hasFile('factura')) {

            $file = $request->file('factura');
            $name = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('uploads/volquetes/facturas'),
                $name
            );

            $data['factura'] = 'uploads/volquetes/facturas/'.$name;
        }


        /* ==========================
        ACTUALIZAR COMPROBANTE
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

        return back()->with('success', 'Volquete actualizado correctamente');
    }

    public function destroy($id)
    {
        Volquete::destroy($id);

        return back()->with('success', 'Volquete eliminado');
    }

  
    public function conformidad(Request $request, $id)
    {
        // Seguridad: solo Administrador
        if (!auth()->user()->hasRole('Administrador')) {
            abort(403, 'No autorizado');
        }

        $volquete = Volquete::findOrFail($id);

        $volquete->update([
            'conformidad' => $request->has('conformidad')
                ? 'Ok'
                : 'Pendiente'
        ]);

        return back()->with('success', 'Conformidad actualizada');
    }


}
