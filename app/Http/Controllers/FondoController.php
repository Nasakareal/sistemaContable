<?php

namespace App\Http\Controllers;

use App\Models\Fondo;
use Illuminate\Http\Request;

class FondoController extends Controller
{
    public function index()
    {
        $fondos = Fondo::all();
        return view('fondos.index', compact('fondos'));
    }

    public function create()
    {
        return view('fondos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Fondo::create($request->only('nombre', 'descripcion'));

        return redirect()->route('fondos.index')->with('success', 'Fondo creado correctamente.');
    }

    public function show(Fondo $fondo)
    {
        return view('fondos.show', compact('fondo'));
    }

    public function edit(Fondo $fondo)
    {
        return view('fondos.edit', compact('fondo'));
    }

    public function update(Request $request, Fondo $fondo)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $fondo->update($request->only('nombre', 'descripcion'));

        return redirect()->route('fondos.index')->with('success', 'Fondo actualizado correctamente.');
    }

    public function destroy(Fondo $fondo)
    {
        $fondo->delete();

        return redirect()->route('fondos.index')->with('success', 'Fondo eliminado correctamente.');
    }
}
