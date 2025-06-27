<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use App\Models\CuentaBancaria;
use App\Models\Capitulo;
use App\Models\Partida;
use App\Models\UnidadResponsable;
use App\Models\Area;
use App\Models\SolicitudDev;
use Illuminate\Http\Request;

class TransaccionController extends Controller
{
    public function index()
    {
        $transacciones = Transaccion::with([
            'cuentaBancaria',
            'capitulo',
            'partidas',
            'unidadResponsable',
            'area',
            'solicitudDev'
        ])->get();

        return view('transacciones.index', compact('transacciones'));
    }

    public function create()
    {
        $cuentas = CuentaBancaria::all();
        $capitulos = Capitulo::all();
        $partidas = Partida::all();
        $unidades = UnidadResponsable::all();
        $areas = Area::all();
        $solicitudes = SolicitudDev::all();

        return view('transacciones.create', compact('cuentas', 'capitulos', 'partidas', 'unidades', 'areas', 'solicitudes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:ingreso,egreso',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string',
            'cuenta_bancaria_id' => 'required|exists:cuenta_bancarias,id',
            'capitulo_id' => 'nullable|exists:capitulos,id',
            'partidas' => 'required|array|min:1',
            'partidas.*.id' => 'required|exists:partidas,id',
            'partidas.*.monto' => 'required|numeric|min:0',
            'unidad_responsable_id' => 'nullable|exists:unidad_responsables,id',
            'area_id' => 'nullable|exists:areas,id',
            'solicitud_dev_id' => 'nullable|exists:solicitud_devs,id',
        ]);

        // ✅ Validar que la suma de las partidas coincida con el monto total
        $totalPartidas = collect($request->partidas)->sum('monto');
        if ($totalPartidas != $request->monto) {
            return redirect()->back()->withInput()->with('error', 'La suma de los montos de las partidas (' . number_format($totalPartidas, 2) . ') no coincide con el monto total (' . number_format($request->monto, 2) . ').');
        }

        try {
            \DB::transaction(function () use ($request) {
                if ($request->tipo === 'egreso') {
                    $cuenta = CuentaBancaria::find($request->cuenta_bancaria_id);
                    if (!$cuenta || $cuenta->saldo < $request->monto) {
                        throw new \Exception('Saldo insuficiente para realizar la transacción de egreso.');
                    }
                }

                // Crear la transacción SIN partida_id
                $transaccion = Transaccion::create($request->only([
                    'tipo',
                    'monto',
                    'fecha',
                    'descripcion',
                    'cuenta_bancaria_id',
                    'capitulo_id',
                    'unidad_responsable_id',
                    'area_id',
                    'solicitud_dev_id',
                ]));

                // Asociar las partidas con sus montos
                $partidasData = [];
                foreach ($request->partidas as $p) {
                    $partidasData[$p['id']] = ['monto' => $p['monto']];
                }

                $transaccion->partidas()->attach($partidasData);

                // Actualizar saldo de cuenta
                $cuenta = CuentaBancaria::find($request->cuenta_bancaria_id);
                if ($cuenta) {
                    if ($request->tipo === 'ingreso') {
                        $cuenta->saldo += $request->monto;
                    } else {
                        $cuenta->saldo -= $request->monto;
                    }
                    $cuenta->save();
                }
            });
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('transacciones.index')
                         ->with('success', 'Transacción registrada correctamente.');
    }


    public function show(Transaccion $transaccion)
    {
        return view('transacciones.show', compact('transaccion'));
    }

    public function edit(Transaccion $transaccion)
    {
        $transaccion->load('partidas');

        $cuentas     = CuentaBancaria::all();
        $capitulos   = Capitulo::all();
        $partidas    = Partida::all();
        $unidades    = UnidadResponsable::all();
        $areas       = Area::all();
        $solicitudes = SolicitudDev::all();

        return view('transacciones.edit', compact(
            'transaccion',
            'cuentas',
            'capitulos',
            'partidas',
            'unidades',
            'areas',
            'solicitudes'
        ));
    }

    public function update(Request $request, Transaccion $transaccion)
    {
        $request->validate([
            'tipo' => 'required|in:ingreso,egreso',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string',
            'cuenta_bancaria_id' => 'required|exists:cuenta_bancarias,id',
            'capitulo_id' => 'nullable|exists:capitulos,id',
            'unidad_responsable_id' => 'nullable|exists:unidad_responsables,id',
            'area_id' => 'nullable|exists:areas,id',
            'solicitud_dev_id' => 'nullable|exists:solicitud_devs,id',

            'partidas' => 'required|array|min:1',
            'partidas.*.id' => 'required|exists:partidas,id',
            'partidas.*.monto' => 'required|numeric|min:0',
        ]);

        // ✅ Validar que la suma de las partidas coincida con el nuevo monto total
        $totalPartidas = collect($request->partidas)->sum('monto');
        if ($totalPartidas != $request->monto) {
            return redirect()->back()->withInput()->with('error', 'La suma de los montos de las partidas (' . number_format($totalPartidas, 2) . ') no coincide con el monto total (' . number_format($request->monto, 2) . ').');
        }

        try {
            \DB::transaction(function () use ($request, $transaccion) {
                // Revertir saldo anterior
                $oldTipo     = $transaccion->tipo;
                $oldMonto    = $transaccion->monto;
                $oldCuentaId = $transaccion->cuenta_bancaria_id;

                $oldCuenta = CuentaBancaria::find($oldCuentaId);
                if ($oldCuenta) {
                    if ($oldTipo === 'ingreso') {
                        $oldCuenta->saldo -= $oldMonto;
                    } else {
                        $oldCuenta->saldo += $oldMonto;
                    }
                    $oldCuenta->save();
                }

                // Actualizar transacción (sin partida_id)
                $transaccion->update($request->only([
                    'tipo',
                    'monto',
                    'fecha',
                    'descripcion',
                    'cuenta_bancaria_id',
                    'capitulo_id',
                    'unidad_responsable_id',
                    'area_id',
                    'solicitud_dev_id',
                ]));

                // Actualizar partidas asociadas (pivot)
                $partidasData = [];
                foreach ($request->partidas as $p) {
                    $partidasData[$p['id']] = ['monto' => $p['monto']];
                }

                $transaccion->partidas()->sync($partidasData);

                // Aplicar nuevo saldo
                $newCuenta = CuentaBancaria::find($transaccion->cuenta_bancaria_id);
                if ($newCuenta) {
                    if ($transaccion->tipo === 'egreso') {
                        if ($newCuenta->saldo < $transaccion->monto) {
                            throw new \Exception('Saldo insuficiente en la cuenta para actualizar la transacción de egreso.');
                        }
                        $newCuenta->saldo -= $transaccion->monto;
                    } else {
                        $newCuenta->saldo += $transaccion->monto;
                    }
                    $newCuenta->save();
                }
            });
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('transacciones.index')->with('success', 'Transacción actualizada correctamente.');
    }


    public function destroy(Transaccion $transaccion)
    {
        \DB::transaction(function () use ($transaccion) {
            $cuenta = CuentaBancaria::find($transaccion->cuenta_bancaria_id);
            if ($cuenta) {
                if ($transaccion->tipo === 'ingreso') {
                    $cuenta->saldo -= $transaccion->monto;
                } else {
                    $cuenta->saldo += $transaccion->monto;
                }
                $cuenta->save();
            }

            $transaccion->delete();
        });

        return redirect()->route('transacciones.index')->with('success', 'Transacción eliminada correctamente.');
    }
}
