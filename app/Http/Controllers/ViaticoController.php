<?php

namespace App\Http\Controllers;

use App\Models\ViaticoReal as Viatico;
use App\Models\Fondo;
use App\Models\CuentaBancaria;
use App\Models\Partida;
use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Capitulo;

class ViaticoController extends Controller
{
    public function index()
    {
        $viaticos = Viatico::with(['fondo', 'cuentaBancaria', 'empleado'])->get();
        return view('viaticos.index', compact('viaticos'));
    }

    public function create()
    {
        $fondos   = Fondo::all();
        $cuentas  = CuentaBancaria::all();
        $empleados = Empleado::on('humanos')->get();
        $partidas = Partida::all();
        $capitulos  = Capitulo::all();

        return view('viaticos.create', compact('fondos', 'cuentas', 'empleados', 'partidas', 'capitulos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado_id'         => 'required|integer',
            'fondo_id'            => 'required|exists:fondos,id',
            'cuenta_bancaria_id'  => 'required|exists:cuenta_bancarias,id',
            'fecha_entrega'       => 'required|date',
            'importe_total'       => 'required|numeric|min:0',
            'estatus'             => 'required|in:PENDIENTE,COMPROBADO,PARCIAL,CANCELADO',
            'observaciones'       => 'nullable|string',
            'partidas.*.id'       => 'nullable|exists:partidas,id',
            'partidas.*.monto'    => 'nullable|numeric|min:0',
        ]);

        $sumaPartidas = collect($request->input('partidas', []))
            ->pluck('monto')
            ->filter()
            ->sum();

        if ($sumaPartidas > $request->importe_total) {
            return back()->withErrors(['partidas' => 'La suma de las partidas excede el importe total del viático.'])
                         ->withInput();
        }

        $cuenta = CuentaBancaria::find($request->cuenta_bancaria_id);

        if ($request->importe_total > $cuenta->saldo) {
            return back()->withErrors(['importe_total' => 'El saldo de la cuenta es insuficiente para cubrir este viático.'])
                         ->withInput();
        }

        $viatico = Viatico::create($request->all());

        foreach ($request->input('partidas', []) as $partida) {
            if (!empty($partida['id']) && $partida['monto'] > 0) {
                $viatico->partidas()->attach($partida['id'], ['monto' => $partida['monto']]);
            }
        }

        $cuenta->saldo -= $request->importe_total;
        $cuenta->save();

        return redirect()->route('viaticos.index')->with('success', 'Viático registrado correctamente.');
    }

    public function show(Viatico $viatico)
    {
        $viatico->load(['fondo', 'cuentaBancaria', 'empleado']);
        return view('viaticos.show', compact('viatico'));
    }

    public function edit(Viatico $viatico)
    {
        $viatico->load('partidas');

        $fondos    = Fondo::all();
        $cuentas   = CuentaBancaria::all();
        $empleados = Empleado::on('humanos')->get();
        $capitulos = Capitulo::all();

        $capituloSeleccionado = optional($viatico->partidas->first())->capitulo_id;

        $partidas = $capituloSeleccionado
            ? Partida::where('capitulo_id', $capituloSeleccionado)->get()
            : collect();

        return view('viaticos.edit', compact('viatico', 'fondos', 'cuentas', 'empleados', 'capitulos', 'partidas', 'capituloSeleccionado'));
    }


    public function update(Request $request, Viatico $viatico)
    {
        $request->validate([
            'empleado_id'         => 'required|integer',
            'fondo_id'            => 'required|exists:fondos,id',
            'cuenta_bancaria_id'  => 'required|exists:cuenta_bancarias,id',
            'fecha_entrega'       => 'required|date',
            'importe_total'       => 'required|numeric|min:0',
            'estatus'             => 'required|in:PENDIENTE,COMPROBADO,PARCIAL,CANCELADO',
            'observaciones'       => 'nullable|string',
            'partidas.*.id'       => 'nullable|exists:partidas,id',
            'partidas.*.monto'    => 'nullable|numeric|min:0',
        ]);

        $sumaPartidas = collect($request->input('partidas', []))->pluck('monto')->filter()->sum();

        if ($sumaPartidas > $request->importe_total) {
            return back()->withErrors(['partidas' => 'La suma de las partidas excede el importe total del viático.'])
                         ->withInput();
        }

        // Ajustar saldo si cambió cuenta o importe
        if ($viatico->cuenta_bancaria_id != $request->cuenta_bancaria_id) {
            $cuentaAnterior = CuentaBancaria::find($viatico->cuenta_bancaria_id);
            $cuentaAnterior->saldo += $viatico->importe_total;
            $cuentaAnterior->save();

            $cuentaNueva = CuentaBancaria::find($request->cuenta_bancaria_id);
            $cuentaNueva->saldo -= $request->importe_total;
            $cuentaNueva->save();
        } else {
            $cuenta = CuentaBancaria::find($request->cuenta_bancaria_id);
            $cuenta->saldo += $viatico->importe_total;
            $cuenta->saldo -= $request->importe_total;
            $cuenta->save();
        }

        $viatico->update($request->all());

        // Actualizar partidas (detach y attach nuevas)
        $viatico->partidas()->detach();
        foreach ($request->input('partidas', []) as $partida) {
            if (!empty($partida['id']) && $partida['monto'] > 0) {
                $viatico->partidas()->attach($partida['id'], ['monto' => $partida['monto']]);
            }
        }

        return redirect()->route('viaticos.index')->with('success', 'Viático actualizado correctamente.');
    }


    public function destroy(Viatico $viatico)
    {
        // Reintegrar el saldo
        $cuenta = CuentaBancaria::find($viatico->cuenta_bancaria_id);
        $cuenta->saldo += $viatico->importe_total;
        $cuenta->save();

        $viatico->delete();

        return redirect()->route('viaticos.index')->with('success', 'Viático eliminado correctamente.');
    }

    public function getPartidas($id)
    {
        $partidas = Partida::where('capitulo_id', $id)
            ->select('id', 'nombre', 'descripcion')
            ->get();

        return response()->json($partidas);
    }
}
