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
                'titulo' => 'Ingresos vs Egresos',
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
