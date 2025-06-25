<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MensualExport;
use App\Exports\IngresosVsEgresosExport;
use App\Exports\ViaticosExport;
use Illuminate\Support\Facades\DB;
use App\Models\ViaticoReal;

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
            [
                'titulo' => 'Auxiliar del Ejercicio del Gasto',
                'ver' => route('estadisticas.ver', 'ingresos-vs-egresos'),
                'descargar' => route('estadisticas.descargar', 'ingresos-vs-egresos')
            ],
            [
                'titulo' => 'Listado General de Viáticos',
                'ver' => route('estadisticas.ver', 'viaticos'),
                'descargar' => route('estadisticas.descargar', 'viaticos')
            ],
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

                $rendimientos = 0;

                $titulo = 'Comparativo de INGRESOS VS GASTOS EJERCIDO';

                return view('admin.settings.estadisticas.vistas.ingresos-vs-egresos', compact(
                    'titulo', 'datos', 'ministraciones', 'rendimientos'
                ));

            case 'viaticos':
                $titulo = 'Listado General de Viáticos';

                $viaticos = \App\Models\ViaticoReal::with(['empleado', 'fondo', 'cuentaBancaria'])
                    ->orderByDesc('fecha_entrega')
                    ->get();

                return view('admin.settings.estadisticas.vistas.viaticos', compact('titulo', 'viaticos'));

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

            case 'ingresos-vs-egresos':
                $filtroMes = request('mes');

                $proyecciones = DB::table('proyecciones')
                    ->selectRaw('month, SUM(monto) as total')
                    ->where('year', date('Y'))
                    ->when($filtroMes, fn($q) => $q->where('month', $filtroMes))
                    ->groupBy('month')
                    ->pluck('total', 'month');

                $ingresos = DB::table('ministraciones')
                    ->selectRaw('MONTH(fecha) as mes, SUM(importe) as total')
                    ->when($filtroMes, fn($q) => $q->whereMonth('fecha', $filtroMes))
                    ->whereYear('fecha', date('Y'))
                    ->groupByRaw('MONTH(fecha)')
                    ->pluck('total', 'mes');

                $ministraciones = DB::table('ministraciones')
                    ->whereYear('fecha', date('Y'))
                    ->when($filtroMes, fn($q) => $q->whereMonth('fecha', $filtroMes))
                    ->get();

                $egresos = DB::connection('inventarios')
                    ->table('requisiciones')
                    ->selectRaw('MONTH(fecha_requisicion) as mes, SUM(monto) as total')
                    ->where('status_requisicion', 'Entregado')
                    ->when($filtroMes, fn($q) => $q->whereMonth('fecha_requisicion', $filtroMes))
                    ->whereYear('fecha_requisicion', date('Y'))
                    ->groupByRaw('MONTH(fecha_requisicion)')
                    ->pluck('total', 'mes');

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

                $rendimientos = 0;

                return new IngresosVsEgresosExport($datos, $ministraciones, $rendimientos);

            case 'viaticos':
                $viaticos = \App\Models\ViaticoReal::with(['empleado', 'fondo', 'cuentaBancaria', 'comprobaciones'])->orderByDesc('fecha_entrega')->get();

                return Excel::download(new ViaticosExport($viaticos), 'viaticos.xlsx');


            default:
                abort(404, 'Descarga no disponible');
        }
    }
}
