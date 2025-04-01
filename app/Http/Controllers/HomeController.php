<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CuentaBancaria;
use App\Models\Transaccion;

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
        $totalIngresos = Transaccion::where('tipo', 'ingreso')->sum('monto');
        $totalEgresos  = Transaccion::where('tipo', 'egreso')->sum('monto');
        $saldoNeto     = $totalIngresos - $totalEgresos;

        $cuentas = CuentaBancaria::select('nombre', 'saldo')->get();

        $transaccionesPorDia = Transaccion::selectRaw("DATE(fecha) as fecha, 
            SUM(CASE WHEN tipo = 'ingreso' THEN monto ELSE 0 END) as ingresos, 
            SUM(CASE WHEN tipo = 'egreso' THEN monto ELSE 0 END) as egresos")
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $transaccionesPorTipo = Transaccion::selectRaw("tipo, COUNT(*) as cantidad")
            ->groupBy('tipo')
            ->pluck('cantidad', 'tipo');

        return response()->json([
            'summary' => [
                'total_ingresos' => $totalIngresos,
                'total_egresos'  => $totalEgresos,
                'saldo_neto'     => $saldoNeto,
            ],
            'cuentas' => $cuentas,
            'transacciones_por_dia' => $transaccionesPorDia,
            'transacciones_por_tipo' => $transaccionesPorTipo,
        ]);
    }
}
