<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EstadisticaController extends Controller
{
    public function index()
    {
        $estadisticas = [
            ['titulo' => 'Comparativo Mensual', 'ruta' => route('estadisticas.show', 'mensual')],
            ['titulo' => 'Comparativo Trimestral', 'ruta' => route('estadisticas.show', 'trimestral')],
            ['titulo' => 'Comparativo Cuatrimestral', 'ruta' => route('estadisticas.show', 'cuatrimestral')],
            ['titulo' => 'Comparativo Semestral', 'ruta' => route('estadisticas.show', 'semestral')],
            ['titulo' => 'Ingresos vs Egresos', 'ruta' => route('estadisticas.show', 'ingresos-vs-egresos')],
            ['titulo' => 'Top 5 Ingresos', 'ruta' => route('estadisticas.show', 'top-ingresos')],
            ['titulo' => 'Top 5 Egresos', 'ruta' => route('estadisticas.show', 'top-egresos')],
            ['titulo' => 'Totales por Cuenta Bancaria', 'ruta' => route('estadisticas.show', 'por-cuenta')],
        ];

        return view('admin.settings.estadisticas.index', compact('estadisticas'));
    }

    public function show($estadistica)
    {
        switch ($estadistica) {
            case 'mensual':
                return Excel::download(new \App\Exports\MensualExport, 'comparativo_mensual.xlsx');
            case 'trimestral':
                return Excel::download(new \App\Exports\TrimestralExport, 'comparativo_trimestral.xlsx');
            case 'cuatrimestral':
                return Excel::download(new \App\Exports\CuatrimestralExport, 'comparativo_cuatrimestral.xlsx');
            case 'semestral':
                return Excel::download(new \App\Exports\SemestralExport, 'comparativo_semestral.xlsx');
            case 'ingresos-vs-egresos':
                return Excel::download(new \App\Exports\IngresosVsEgresosExport, 'ingresos_vs_egresos.xlsx');
            case 'top-ingresos':
                return Excel::download(new \App\Exports\TopIngresosExport, 'top_5_ingresos.xlsx');
            case 'top-egresos':
                return Excel::download(new \App\Exports\TopEgresosExport, 'top_5_egresos.xlsx');
            case 'por-cuenta':
                return Excel::download(new \App\Exports\PorCuentaExport, 'totales_por_cuenta.xlsx');
            default:
                abort(404, 'Estadística no encontrada');
        }
    }

}
