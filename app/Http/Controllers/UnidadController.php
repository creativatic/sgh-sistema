<?php

namespace App\Http\Controllers;

use App\Models\Unidad;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $unidades = Unidad::with('proveedor')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {

                    // Placa Tracto
                    $q->where('placa_tracto', 'like', "%{$search}%")

                    // Placa Carreta
                    ->orWhere('placa_carreta', 'like', "%{$search}%")

                    // Tipo Plataforma
                    ->orWhere('tipo_plataforma', 'like', "%{$search}%")

                    // Proveedor
                    ->orWhereHas('proveedor', function ($p) use ($search) {
                        $p->where('razon_social', 'like', "%{$search}%");
                    });

                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $proveedores = Proveedor::orderBy('razon_social')->get();

        return view('unidades.index', compact('unidades', 'proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa_tracto' => 'required|string|max:20',
            'placa_carreta' => 'nullable|string|max:20',
            'marca_vehiculo' => 'required|string|max:50',
            'tipo_plataforma' => 'nullable|string|max:50',
            'constancia_mtc_tracto' => 'nullable|string|max:50',
            'constancia_mtc_carreta' => 'nullable|string|max:50',
            'proveedor_id' => 'required|exists:proveedores,id',
        ]);

        Unidad::create($request->all());
        return redirect()->route('unidades.index')->with('success', 'Unidad creada correctamente.');
    }

    // CAMBIA ESTOS MÉTODOS - usa $id en lugar de Route Model Binding
    public function update(Request $request, $id)
    {
        $request->validate([
            'placa_tracto' => 'required|string|max:20',
            'placa_carreta' => 'nullable|string|max:20',
            'marca_vehiculo' => 'required|string|max:50',
            'tipo_plataforma' => 'nullable|string|max:50',
            'constancia_mtc_tracto' => 'nullable|string|max:50',
            'constancia_mtc_carreta' => 'nullable|string|max:50',
            'proveedor_id' => 'required|exists:proveedores,id',
        ]);

        $unidad = Unidad::findOrFail($id);
        $unidad->update($request->all());
        
        return redirect()->route('unidades.index')->with('success', 'Unidad actualizada correctamente.');
    }

    public function destroy($id)
    {
        $unidad = Unidad::findOrFail($id);
        $unidad->delete();
        
        return redirect()->route('unidades.index')->with('success', 'Unidad eliminada correctamente.');
    }
}