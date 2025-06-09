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

class MensualExport implements Responsable
{
    private $fileName = 'comparativo_mensual.xlsx';
    private $datos;

    public function __construct(array $datos)
    {
        $this->datos = $datos;
    }

    public function toResponse($request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Resumen');

        // Nuevos encabezados: Proyectado, Ingresos, Egresos
        $headers = ['Mes', 'Proyectado', 'Ingresos (Ministrado)', 'Egresos (Requisitado)', 'Diferencia (Proy. - Ingresos)'];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        foreach ($this->datos as $fila) {
            $sheet->setCellValue("A{$row}", $fila['mes']);
            $sheet->setCellValue("B{$row}", $fila['proyectado']);
            $sheet->setCellValue("C{$row}", $fila['ministrado']);  // Ingresos
            $sheet->setCellValue("D{$row}", $fila['recaudado']);   // Egresos
            $sheet->setCellValue("E{$row}", $fila['proyectado'] - $fila['ministrado']);
            $row++;
        }

        $highestRow = $row - 1;

        // Crear gráfico con nombres reales
        $categories = [new DataSeriesValues('String', "Resumen!A2:A{$highestRow}", null, $highestRow)];

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_CLUSTERED,
            range(0, 2),
            [
                new DataSeriesValues('String', 'Resumen!$B$1', null, 1), // Proyectado
                new DataSeriesValues('String', 'Resumen!$C$1', null, 1), // Ingresos
                new DataSeriesValues('String', 'Resumen!$D$1', null, 1), // Egresos
            ],
            $categories,
            [
                new DataSeriesValues('Number', "Resumen!B2:B{$highestRow}", null, $highestRow),
                new DataSeriesValues('Number', "Resumen!C2:C{$highestRow}", null, $highestRow),
                new DataSeriesValues('Number', "Resumen!D2:D{$highestRow}", null, $highestRow),
            ]
        );
        $series->setPlotDirection(DataSeries::DIRECTION_COL);

        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend(Legend::POSITION_RIGHT, null, false);
        $title = new Title('Comparativo Mensual');

        $chart = new Chart('grafico_comparativo', $title, $legend, $plotArea);
        $chart->setTopLeftPosition('G2');
        $chart->setBottomRightPosition('N20');
        $sheet->addChart($chart);

        $writer = new Xlsx($spreadsheet);
        $writer->setIncludeCharts(true);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $this->fileName);
    }
}
