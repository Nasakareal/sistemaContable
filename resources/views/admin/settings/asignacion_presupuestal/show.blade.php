@extends('adminlte::page')

@section('title', 'Detalle de Asignación Presupuestal')

@section('content_header')
    <h1>Detalle de Asignación Presupuestal</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Información detallada</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Fondo -->
                        <div class="col-md-4">
                            <strong>Fondo:</strong>
                            <p>{{ $asignacion->fondo->clave }} - {{ $asignacion->fondo->nombre }}</p>
                        </div>

                        <!-- Cuenta Bancaria -->
                        <div class="col-md-4">
                            <strong>Cuenta Bancaria:</strong>
                            <p>{{ $asignacion->cuentaBancaria->numero }} - {{ $asignacion->cuentaBancaria->nombre }}</p>
                        </div>

                        <!-- Unidad Responsable -->
                        <div class="col-md-4">
                            <strong>Unidad Responsable:</strong>
                            <p>{{ $asignacion->unidadResponsable->clave }} - {{ $asignacion->unidadResponsable->nombre }}</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <!-- Partida -->
                        <div class="col-md-4">
                            <strong>Partida:</strong>
                            <p>{{ $asignacion->partida->nombre }} - {{ $asignacion->partida->descripcion }}</p>
                        </div>

                        <!-- Monto -->
                        <div class="col-md-4">
                            <strong>Monto:</strong>
                            <p>${{ number_format($asignacion->monto, 2) }}</p>
                        </div>

                        <!-- Periodo -->
                        <div class="col-md-4">
                            <strong>Periodo:</strong>
                            <p>{{ $asignacion->periodo }}</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <!-- Justificación -->
                        <div class="col-md-12">
                            <strong>Justificación:</strong>
                            <p>{{ $asignacion->justificacion ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('asignacion_presupuestal.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Regresar al listado
                    </a>
                </div>
            </div>
        </div>
    </div>
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
