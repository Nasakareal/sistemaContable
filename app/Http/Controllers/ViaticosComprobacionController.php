<?php

namespace App\Http\Controllers;

use App\Models\ViaticosComprobacion;
use App\Models\ViaticoReal as Viatico;
use Illuminate\Http\Request;
use App\Models\Capitulo;
use App\Models\Partida;

class ViaticosComprobacionController extends Controller
{

    public function index(Viatico $viatico)
    {
        // Eager-load de comprobaciones con sus partidas
        $comprobaciones = $viatico
            ->comprobaciones()
            ->with('partidas') 
            ->get();

        return view('viaticos.comprobaciones.index', compact('viatico', 'comprobaciones'));
    }


    public function create(Viatico $viatico)
    {
        $cuentaContable = $viatico->cuentaBancaria->numero ?? null;
        $capitulos  = Capitulo::with('partidas')->get();

        return view('viaticos.comprobaciones.create', compact('viatico', 'cuentaContable', 'capitulos'));
    }

    public function store(Request $request, Viatico $viatico)
    {
        // 1) Validación: no hay comprobaciones.*.monto, solo partidas
        $request->validate([
            'comprobaciones.*.cuenta_contable'   => 'required|string',
            'comprobaciones.*.tipo'              => 'required|in:GASTO,REINTEGRO,ADICIONAL',
            'comprobaciones.*.partidas'          => 'required|array|min:1',
            'comprobaciones.*.partidas.*.id'     => 'required|exists:partidas,id',
            'comprobaciones.*.partidas.*.monto'  => 'required|numeric|min:0',
        ]);

        // 2) Acumula gastos actuales para tipo GASTO
        $gastosActuales = $viatico->comprobaciones()
                                  ->where('tipo', 'GASTO')
                                  ->sum('monto');

        // 3) Recorre y guarda
        foreach ($request->comprobaciones as $comp) {
            // Suma automática de montos de partidas
            $totalPartidas = collect($comp['partidas'])->sum('monto');

            // Valida no exceder el importe total solo si es GASTO
            if ($comp['tipo'] === 'GASTO' && $gastosActuales + $totalPartidas > $viatico->importe_total) {
                return back()
                      ->withErrors(['comprobaciones' => 'Este gasto excede el importe disponible.'])
                      ->withInput();
            }

            // 4) Crea la comprobación usando el total de partidas
            $comprobacion = ViaticosComprobacion::create([
                'viatico_id'      => $viatico->id,
                'cuenta_contable' => $comp['cuenta_contable'],
                'monto'           => $totalPartidas,
                'tipo'            => $comp['tipo'],
            ]);

            // 5) Sincroniza las partidas
            $syncData = collect($comp['partidas'])
                ->mapWithKeys(fn($p) => [$p['id'] => ['monto' => $p['monto']]])
                ->all();
            $comprobacion->partidas()->sync($syncData);

            // 6) Si fue GASTO, actualiza el acumulado para la siguiente iteración
            if ($comp['tipo'] === 'GASTO') {
                $gastosActuales += $totalPartidas;
            }
        }

        // 7) Recalcula estatus final del viático
        $totalGasto = $viatico->comprobaciones()->where('tipo', 'GASTO')->sum('monto');
        if ($totalGasto == $viatico->importe_total) {
            $viatico->estatus = 'COMPROBADO';
        } elseif ($totalGasto < $viatico->importe_total) {
            $viatico->estatus = 'PARCIAL';
        }
        $viatico->save();

        return redirect()
               ->route('comprobaciones.index', $viatico)
               ->with('success', 'Comprobaciones registradas correctamente.');
    }

    public function edit(Viatico $viatico, ViaticosComprobacion $comprobacion)
    {
        $capitulos = Capitulo::with('partidas')->get();

        return view('viaticos.comprobaciones.edit', compact('viatico', 'comprobacion', 'capitulos'));
    }

    public function update(Request $request, Viatico $viatico, ViaticosComprobacion $comprobacion)
    {
        // 1) Validación: ya no pedimos 'monto' directo
        $request->validate([
            'cuenta_contable'   => 'required|string',
            'tipo'              => 'required|in:GASTO,REINTEGRO,ADICIONAL',
            'partidas'          => 'required|array|min:1',
            'partidas.*.id'     => 'required|exists:partidas,id',
            'partidas.*.monto'  => 'required|numeric|min:0',
        ]);

        // 2) Suma automática de partidas
        $totalPartidas = collect($request->partidas)->sum('monto');

        // 3) Validar tope de GASTO
        if ($request->tipo === 'GASTO') {
            $gastosPrevios = $viatico->comprobaciones()
                ->where('tipo', 'GASTO')
                ->where('id', '!=', $comprobacion->id)
                ->sum('monto');

            if ($gastosPrevios + $totalPartidas > $viatico->importe_total) {
                return back()
                    ->withErrors(['partidas' => 'El monto total de partidas excede el importe disponible.'])
                    ->withInput();
            }
        }

        // 4) Actualizar comprobación con el monto calculado
        $comprobacion->update([
            'cuenta_contable' => $request->cuenta_contable,
            'tipo'            => $request->tipo,
            'monto'           => $totalPartidas,
        ]);

        // 5) Sincronizar partidas
        $sync = collect($request->partidas)
            ->mapWithKeys(fn($p) => [$p['id'] => ['monto' => $p['monto']]])
            ->all();
        $comprobacion->partidas()->sync($sync);

        // 6) Recalcular estatus del viático
        $sumGastos = $viatico->comprobaciones()->where('tipo', 'GASTO')->sum('monto');
        if ($sumGastos == $viatico->importe_total) {
            $viatico->estatus = 'COMPROBADO';
        } elseif ($sumGastos < $viatico->importe_total) {
            $viatico->estatus = 'PARCIAL';
        } else {
            $viatico->estatus = 'COMPROBADO';
        }
        $viatico->save();

        return redirect()
            ->route('comprobaciones.index', $viatico)
            ->with('success', 'Comprobación actualizada correctamente.');
    }

    public function show(Viatico $viatico, ViaticosComprobacion $comprobacion)
    {
        return view('viaticos.comprobaciones.show', compact('viatico', 'comprobacion'));
    }

    public function destroy(Viatico $viatico, ViaticosComprobacion $comprobacion)
    {
        $comprobacion->partidas()->detach();
        $comprobacion->delete();

        // Recalcular estatus del viático
        $totalGasto = $viatico->comprobaciones()->where('tipo', 'GASTO')->sum('monto');

        if ($totalGasto == $viatico->importe_total) {
            $viatico->estatus = 'COMPROBADO';
        } elseif ($totalGasto < $viatico->importe_total) {
            $viatico->estatus = 'PARCIAL';
        } else {
            $viatico->estatus = 'COMPROBADO';
        }

        $viatico->save();

        return redirect()->route('comprobaciones.index', $viatico)->with('success', 'Comprobación eliminada correctamente.');
    }
}
