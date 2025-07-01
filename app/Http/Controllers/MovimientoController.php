<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Movimiento;
use App\Models\CuentaBancaria;

class MovimientoController extends Controller
{
    public function index()
    {
        $soloRevisadas = request('revisadas') === '1';

        // Requisiciones del sistemaInventarios
        $requisiciones = DB::connection('inventarios')
            ->table('requisiciones')
            ->select(
                'requisiciones.id',
                DB::raw("'requisicion' as tipo"),
                'requisiciones.numero_requisicion as referencia',
                'requisiciones.producto_material as descripcion',
                'requisiciones.fecha_requisicion as fecha',
                'requisiciones.monto',
                'requisiciones.status_pago as status',
                DB::raw("'sistemaInventarios' as origen"),
                'requisiciones.cuenta_bancaria_id',
                'requisiciones.bloqueada'
            )
            ->get();

        // Obtener alertas del sistemaInventarios relacionadas con requisiciones
        $alertas = DB::connection('inventarios')
            ->table('alerts')
            ->where('tipo', 'Requisición')
            ->pluck('mensaje'); // también puedes usar otra clave para distinguir

        // Cuentas locales
        $cuentas = DB::table('cuenta_bancarias')->select('id', 'nombre')->get()->keyBy('id');

        // Añadir campos
        foreach ($requisiciones as $r) {
            $r->cuenta = $cuentas[$r->cuenta_bancaria_id]->nombre ?? 'Sin cuenta';
            $r->alertada = $alertas->contains(function ($mensaje) use ($r) {
                return str_contains($mensaje, (string) $r->id); // o alguna lógica para identificar la alerta
            });
        }

        if ($soloRevisadas) {
            $requisiciones = $requisiciones->filter(fn($r) => $r->bloqueada == 1);
        }

        $nominas = collect();
        $movimientos = $requisiciones->merge($nominas);

        return view('movimientos.index', compact('movimientos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        // Buscar la requisición desde la base de datos externa
        $requisicion = \DB::connection('inventarios')
            ->table('requisiciones')
            ->where('id', $id)
            ->first();

        if (!$requisicion) {
            abort(404, 'Requisición no encontrada');
        }

        return view('movimientos.show', compact('requisicion'));
    }

    public function alertar(Request $request, $id)
    {
        $request->validate([
            'mensaje' => 'required|string|max:5000',
        ]);

        $requisicion = DB::connection('inventarios')
            ->table('requisiciones')
            ->where('id', $id)
            ->first();

        if (!$requisicion) {
            return back()->with('error', 'Requisición no encontrada');
        }

        DB::connection('inventarios')->table('alerts')->insert([
            'tipo'     => 'Requisición',
            'mensaje'  => $request->mensaje,
            'origen'   => 'sistemaContable',
            'leido'    => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', '¡Alerta enviada correctamente!');
    }

    public function bloquear($id)
    {
        $requisicion = DB::connection('inventarios')
            ->table('requisiciones')
            ->where('id', $id)
            ->first();

        if (!$requisicion) {
            return back()->with('error', 'Requisición no encontrada');
        }

        $nuevoEstado = $requisicion->bloqueada ? 0 : 1;

        DB::connection('inventarios')
            ->table('requisiciones')
            ->where('id', $id)
            ->update(['bloqueada' => $nuevoEstado]);

        $mensaje = $nuevoEstado
            ? '¡Requisición bloqueada correctamente!'
            : '¡Requisición desbloqueada correctamente!';

        return back()->with('success', $mensaje);
    }

    public function edit(Area $area)
    {
        //
    }

    public function update(Request $request, Area $area)
    {
        //
    }

    public function destroy(Area $area)
    {
        //
    }
}
