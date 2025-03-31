<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use App\Models\Capitulo;
use Illuminate\Http\Request;

class PartidaController extends Controller
{
    public function index()
    {
        $partidas = Partida::with('capitulo')->get();
        return view('partidas.index', compact('partidas'));
    }

    public function create()
    {
        $capitulos = Capitulo::all();
        return view('partidas.create', compact('capitulos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'capitulo_id'  => 'required|exists:capitulos,id',
        ]);

        Partida::create($request->all());

        return redirect()->route('partidas.index')->with('success', 'Partida creada exitosamente.');
    }

    public function show(Partida $partida)
    {
        return view('partidas.show', compact('partida'));
    }

    public function edit(Partida $partida)
    {
        $capitulos = Capitulo::all();
        return view('partidas.edit', compact('partida', 'capitulos'));
    }

    public function update(Request $request, Partida $partida)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'capitulo_id'  => 'required|exists:capitulos,id',
        ]);

        $partida->update($request->all());

        return redirect()->route('partidas.index')->with('success', 'Partida actualizada exitosamente.');
    }

    public function destroy(Partida $partida)
    {
        $partida->delete();
        return redirect()->route('partidas.index')->with('success', 'Partida eliminada exitosamente.');
    }
}
