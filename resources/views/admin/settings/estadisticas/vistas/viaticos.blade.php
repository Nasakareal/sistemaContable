@extends('adminlte::page')

@section('title', $titulo)

@section('content_header')
    <h1>{{ $titulo }}</h1>
@stop

@section('content')
    <table class="table table-bordered table-hover table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Empleado</th>
                <th>Fondo</th>
                <th>Cuenta Bancaria</th>
                <th>Importe</th>
                <th>Fecha</th>
                <th>Estatus</th>
                <th>Comprobaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viaticos as $via)
                <tr>
                    <td>{{ $via->empleado->nombre ?? 'N/A' }}</td>
                    <td>{{ $via->fondo->nombre ?? 'N/A' }}</td>
                    <td>{{ $via->cuentaBancaria->nombre ?? 'N/A' }}</td>
                    <td>${{ number_format($via->importe_total, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($via->fecha_entrega)->format('d/m/Y') }}</td>
                    <td>{{ $via->estatus }}</td>
                    <td>
                        @if ($via->comprobaciones->isEmpty())
                            <em>Sin comprobaciones</em>
                        @else
                            @foreach ($via->comprobaciones as $c)
                                <div class="border rounded p-1 mb-1 bg-light">
                                    <strong>{{ $c->tipo }}</strong> — ${{ number_format($c->monto, 2) }}<br>
                                    <small>{{ $c->descripcion ?? '---' }}</small><br>
                                    <span class="badge bg-secondary">{{ $c->cuenta_contable }}</span>
                                </div>
                            @endforeach
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
