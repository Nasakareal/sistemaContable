<?php

namespace App\Http\Controllers;

use App\Models\Capitulo;
use Illuminate\Http\Request;

class CapituloController extends Controller
{
    public function index()
    {
        $capitulos = Capitulo::all();
        return view('capitulos.index', compact('capitulos'));
    }

    public function create()
    {
        return view('capitulos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Capitulo::create($request->all());

        return redirect()->route('capitulos.index')->with('success', 'Capítulo creado correctamente.');
    }

    public function show(Capitulo $capitulo)
    {
        return view('capitulos.show', compact('capitulo'));
    }

    public function edit(Capitulo $capitulo)
    {
        return view('capitulos.edit', compact('capitulo'));
    }

    public function update(Request $request, Capitulo $capitulo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $capitulo->update($request->all());

        return redirect()->route('capitulos.index')->with('success', 'Capítulo actualizado correctamente.');
    }

    public function destroy(Capitulo $capitulo)
    {
        $capitulo->delete();

        return redirect()->route('capitulos.index')->with('success', 'Capítulo eliminado correctamente.');
    }
}
