@extends('adminlte::page')

@section('title', 'Comparativo Mensual')

@section('content_header')
    <h1>{{ $titulo }}</h1>
@stop

@section('content')

{{-- Filtro de mes --}}
<form method="GET" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <label for="mes">Filtrar por mes:</label>
            <select name="mes" id="mes" class="form-control" onchange="this.form.submit()">
                <option value="">-- Ver todos --</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>
                        {{ ucfirst(\Carbon\Carbon::create()->month($i)->locale('es')->monthName) }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <a href="{{ route('estadisticas.descargar', ['tipo' => 'mensual', 'mes' => request('mes')]) }}"
               class="btn btn-success">
                <i class="fas fa-file-excel"></i> Exportar a Excel
            </a>
        </div>
    </div>
</form>

{{-- Tabla resumen tipo informe UTM --}}
<div class="card card-outline card-primary mb-4">
    <div class="card-body">
        <table class="table table-bordered table-sm">
            <thead class="thead-dark text-center">
                <tr>
                    <th>Mes</th>
                    <th>Proyectado</th>
                    <th>Ministrado</th>
                    <th>Requisicionado</th>
                    <th>Diferencia (Proy. - Minis.)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $fila)
                    <tr class="text-center">
                        <td>{{ $fila['mes'] }}</td>
                        <td>${{ number_format($fila['proyectado'], 2) }}</td>
                        <td>${{ number_format($fila['ministrado'], 2) }}</td>
                        <td>${{ number_format($fila['recaudado'], 2) }}</td>
                        <td>
                            ${{ number_format($fila['proyectado'] - $fila['ministrado'], 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Gráfico --}}
<div class="card">
    <div class="card-body">
        <canvas id="graficaMensual" height="120"></canvas>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficaMensual').getContext('2d');

    const datos = {
        labels: {!! json_encode(array_column($datos, 'mes')) !!},
        datasets: [
            {
                label: 'Proyectado',
                data: {!! json_encode(array_column($datos, 'proyectado')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Ministrado',
                data: {!! json_encode(array_column($datos, 'ministrado')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Requisicionado',
                data: {!! json_encode(array_column($datos, 'recaudado')) !!},
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
                    text: 'Ingresos Proyectados vs Ministrados vs Requisiciones'
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
