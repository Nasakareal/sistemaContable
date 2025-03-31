<?php

namespace App\Http\Controllers;

use App\Models\CuentaBancaria;
use App\Models\Fondo;
use Illuminate\Http\Request;

class CuentaBancariaController extends Controller
{
    public function index()
    {
        $cuentas = CuentaBancaria::with('fondo')->get();
        return view('cuentas.index', compact('cuentas'));
    }

    public function create()
    {
        $fondos = Fondo::all();
        return view('cuentas.create', compact('fondos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fondo_id' => 'required|exists:fondos,id',
            'nombre'   => 'required|string|max:255',
            'numero'   => 'required|string|max:255',
            'saldo'    => 'required|numeric|min:0',
        ]);

        CuentaBancaria::create($request->all());

        return redirect()->route('cuentas')->with('success', 'Cuenta bancaria creada correctamente.');
    }

    public function show(CuentaBancaria $cuenta)
    {
        return view('cuentas.show', ['cuentaBancaria' => $cuenta]);
    }

    public function edit(CuentaBancaria $cuenta)
    {
        $fondos = Fondo::all();
        return view('cuentas.edit', ['cuentaBancaria' => $cuenta, 'fondos' => $fondos]);
    }

    public function update(Request $request, CuentaBancaria $cuenta)
    {
        $request->validate([
            'fondo_id' => 'required|exists:fondos,id',
            'nombre'   => 'required|string|max:255',
            'numero'   => 'required|string|max:255',
            'saldo'    => 'required|numeric|min:0',
        ]);

        $cuenta->update($request->all());

        return redirect()->route('cuentas')->with('success', 'Cuenta bancaria actualizada correctamente.');
    }

    public function destroy(CuentaBancaria $cuenta)
    {
        $cuenta->delete();
        return redirect()->route('cuentas')->with('success', 'Cuenta bancaria eliminada correctamente.');
    }
}
