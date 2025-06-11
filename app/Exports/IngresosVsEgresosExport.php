<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Contracts\Support\Responsable;

class IngresosVsEgresosExport implements Responsable
{
    private $fileName = 'comparativo_ingresos_vs_egresos.xlsx';
    private $datos;
    private $ministraciones;
    private $rendimientos;

    public function __construct(array $datos, $ministraciones, $rendimientos)
    {
        $this->datos = $datos;
        $this->ministraciones = $ministraciones;
        $this->rendimientos = $rendimientos;
    }

    public function toResponse($request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Resumen');

        // ==== RESUMEN POR CAPÍTULOS DE GASTO ====
        $capitulos = [1000, 2000, 3000, 4000, 5000];
        $capitulos_total = array_fill_keys($capitulos, 0);
        $otro_capitulo_total = 0;
        $importe_total = 0;
        $cuenta = 'BBVA - 01214395865';

        foreach ($this->ministraciones as $m) {
            $importe_total += $m->importe;
            $cap = (int) preg_replace('/\D/', '', $m->tipo_gasto);
            if (in_array($cap, $capitulos)) {
                $capitulos_total[$cap] += $m->importe;
            } else {
                $otro_capitulo_total += $m->importe;
            }
        }

        $gran_total = $importe_total + $this->rendimientos;

        // ENCABEZADOS TABLA DE CAPÍTULOS
        $sheet->fromArray([
            'Concepto',
            'Importe Primer Cuatrimestre',
            'Rendimientos Generados',
            'Total',
            'Cuenta',
            'Capítulo 1000',
            'Capítulo 2000',
            'Capítulo 3000',
            'Capítulo 4000',
            'Capítulo 5000',
            'Otro capítulo'
        ], null, 'A1');

        // VALORES TABLA DE CAPÍTULOS
        $sheet->fromArray([
            'SERVICIOS DE LA UTM',
            $importe_total,
            $this->rendimientos,
            $gran_total,
            $cuenta,
            $capitulos_total[1000],
            $capitulos_total[2000],
            $capitulos_total[3000],
            $capitulos_total[4000],
            $capitulos_total[5000],
            $otro_capitulo_total
        ], null, 'A2');

        // ==== TABLA DE COMPARATIVO MENSUAL ====
        $headers = ['Mes', 'Proyectado', 'Ingresos (Ministrado)', 'Egresos (Requisitado)', 'Diferencia'];
        $sheet->fromArray($headers, null, 'A5');

        $row = 6;
        foreach ($this->datos as $fila) {
            $sheet->setCellValue("A{$row}", $fila['mes']);
            $sheet->setCellValue("B{$row}", $fila['proyectado']);
            $sheet->setCellValue("C{$row}", $fila['recaudado']);
            $sheet->setCellValue("D{$row}", $fila['egresado']);
            $sheet->setCellValue("E{$row}", $fila['diferencia']);
            $row++;
        }

        // ==== GRÁFICO DE COLUMNAS ====
        $highestRow = $row - 1;
        $categories = [new DataSeriesValues('String', "Resumen!A6:A{$highestRow}", null, $highestRow)];

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_CLUSTERED,
            range(0, 2),
            [
                new DataSeriesValues('String', 'Resumen!$B$5', null, 1),
                new DataSeriesValues('String', 'Resumen!$C$5', null, 1),
                new DataSeriesValues('String', 'Resumen!$D$5', null, 1),
            ],
            $categories,
            [
                new DataSeriesValues('Number', "Resumen!B6:B{$highestRow}", null, $highestRow),
                new DataSeriesValues('Number', "Resumen!C6:C{$highestRow}", null, $highestRow),
                new DataSeriesValues('Number', "Resumen!D6:D{$highestRow}", null, $highestRow),
            ]
        );
        $series->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend(Legend::POSITION_RIGHT, null, false);
        $title = new Title('Comparativo Ingresos vs Egresos');

        $chart = new Chart('grafico_comparativo', $title, $legend, $plotArea);
        $chart->setTopLeftPosition('G6');
        $chart->setBottomRightPosition('N25');
        $sheet->addChart($chart);

        $writer = new Xlsx($spreadsheet);
        $writer->setIncludeCharts(true);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $this->fileName);
    }
}
