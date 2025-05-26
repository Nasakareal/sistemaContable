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
        // Requisiciones desde sistemaInventarios
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
                'requisiciones.cuenta_bancaria_id'
            )
            ->get();

        // Traer las cuentas desde sistemaContable
        $cuentas = DB::table('cuenta_bancarias')->select('id', 'nombre')->get()->keyBy('id');

        // Añadir el nombre de cuenta a cada requisición manualmente
        foreach ($requisiciones as $r) {
            $r->cuenta = $cuentas[$r->cuenta_bancaria_id]->nombre ?? 'Sin cuenta';
        }

        // Nominas aún vacías
        $nominas = collect();

        // Unir ambos
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
