<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\SolicitudDev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvidenciaController extends Controller
{
    public function index()
    {
        $evidencias = Evidencia::with('solicitudDev')->get();
        return view('evidencias.index', compact('evidencias'));
    }

    public function create()
    {
        $solicitudes = SolicitudDev::all();
        return view('evidencias.create', compact('solicitudes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'solicitud_dev_id' => 'nullable|exists:solicitud_devs,id',
            'ruta' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $path = $request->file('ruta')->store('evidencias', 'public');

        Evidencia::create([
            'solicitud_dev_id' => $request->solicitud_dev_id,
            'ruta' => $path,
        ]);

        return redirect()->route('evidencias.index')->with('success', 'Evidencia cargada correctamente.');
    }

    public function show(Evidencia $evidencia)
    {
        return view('evidencias.show', compact('evidencia'));
    }

    public function edit(Evidencia $evidencia)
    {
        $solicitudes = SolicitudDev::all();
        return view('evidencias.edit', compact('evidencia', 'solicitudes'));
    }

    public function update(Request $request, Evidencia $evidencia)
    {
        $request->validate([
            'solicitud_dev_id' => 'nullable|exists:solicitud_devs,id',
            'ruta' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('ruta')) {
            Storage::disk('public')->delete($evidencia->ruta);
            $evidencia->ruta = $request->file('ruta')->store('evidencias', 'public');
        }

        $evidencia->solicitud_dev_id = $request->solicitud_dev_id;
        $evidencia->save();

        return redirect()->route('evidencias.index')->with('success', 'Evidencia actualizada.');
    }

    public function destroy(Evidencia $evidencia)
    {
        Storage::disk('public')->delete($evidencia->ruta);
        $evidencia->delete();
        return redirect()->route('evidencias.index')->with('success', 'Evidencia eliminada.');
    }
}
