<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MensualExport;
use Illuminate\Support\Facades\DB;

class EstadisticaController extends Controller
{
    public function index()
    {
        $estadisticas = [
            [
                'titulo' => 'Comparativo Mensual',
                'ver' => route('estadisticas.ver', 'mensual'),
                'descargar' => route('estadisticas.descargar', 'mensual')
            ],
            [
                'titulo' => 'Analisis Ingresos vs Gastos',
                'ver' => route('estadisticas.ver', 'ingresos-vs-egresos'),
                'descargar' => route('estadisticas.descargar', 'ingresos-vs-egresos')
            ],
            // Agrega más...
        ];

        return view('admin.settings.estadisticas.index', compact('estadisticas'));
    }

    public function ver($tipo)
    {
        switch ($tipo) {
            case 'mensual':
                $filtroMes = request('mes');

                $proyecciones = DB::table('proyecciones')
                    ->selectRaw('month, SUM(monto) as total')
                    ->where('year', date('Y'))
                    ->when($filtroMes, fn($q) => $q->where('month', $filtroMes))
                    ->groupBy('month')
                    ->pluck('total', 'month');

                $ministraciones = DB::table('ministraciones')
                    ->selectRaw('MONTH(fecha) as mes, SUM(importe) as total')
                    ->when($filtroMes, fn($q) => $q->whereMonth('fecha', $filtroMes))
                    ->groupByRaw('MONTH(fecha)')
                    ->pluck('total', 'mes');

                $requisiciones = DB::connection('inventarios')
                    ->table('requisiciones')
                    ->selectRaw('MONTH(fecha_requisicion) as mes, SUM(monto) as total')
                    ->when($filtroMes, fn($q) => $q->whereMonth('fecha_requisicion', $filtroMes))
                    ->groupByRaw('MONTH(fecha_requisicion)')
                    ->pluck('total', 'mes');

                $datos = [];
                for ($mes = 1; $mes <= 12; $mes++) {
                    if ($filtroMes && $mes != $filtroMes) continue;

                    $datos[] = [
                        'mes' => ucfirst(\Carbon\Carbon::create()->month($mes)->locale('es')->monthName),
                        'proyectado' => round($proyecciones[$mes] ?? 0, 2),
                        'ministrado' => round($ministraciones[$mes] ?? 0, 2),
                        'recaudado'  => round($requisiciones[$mes] ?? 0, 2),
                    ];
                }

                $titulo = 'Comparativo Mensual';
                return view('admin.settings.estadisticas.vistas.mensual', compact('titulo', 'datos'));

            case 'ingresos-vs-egresos':
                $filtroMes = request('mes');

                // INGRESOS PROYECTADOS
                $proyecciones = DB::table('proyecciones')
                    ->selectRaw('month, SUM(monto) as total')
                    ->where('year', date('Y'))
                    ->when($filtroMes, fn($q) => $q->where('month', $filtroMes))
                    ->groupBy('month')
                    ->pluck('total', 'month');

                // INGRESOS RECAUDADOS PARA LA GRÁFICA (agrupado por mes)
                $ingresos = DB::table('ministraciones')
                    ->selectRaw('MONTH(fecha) as mes, SUM(importe) as total')
                    ->when($filtroMes, fn($q) => $q->whereMonth('fecha', $filtroMes))
                    ->whereYear('fecha', date('Y'))
                    ->groupByRaw('MONTH(fecha)')
                    ->pluck('total', 'mes');

                // INGRESOS RECAUDADOS DETALLADO PARA LA TABLA (ministraciones completas)
                $ministraciones = DB::table('ministraciones')
                    ->whereYear('fecha', date('Y'))
                    ->get();

                // EGRESOS PAGADOS (requisiciones entregadas)
                $egresos = DB::connection('inventarios')
                    ->table('requisiciones')
                    ->selectRaw('MONTH(fecha_requisicion) as mes, SUM(monto) as total')
                    ->where('status_requisicion', 'Entregado')
                    ->when($filtroMes, fn($q) => $q->whereMonth('fecha_requisicion', $filtroMes))
                    ->whereYear('fecha_requisicion', date('Y'))
                    ->groupByRaw('MONTH(fecha_requisicion)')
                    ->pluck('total', 'mes');

                // Estructura final de datos para la gráfica
                $datos = [];
                for ($mes = 1; $mes <= 12; $mes++) {
                    if ($filtroMes && $mes != $filtroMes) continue;

                    $proyectado = round($proyecciones[$mes] ?? 0, 2);
                    $recaudado = round($ingresos[$mes] ?? 0, 2);
                    $egresado = round($egresos[$mes] ?? 0, 2);
                    $diferencia = $recaudado - $egresado;

                    $datos[] = [
                        'mes' => ucfirst(\Carbon\Carbon::create()->month($mes)->locale('es')->monthName),
                        'proyectado' => $proyectado,
                        'recaudado' => $recaudado,
                        'egresado' => $egresado,
                        'diferencia' => $diferencia,
                        'solo_ministraciones' => $recaudado,
                        'solo_requisiciones' => $egresado,
                    ];
                }

                $rendimientos = 0; // Si tienes rendimientos, reemplaza por su valor real

                $titulo = 'Comparativo de INGRESOS VS GASTOS EJERCIDO';

                return view('admin.settings.estadisticas.vistas.ingresos_vs_egresos', compact(
                    'titulo', 'datos', 'ministraciones', 'rendimientos'
                ));


            default:
                abort(404, 'Vista de estadística no disponible');
        }
    }

    public function descargar($tipo)
{
    switch ($tipo) {
        case 'mensual':
            $filtroMes = request('mes');

            $proyecciones = DB::table('proyecciones')
                ->selectRaw('month, SUM(monto) as total')
                ->where('year', date('Y'))
                ->when($filtroMes, fn($q) => $q->where('month', $filtroMes))
                ->groupBy('month')
                ->pluck('total', 'month');

            $ministraciones = DB::table('ministraciones')
                ->selectRaw('MONTH(fecha) as mes, SUM(importe) as total')
                ->when($filtroMes, fn($q) => $q->whereMonth('fecha', $filtroMes))
                ->groupByRaw('MONTH(fecha)')
                ->pluck('total', 'mes');

            $requisiciones = DB::connection('inventarios')
                ->table('requisiciones')
                ->selectRaw('MONTH(fecha_requisicion) as mes, SUM(monto) as total')
                ->when($filtroMes, fn($q) => $q->whereMonth('fecha_requisicion', $filtroMes))
                ->groupByRaw('MONTH(fecha_requisicion)')
                ->pluck('total', 'mes');

            $datos = [];
            for ($mes = 1; $mes <= 12; $mes++) {
                if ($filtroMes && $mes != $filtroMes) continue;

                $datos[] = [
                    'mes' => ucfirst(\Carbon\Carbon::create()->month($mes)->locale('es')->monthName),
                    'proyectado' => round($proyecciones[$mes] ?? 0, 2),
                    'ministrado' => round($ministraciones[$mes] ?? 0, 2),
                    'recaudado'  => round($requisiciones[$mes] ?? 0, 2),
                ];
            }

            return new MensualExport($datos);


        default:
            abort(404, 'Descarga no disponible');
    }
}


}
