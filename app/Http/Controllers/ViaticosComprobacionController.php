<?php

namespace App\Http\Controllers;

use App\Models\ViaticosComprobacion;
use App\Models\ViaticoReal as Viatico;
use Illuminate\Http\Request;

class ViaticosComprobacionController extends Controller
{

    public function index(Viatico $viatico)
    {
        $comprobaciones = $viatico->comprobaciones()->get();
        return view('viaticos.comprobaciones.index', compact('viatico', 'comprobaciones'));
    }

    public function create(Viatico $viatico)
    {
        $cuentaContable = $viatico->cuentaBancaria->numero ?? null;

        return view('viaticos.comprobaciones.create', compact('viatico', 'cuentaContable'));
    }

    public function store(Request $request, Viatico $viatico)
    {
        $request->validate([
            'comprobaciones.*.cuenta_contable' => 'required|string',
            'comprobaciones.*.descripcion'     => 'nullable|string',
            'comprobaciones.*.monto'           => 'required|numeric|min:0',
            'comprobaciones.*.tipo'            => 'required|in:GASTO,REINTEGRO,ADICIONAL',
        ]);

        // Total de gastos ya registrados
        $gastosActuales = $viatico->comprobaciones()->where('tipo', 'GASTO')->sum('monto');

        // Total de nuevos gastos (solo tipo GASTO)
        $gastosNuevos = collect($request->comprobaciones)
            ->where('tipo', 'GASTO')
            ->sum('monto');

        $totalComprobado = $gastosActuales + $gastosNuevos;

        if ($totalComprobado > $viatico->importe_total) {
            return back()->withErrors(['comprobaciones' => 'La suma de los gastos supera el importe total del viático.'])->withInput();
        }

        // Guardar comprobaciones
        foreach ($request->comprobaciones as $comp) {
            ViaticosComprobacion::create([
                'viatico_id'      => $viatico->id,
                'cuenta_contable' => $comp['cuenta_contable'],
                'descripcion'     => $comp['descripcion'] ?? '',
                'monto'           => $comp['monto'],
                'tipo'            => $comp['tipo'],
            ]);
        }

        // Recalcular estatus del viático
        $totalGasto = $viatico->comprobaciones()->where('tipo', 'GASTO')->sum('monto');
        $importeTotal = $viatico->importe_total;

        if ($totalGasto == $importeTotal) {
            $viatico->estatus = 'COMPROBADO';
        } elseif ($totalGasto < $importeTotal) {
            $viatico->estatus = 'PARCIAL';
        }

        $viatico->save();

        return redirect()->route('comprobaciones.index', $viatico)->with('success', 'Comprobaciones registradas correctamente.');
    }

    public function edit(Viatico $viatico, ViaticosComprobacion $comprobacion)
    {
        return view('viaticos.comprobaciones.edit', compact('viatico', 'comprobacion'));
    }

    public function update(Request $request, Viatico $viatico, ViaticosComprobacion $comprobacion)
    {
        $request->validate([
            'cuenta_contable' => 'required|string',
            'descripcion'     => 'nullable|string',
            'monto'           => 'required|numeric|min:0',
            'tipo'            => 'required|in:GASTO,REINTEGRO,ADICIONAL',
        ]);

        // Solo hacer validación si el tipo es GASTO
        if ($request->tipo === 'GASTO') {
            $gastosActuales = $viatico->comprobaciones()
                ->where('tipo', 'GASTO')
                ->where('id', '!=', $comprobacion->id)
                ->sum('monto');

            $nuevoTotal = $gastosActuales + $request->monto;

            if ($nuevoTotal > $viatico->importe_total) {
                return back()->withErrors(['monto' => 'El monto actualizado excede el total del viático.'])->withInput();
            }
        }

        $comprobacion->update($request->only('cuenta_contable', 'descripcion', 'monto', 'tipo'));

        // Recalcular estatus
        $totalGasto = $viatico->comprobaciones()->where('tipo', 'GASTO')->sum('monto');
        $importeTotal = $viatico->importe_total;

        if ($totalGasto == $importeTotal) {
            $viatico->estatus = 'COMPROBADO';
        } elseif ($totalGasto < $importeTotal) {
            $viatico->estatus = 'PARCIAL';
        }

        $viatico->save();

        return redirect()->route('comprobaciones.index', $viatico)->with('success', 'Comprobación actualizada correctamente.');
    }

    public function show(Viatico $viatico, ViaticosComprobacion $comprobacion)
    {
        return view('viaticos.comprobaciones.show', compact('viatico', 'comprobacion'));
    }

    public function destroy(Viatico $viatico, ViaticosComprobacion $comprobacion)
    {
        $comprobacion->delete();

        // Recalcular estatus del viático
        $totalGasto = $viatico->comprobaciones()->where('tipo', 'GASTO')->sum('monto');
        $importeTotal = $viatico->importe_total;

        if ($totalGasto == $importeTotal) {
            $viatico->estatus = 'COMPROBADO';
        } elseif ($totalGasto < $importeTotal) {
            $viatico->estatus = 'PARCIAL';
        } else {
            $viatico->estatus = 'COMPROBADO';
        }

        $viatico->save();

        return redirect()->route('comprobaciones.index', $viatico)->with('success', 'Comprobación eliminada correctamente.');
    }
}
