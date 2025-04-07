<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $reportes = [
            [
                'id' => 'banco',
                'nombre' => 'Reporte Banco',
                'descripcion' => 'Reporte de movimientos bancarios agrupados por mes y trimestre.'
            ],
        ];

        if ($tipo = $request->get('tipo')) {
            $reportes = array_filter($reportes, fn($r) => $r['id'] == $tipo);
        }

        return view('reportes.index', compact('reportes'));
    }

    public function exportExcel(Request $request)
    {
        // ...
    }

    public function exportPdf(Request $request)
    {
        // ...
    }

    public function banco(Request $request)
    {
        $mesesDefinidos = [
            1  => ['mes' => 'ENERO',      'trim' => 1,  'periodo' => '2025-01'],
            2  => ['mes' => 'FEBRERO',    'trim' => 1,  'periodo' => '2025-02'],
            3  => ['mes' => 'MARZO',      'trim' => 1,  'periodo' => '2025-03'],
            4  => ['mes' => 'ABRIL',      'trim' => 2,  'periodo' => '2025-04'],
            5  => ['mes' => 'MAYO',       'trim' => 2,  'periodo' => '2025-05'],
            6  => ['mes' => 'JUNIO',      'trim' => 2,  'periodo' => '2025-06'],
            7  => ['mes' => 'JULIO',      'trim' => 3,  'periodo' => '2025-07'],
            8  => ['mes' => 'AGOSTO',     'trim' => 3,  'periodo' => '2025-08'],
            9  => ['mes' => 'SEPTIEMBRE', 'trim' => 3,  'periodo' => '2025-09'],
            10 => ['mes' => 'OCTUBRE',    'trim' => 4,  'periodo' => '2025-10'],
            11 => ['mes' => 'NOVIEMBRE',  'trim' => 4,  'periodo' => '2025-11'],
            12 => ['mes' => 'DICIEMBRE',  'trim' => 4,  'periodo' => '2025-12'],
            13 => ['mes' => 'ene-26',     'trim' => '1a','periodo' => null],
        ];

        $todasCuentas = DB::table('cuenta_bancarias')->get();

        $anio = 2025;
        $datos = [];

        foreach ($mesesDefinidos as $numMes => $infoMes) {
            $row = [
                'mes'     => $infoMes['mes'],
                'trim'    => $infoMes['trim'],
                'periodo' => $infoMes['periodo'],
                'datos'   => [],
            ];

            if ($numMes <= 12) {
                foreach ($todasCuentas as $cuenta) {
                    $transacciones = DB::table('transacciones')
                        ->whereYear('fecha', $anio)
                        ->whereMonth('fecha', $numMes)
                        ->where('cuenta_bancaria_id', $cuenta->id)
                        ->get();

                    $suma1000y3000 = 0;
                    $sumaOtros     = 0;

                    foreach ($transacciones as $t) {
                        if (in_array($t->capitulo_id, [1000, 3000])) {
                            $suma1000y3000 += $t->monto;
                        } else {
                            $sumaOtros += $t->monto;
                        }
                    }

                    $row['datos'][$cuenta->id] = [
                        'origen'     => null,
                        '1000y3000'  => $suma1000y3000,
                        'otrosMov'   => $sumaOtros,
                        'saldo'      => null,
                    ];
                }
            } else {
                foreach ($todasCuentas as $cuenta) {
                    $row['datos'][$cuenta->id] = [
                        'origen'     => null,
                        '1000y3000'  => 0,
                        'otrosMov'   => 0,
                        'saldo'      => null,
                    ];
                }
            }

            $datos[] = $row;
        }

        return view('reportes.banco.index', compact('datos', 'todasCuentas'));
    }
}
