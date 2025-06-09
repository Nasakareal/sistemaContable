<?php

namespace App\Http\Controllers;

use App\Models\Proyeccion;
use App\Models\CuentaBancaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProyeccionController extends Controller
{
    public function index()
    {
        $proyecciones = Proyeccion::with('cuentaBancaria')->orderBy('year')->orderBy('month')->get();
        return view('admin.settings.proyecciones.index', compact('proyecciones'));
    }

    public function create()
    {
        $cuentas = CuentaBancaria::all();
        return view('admin.settings.proyecciones.create', compact('cuentas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cuenta_bancaria_id' => 'required|exists:cuenta_bancarias,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2100',
            'monto' => 'required|numeric|min:0',
        ]);

        try {
            Proyeccion::create($request->all());
            return redirect()->route('proyecciones.index')->with('success', 'Proyección registrada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al registrar proyección: " . $e->getMessage());
            return redirect()->back()->withErrors('Error al guardar la proyección.');
        }
    }

    public function edit(Proyeccion $proyeccion)
    {
        $cuentas = CuentaBancaria::all();
        return view('admin.settings.proyecciones.edit', compact('proyeccion', 'cuentas'));
    }

    public function update(Request $request, Proyeccion $proyeccion)
    {
        $request->validate([
            'cuenta_bancaria_id' => 'required|exists:cuenta_bancarias,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2100',
            'monto' => 'required|numeric|min:0',
        ]);

        try {
            $proyeccion->update($request->all());
            return redirect()->route('proyecciones.index')->with('success', 'Proyección actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al actualizar proyección: " . $e->getMessage());
            return redirect()->back()->withErrors('Error al actualizar la proyección.');
        }
    }

    public function destroy(Proyeccion $proyeccion)
    {
        try {
            $proyeccion->delete();
            return redirect()->route('proyecciones.index')->with('success', 'Proyección eliminada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al eliminar proyección: " . $e->getMessage());
            return redirect()->back()->withErrors('Error al eliminar la proyección.');
        }
    }
}
