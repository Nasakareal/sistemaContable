<?php

namespace App\Http\Controllers;

use App\Models\AsignacionPresupuestal;
use App\Models\Fondo;
use App\Models\CuentaBancaria;
use App\Models\UnidadResponsable;
use App\Models\Partida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AsignacionPresupuestalController extends Controller
{
    public function index()
    {
        $asignaciones = AsignacionPresupuestal::with(['fondo', 'cuentaBancaria', 'unidadResponsable', 'partida'])->get();

        $porUnidad = AsignacionPresupuestal::selectRaw('unidad_responsable_id, SUM(monto) as total')
            ->groupBy('unidad_responsable_id')
            ->with('unidadResponsable')
            ->get()
            ->map(function ($item) {
                return [
                    'unidad' => $item->unidadResponsable->clave ?? 'Sin unidad',
                    'total' => $item->total,
                ];
            });

        return view('admin.settings.asignacion_presupuestal.index', compact('asignaciones', 'porUnidad'));
    }

    public function create()
    {
        $fondos = Fondo::all();
        $cuentas = CuentaBancaria::all();
        $unidades = UnidadResponsable::all();
        $partidas = Partida::all();

        return view('admin.settings.asignacion_presupuestal.create', compact('fondos', 'cuentas', 'unidades', 'partidas'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'fondo_id' => 'required|exists:fondos,id',
            'cuenta_bancaria_id' => 'nullable|exists:cuenta_bancarias,id',
            'unidad_responsable_id' => 'required|exists:unidad_responsables,id',
            'partida_id' => 'nullable|exists:partidas,id',
            'monto' => 'required|numeric|min:0',
            'periodo' => 'nullable|string|max:20',
            'justificacion' => 'nullable|string',
        ]);

        try {
            AsignacionPresupuestal::create($validated);
            Log::info("Asignación presupuestal creada correctamente.");
            return redirect()->route('asignacion_presupuestal.index')->with('success', 'Asignación registrada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al registrar asignación presupuestal: " . $e->getMessage());
            return back()->withErrors('Error al registrar la asignación presupuestal.')->withInput();
        }
    }

    public function show(AsignacionPresupuestal $asignacion)
    {
        return view('admin.settings.asignacion_presupuestal.show', compact('asignacion'));
    }

    public function edit(AsignacionPresupuestal $asignacion)
    {
        $fondos = Fondo::all();
        $cuentas = CuentaBancaria::all();
        $unidades = UnidadResponsable::all();
        $partidas = Partida::all();
    
        return view('admin.settings.asignacion_presupuestal.edit', compact('asignacion', 'fondos', 'cuentas', 'unidades', 'partidas'));
    }


    public function update(Request $request, AsignacionPresupuestal $asignacion)
    {
        $validated = $request->validate([
            'fondo_id' => 'required|exists:fondos,id',
            'cuenta_bancaria_id' => 'nullable|exists:cuenta_bancarias,id',
            'unidad_responsable_id' => 'required|exists:unidad_responsables,id',
            'partida_id' => 'nullable|exists:partidas,id',
            'monto' => 'required|numeric|min:0',
            'periodo' => 'nullable|string|max:20',
            'justificacion' => 'nullable|string',
        ]);

        try {
            $asignacion->update($validated);
            Log::info("Asignación presupuestal actualizada correctamente.");
            return redirect()->route('asignacion_presupuestal.index')->with('success', 'Asignación actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al actualizar asignación presupuestal: " . $e->getMessage());
            return back()->withErrors('Error al actualizar la asignación presupuestal.')->withInput();
        }
    }

    public function destroy(AsignacionPresupuestal $asignacion)
    {
        try {
            $asignacion->delete();
            Log::info("Asignación presupuestal eliminada correctamente.");
            return redirect()->route('asignacion_presupuestal.index')->with('success', 'Asignación eliminada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al eliminar asignación presupuestal: " . $e->getMessage());
            return back()->withErrors('Error al eliminar la asignación presupuestal.');
        }
    }
}
