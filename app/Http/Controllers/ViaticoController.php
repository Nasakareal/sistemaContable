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

        return view('viaticos.create', compact('fondos', 'cuentas', 'empleados'));
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
        ]);

        $cuenta = CuentaBancaria::findOrFail($request->cuenta_bancaria_id);

        if ($request->importe_total > $cuenta->saldo) {
            return back()->withErrors(['importe_total' => 'El saldo de la cuenta es insuficiente para cubrir este viático.'])
                         ->withInput();
        }

        $viatico = Viatico::create($request->all());
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
        $fondos    = Fondo::all();
        $cuentas   = CuentaBancaria::all();
        $empleados = Empleado::on('humanos')->get();

        return view('viaticos.edit', compact('viatico', 'fondos', 'cuentas', 'empleados'));
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
        ]);

        // Ajustar saldo si cambió cuenta o importe
        if ($viatico->cuenta_bancaria_id != $request->cuenta_bancaria_id) {
            // Reembolsar a la cuenta anterior
            $cuentaAnterior = CuentaBancaria::findOrFail($viatico->cuenta_bancaria_id);
            $cuentaAnterior->saldo += $viatico->importe_total;
            $cuentaAnterior->save();

            // Cobrar de la nueva cuenta
            $cuentaNueva = CuentaBancaria::findOrFail($request->cuenta_bancaria_id);
            if ($request->importe_total > $cuentaNueva->saldo) {
                return back()->withErrors(['importe_total' => 'Saldo insuficiente en la cuenta seleccionada.'])->withInput();
            }
            $cuentaNueva->saldo -= $request->importe_total;
            $cuentaNueva->save();

        } elseif ($viatico->importe_total != $request->importe_total) {
            // Si solo cambió el importe, ajustar saldo
            $cuenta = CuentaBancaria::findOrFail($viatico->cuenta_bancaria_id);
            $diferencia = $request->importe_total - $viatico->importe_total;

            if ($diferencia > 0 && $diferencia > $cuenta->saldo) {
                return back()->withErrors(['importe_total' => 'Saldo insuficiente para aumentar el importe.'])->withInput();
            }

            $cuenta->saldo -= $diferencia;
            $cuenta->save();
        }

        // Actualizar el viático
        $viatico->update($request->all());

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
