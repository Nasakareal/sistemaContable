@extends('adminlte::page')

@section('title', 'Detalle de la Solicitud de Devolución')

@section('content_header')
    <h1>Detalle de la Solicitud</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Información General</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <!-- Código -->
                        <dt class="col-sm-3">Código</dt>
                        <dd class="col-sm-9">{{ $solicitudDev->codigo ?? 'N/A' }}</dd>

                        <!-- Descripción -->
                        <dt class="col-sm-3">Descripción</dt>
                        <dd class="col-sm-9">{{ $solicitudDev->descripcion ?? 'Sin descripción' }}</dd>

                        <!-- Documento Origen -->
                        <dt class="col-sm-3">Documento Origen</dt>
                        <dd class="col-sm-9">{{ $solicitudDev->documento_origen ?? 'N/A' }}</dd>

                        <!-- Fecha de creación -->
                        <dt class="col-sm-3">Creado el</dt>
                        <dd class="col-sm-9">{{ $solicitudDev->created_at->format('d/m/Y H:i') }}</dd>

                        <!-- Última actualización -->
                        <dt class="col-sm-3">Última modificación</dt>
                        <dd class="col-sm-9">{{ $solicitudDev->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>

                    <div class="form-group mt-4">
                        <a href="{{ route('solicitudesDev.edit', $solicitudDev->id) }}" class="btn btn-success">
                            <i class="fa-solid fa-pencil"></i> Editar
                        </a>
                        <a href="{{ route('solicitudesDev.index') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left"></i> Volver al listado
                        </a>
                    </div>
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
