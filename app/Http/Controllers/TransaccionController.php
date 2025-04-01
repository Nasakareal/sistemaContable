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
            'partida',
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
            'partida_id' => 'nullable|exists:partidas,id',
            'unidad_responsable_id' => 'nullable|exists:unidad_responsables,id',
            'area_id' => 'nullable|exists:areas,id',
            'solicitud_dev_id' => 'nullable|exists:solicitud_devs,id',
        ]);

        \DB::transaction(function () use ($request) {
            $transaccion = Transaccion::create($request->all());

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

        return redirect()->route('transacciones.index')
                         ->with('success', 'Transacción registrada correctamente.');
    }

    public function show(Transaccion $transaccion)
    {
        return view('transacciones.show', compact('transaccion'));
    }

    public function edit(Transaccion $transaccion)
    {
        $cuentas = CuentaBancaria::all();
        $capitulos = Capitulo::all();
        $partidas = Partida::all();
        $unidades = UnidadResponsable::all();
        $areas = Area::all();
        $solicitudes = SolicitudDev::all();

        return view('transacciones.edit', compact('transaccion', 'cuentas', 'capitulos', 'partidas', 'unidades', 'areas', 'solicitudes'));
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
            'partida_id' => 'nullable|exists:partidas,id',
            'unidad_responsable_id' => 'nullable|exists:unidad_responsables,id',
            'area_id' => 'nullable|exists:areas,id',
            'solicitud_dev_id' => 'nullable|exists:solicitud_devs,id',
        ]);

        \DB::transaction(function () use ($request, $transaccion) {
            $oldTipo       = $transaccion->tipo;
            $oldMonto      = $transaccion->monto;
            $oldCuentaId   = $transaccion->cuenta_bancaria_id;

            $oldCuenta = CuentaBancaria::find($oldCuentaId);
            if ($oldCuenta) {
                if ($oldTipo === 'ingreso') {
                    $oldCuenta->saldo -= $oldMonto;
                } else {
                    $oldCuenta->saldo += $oldMonto;
                }
                $oldCuenta->save();
            }

            $transaccion->update($request->all());

            $newCuenta = CuentaBancaria::find($transaccion->cuenta_bancaria_id);
            if ($newCuenta) {
                if ($transaccion->tipo === 'ingreso') {
                    $newCuenta->saldo += $transaccion->monto;
                } else {
                    $newCuenta->saldo -= $transaccion->monto;
                }
                $newCuenta->save();
            }
        });

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
