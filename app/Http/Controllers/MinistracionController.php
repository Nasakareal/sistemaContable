<?php

namespace App\Http\Controllers;

use App\Models\Ministracion;
use App\Models\Fondo;
use App\Models\CuentaBancaria;
use App\Models\UnidadResponsable;
use App\Models\Partida;
use Illuminate\Http\Request;
use App\Models\Capitulo;

class MinistracionController extends Controller
{
    public function index()
    {
        $ministraciones = Ministracion::with(['fondo', 'cuentaBancaria', 'unidadResponsable', 'partida'])->get();
        return view('ministraciones.index', compact('ministraciones'));
    }

    public function create()
    {
        $fondos = Fondo::all();
        $cuentas = CuentaBancaria::all();
        $unidades = UnidadResponsable::all();
        $partidas = Partida::all();
        $capitulos = Capitulo::all();

        return view('ministraciones.create', compact('fondos', 'cuentas', 'unidades', 'partidas', 'capitulos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'fondo_id' => 'required|exists:fondos,id',
            'cuenta_bancaria_id' => 'required|exists:cuenta_bancarias,id',
            'unidad_responsable_id' => 'required|exists:unidad_responsables,id',
            'partida_id' => 'nullable|exists:partidas,id',
            'importe' => 'required|numeric|min:0',

            'tipo_gasto' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'periodo' => 'nullable|string|max:10',
            'observaciones' => 'nullable|string',

            'referencia_gasto' => 'nullable|string|max:255',
            'referencia_desc_gasto' => 'nullable|string|max:255',
            'ref_fondo' => 'nullable|string|max:255',
            'ref_partida' => 'nullable|string|max:255',
            'ref_ur' => 'nullable|string|max:255',
            'ref_part' => 'nullable|string|max:255',
            'cuenta_bancaria_origen' => 'nullable|string|max:255',
            'cuenta_aplicacion' => 'nullable|string|max:255',
        ]);

        // Registrar ministración
        $ministracion = Ministracion::create($request->all());

        // Actualizar el saldo de la cuenta bancaria
        $cuenta = CuentaBancaria::find($request->cuenta_bancaria_id);
        $cuenta->saldo += $request->importe;
        $cuenta->save();

        return redirect()->route('ministraciones.index')->with('success', 'Ministración registrada correctamente.');
    }


    public function show(Ministracion $ministracion)
    {
        return view('ministraciones.show', compact('ministracion'));
    }

    public function edit(Ministracion $ministracion)
    {
        $fondos     = Fondo::all();
        $cuentas    = CuentaBancaria::all();
        $unidades   = UnidadResponsable::all();
        $partidas   = Partida::all();
        $capitulos  = \App\Models\Capitulo::all();

        return view('ministraciones.edit', compact('ministracion', 'fondos', 'cuentas', 'unidades', 'partidas', 'capitulos'));
    }


    public function update(Request $request, Ministracion $ministracion)
    {
        $request->validate([
            'fecha' => 'required|date',
            'fondo_id' => 'required|exists:fondos,id',
            'cuenta_bancaria_id' => 'required|exists:cuenta_bancarias,id',
            'unidad_responsable_id' => 'required|exists:unidad_responsables,id',
            'partida_id' => 'nullable|exists:partidas,id',
            'importe' => 'required|numeric|min:0',

            'tipo_gasto' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'periodo' => 'nullable|string|max:10',
            'observaciones' => 'nullable|string',

            'referencia_gasto' => 'nullable|string|max:255',
            'referencia_desc_gasto' => 'nullable|string|max:255',
            'ref_fondo' => 'nullable|string|max:255',
            'ref_partida' => 'nullable|string|max:255',
            'ref_ur' => 'nullable|string|max:255',
            'ref_part' => 'nullable|string|max:255',
            'cuenta_bancaria_origen' => 'nullable|string|max:255',
            'cuenta_aplicacion' => 'nullable|string|max:255',
        ]);

        // Si se cambió la cuenta, ajustar ambas
        if ($request->cuenta_bancaria_id != $ministracion->cuenta_bancaria_id) {
            // Restar a la anterior
            $cuentaAnterior = CuentaBancaria::find($ministracion->cuenta_bancaria_id);
            $cuentaAnterior->saldo -= $ministracion->importe;
            $cuentaAnterior->save();

            // Sumar a la nueva
            $cuentaNueva = CuentaBancaria::find($request->cuenta_bancaria_id);
            $cuentaNueva->saldo += $request->importe;
            $cuentaNueva->save();
        } else {
            // Solo ajustar el saldo en la misma cuenta
            $cuenta = CuentaBancaria::find($request->cuenta_bancaria_id);
            $cuenta->saldo -= $ministracion->importe;
            $cuenta->saldo += $request->importe;
            $cuenta->save();
        }

        $ministracion->update($request->all());

        return redirect()->route('ministraciones.index')->with('success', 'Ministración actualizada correctamente.');
    }

    public function destroy(Ministracion $ministracion)
    {
        $cuenta = CuentaBancaria::find($ministracion->cuenta_bancaria_id);
        $cuenta->saldo -= $ministracion->importe;
        $cuenta->save();

        $ministracion->delete();

        return redirect()->route('ministraciones.index')->with('success', 'Ministración eliminada correctamente.');
    }
}
