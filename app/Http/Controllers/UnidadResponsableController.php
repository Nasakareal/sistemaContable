<?php

namespace App\Http\Controllers;

use App\Models\UnidadResponsable;
use App\Models\Fondo;
use Illuminate\Http\Request;

class UnidadResponsableController extends Controller
{
    public function index()
    {
        $unidad_responsables = UnidadResponsable::with('fondo')->get();
        return view('unidad_responsables.index', compact('unidad_responsables'));
    }

    public function create()
    {
        $fondos = Fondo::all();
        return view('unidad_responsables.create', compact('fondos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required|string|unique:unidad_responsables,clave',
            'nombre' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'fondo_id' => 'required|exists:fondos,id',
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
        $fondos = Fondo::all();
        return view('unidad_responsables.edit', compact('unidad_responsable', 'fondos'));
    }

    public function update(Request $request, UnidadResponsable $unidad_responsable)
    {
        $request->validate([
            'clave' => 'required|string|unique:unidad_responsables,clave,' . $unidad_responsable->id,
            'nombre' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'fondo_id' => 'required|exists:fondos,id',
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
