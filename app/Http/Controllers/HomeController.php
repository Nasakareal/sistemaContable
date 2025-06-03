<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CuentaBancaria;
use App\Models\Transaccion;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function json()
    {
        // 1. Totales de ingresos/egresos
        $totalIngresos = Transaccion::where('tipo', 'ingreso')->sum('monto');
        $totalEgresos  = Transaccion::where('tipo', 'egreso')->sum('monto');
        $saldoNeto     = $totalIngresos - $totalEgresos;

        // 2. Cuentas bancarias
        $cuentas = CuentaBancaria::select('nombre', 'saldo')->get();

        // 3. Transacciones por día (para el gráfico de barras)
        $transaccionesPorDia = Transaccion::selectRaw("
                DATE(fecha) as fecha, 
                SUM(CASE WHEN tipo = 'ingreso' THEN monto ELSE 0 END) as ingresos, 
                SUM(CASE WHEN tipo = 'egreso' THEN monto ELSE 0 END) as egresos
            ")
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        // 4. Distribución por tipo (pie chart)
        $transaccionesPorTipo = Transaccion::selectRaw("
                tipo, 
                SUM(monto) as total
            ")
            ->groupBy('tipo')
            ->pluck('total','tipo');

        // 5. Top 5 Egresos (reales)
        try {
            $topEgresos = DB::connection('inventarios')
                ->table('requisiciones')
                ->select('producto_material as concepto', 'monto')
                ->whereNotNull('monto')
                ->orderByDesc('monto')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            dd('Error al cargar topEgresos: ' . $e->getMessage());
        }

        // 6. Top 5 Ingresos (reales)
        $topIngresos = Transaccion::select('descripcion as concepto', 'monto')
            ->where('tipo','ingreso')
            ->orderByDesc('monto')
            ->limit(5)
            ->get();

        // Retornamos todo en JSON
        return response()->json([
            'summary' => [
                'total_ingresos' => $totalIngresos,
                'total_egresos'  => $totalEgresos,
                'saldo_neto'     => $saldoNeto,
            ],
            'cuentas'                => $cuentas,
            'transacciones_por_dia'  => $transaccionesPorDia,
            'transacciones_por_tipo' => $transaccionesPorTipo,
            'top_egresos'            => $topEgresos,
            'top_ingresos'           => $topIngresos,
        ]);
    }
}
