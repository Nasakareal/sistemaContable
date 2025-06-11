@extends('adminlte::page')

@section('title', 'Análisis de Ingresos vs Gastos')

@section('content_header')
    <h1>{{ $titulo }}</h1>
@stop

@section('content')

<div class="card card-outline card-primary mb-4">
    <div class="card-body">
        <h5><strong>Análisis de los Ingresos Vs Gastos</strong></h5>

        <table class="table table-bordered table-sm text-center">
            <thead class="thead-light align-middle">
                <tr>
                    <th rowspan="2">Concepto</th>
                    <th rowspan="2">Importe Primer Cuatrimestre</th>
                    <th rowspan="2">Rendimientos Generados</th>
                    <th rowspan="2">Total</th>
                    <th rowspan="2">Número de cuenta donde se concentra el recurso</th>
                    <th colspan="6">PROGRAMA DEL DESTINO DE LOS RECURSOS</th>
                </tr>
                <tr>
                    <th>Capítulo 1000</th>
                    <th>Capítulo 2000</th>
                    <th>Capítulo 3000</th>
                    <th>Capítulo 4000</th>
                    <th>Capítulo 5000</th>
                    <th>Otro capítulo de gasto</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $concepto = 'SERVICIOS DE LA UTM';
                    $capitulos = [1000, 2000, 3000, 4000, 5000];
                    $capitulos_total = array_fill_keys($capitulos, 0);
                    $otro_capitulo_total = 0;
                    $importe_total = 0;
                    $cuenta = 'BBVA - 01214395865';

                    foreach ($ministraciones as $m) {
                        $importe_total += $m->importe;
                        $cap = (int) preg_replace('/\D/', '', $m->tipo_gasto);
                        if (in_array($cap, $capitulos)) {
                            $capitulos_total[$cap] += $m->importe;
                        } else {
                            $otro_capitulo_total += $m->importe;
                        }
                    }

                    $gran_total = $importe_total + $rendimientos;
                    $cap_sum = array_sum($capitulos_total);
                @endphp

                <tr>
                    <td>{{ $concepto }}</td>
                    <td>${{ number_format($importe_total, 2) }}</td>
                    <td>${{ number_format($rendimientos, 2) }}</td>
                    <td>${{ number_format($gran_total, 2) }}</td>
                    <td>{{ $cuenta }}</td>
                    @foreach ($capitulos as $cap)
                        <td>${{ number_format($capitulos_total[$cap], 2) }}</td>
                    @endforeach
                    <td>${{ number_format($otro_capitulo_total, 2) }}</td>
                </tr>

                <tr class="table-active font-weight-bold">
                    <td>TOTAL</td>
                    <td>${{ number_format($importe_total, 2) }}</td>
                    <td>${{ number_format($rendimientos, 2) }}</td>
                    <td>${{ number_format($gran_total, 2) }}</td>
                    <td></td>
                    @foreach ($capitulos as $cap)
                        <td>${{ number_format($capitulos_total[$cap], 2) }}</td>
                    @endforeach
                    <td>${{ number_format($otro_capitulo_total, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Gráfico --}}
<div class="card">
    <div class="card-body">
        <canvas id="graficaIngresosEgresos" height="120"></canvas>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficaIngresosEgresos').getContext('2d');

    const datos = {
        labels: {!! json_encode(array_column($datos, 'mes')) !!},
        datasets: [
            {
                label: 'Ingresos (Ministraciones)',
                data: {!! json_encode(array_column($datos, 'solo_ministraciones')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Egresos (Requisiciones)',
                data: {!! json_encode(array_column($datos, 'solo_requisiciones')) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }
        ]
    };

    const config = {
        type: 'bar',
        data: datos,
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'Comparativo de Ingresos vs Egresos Mensual'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    new Chart(ctx, config);
</script>
@stop


@section('css')
    <style>
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        /* Fondo oscuro para toda la tabla y elementos relacionados */
        table.dataTable,
        .table,
        .table-bordered,
        .table-striped,
        .table-hover {
            background-color: #1f2937 !important;
            color: white !important;
        }

        table.dataTable thead {
            background-color: #374151 !important;
            color: white !important;
        }

        table.dataTable tbody tr:nth-child(even) {
            background-color: #111827 !important;
        }

        table.dataTable td,
        table.dataTable th {
            border-color: #4b5563 !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: white !important;
        }

        select.form-control,
        input.form-control,
        .form-select {
            background-color: #1f2937 !important;
            color: white !important;
            border: 1px solid #4b5563;
        }

        .btn-primary {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
        }

        .btn {
            color: white !important;
        }

        /* Arreglar fondo de tarjetas */
        .card {
            background-color: #1f2937 !important;
            color: white;
        }

        .card-header {
            background-color: #374151 !important;
            color: white;
        }

        /* Botones de exportar DataTables */
        .dataTables_wrapper .dt-buttons .btn {
            background-color: #2563eb !important;
            color: white !important;
            border: none;
        }

        /* MENÚ de Opciones (dropdown de botones DataTables) */
        .dt-button-collection {
            background-color: #1f2937 !important;
            color: white !important;
            border: 1px solid #4b5563 !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .dt-button-collection .dt-button {
            background-color: #374151 !important;
            color: white !important;
            border: none;
        }

        .dt-button-collection .dt-button:hover {
            background-color: #2563eb !important;
            color: white !important;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@stop
