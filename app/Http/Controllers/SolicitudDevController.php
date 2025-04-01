<?php

namespace App\Http\Controllers;

use App\Models\SolicitudDev;
use Illuminate\Http\Request;

class SolicitudDevController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudDev::all();
        return view('solicitudesDev.index', compact('solicitudes'));
    }

    public function create()
    {
        return view('solicitudesDev.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'documento_origen' => 'nullable|string|max:255',
        ]);

        SolicitudDev::create($request->all());

        return redirect()->route('solicitudesDev.index')->with('success', 'Solicitud creada exitosamente.');
    }

    public function show(SolicitudDev $solicitudDev)
    {
        return view('solicitudesDev.show', compact('solicitudDev'));
    }

    public function edit(SolicitudDev $solicitudDev)
    {
        return view('solicitudesDev.edit', compact('solicitudDev'));
    }

    public function update(Request $request, SolicitudDev $solicitudDev)
    {
        $request->validate([
            'codigo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'documento_origen' => 'nullable|string|max:255',
        ]);

        $solicitudDev->update($request->all());

        return redirect()->route('solicitudesDev.index')->with('success', 'Solicitud actualizada exitosamente.');
    }

    public function destroy(SolicitudDev $solicitudDev)
    {
        $solicitudDev->delete();
        return redirect()->route('solicitudesDev.index')->with('success', 'Solicitud eliminada exitosamente.');
    }
}
