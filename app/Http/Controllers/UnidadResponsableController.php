<?php

namespace App\Http\Controllers;

use App\Models\UnidadResponsable;
use Illuminate\Http\Request;

class UnidadResponsableController extends Controller
{
    public function index()
    {
        $unidad_responsables = UnidadResponsable::all();
        return view('unidad_responsables.index', compact('unidad_responsables'));
    }

    public function create()
    {
        return view('unidad_responsables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        UnidadResponsable::create($request->all());

        return redirect()->route('unidad_responsables.index')->with('success', 'Unidad creada exitosamente.');
    }

    public function show(UnidadResponsable $unidad_responsable)
    {
        return view('unidad_responsables.show', compact('unidad_responsable'));
    }

    public function edit(UnidadResponsable $unidad_responsable)
    {
        return view('unidad_responsables.edit', compact('unidad_responsable'));
    }

    public function update(Request $request, UnidadResponsable $unidad_responsable)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $unidad_responsable->update($request->all());

        return redirect()->route('unidad_responsables.index')->with('success', 'Unidad actualizada exitosamente.');
    }

    public function destroy(UnidadResponsable $unidad_responsable)
    {
        $unidad_responsable->delete();
        return redirect()->route('unidad_responsables.index')->with('success', 'Unidad eliminada exitosamente.');
    }
}
