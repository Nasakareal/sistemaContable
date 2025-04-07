@extends('adminlte::page')

@section('title', 'Detalle del Fondo')

@section('content_header')
    <h1>Detalle del Fondo</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Información general del Fondo</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Clave:</dt>
                        <dd class="col-sm-8">{{ $fondo->clave }}</dd>

                        <dt class="col-sm-4">Nombre:</dt>
                        <dd class="col-sm-8">{{ $fondo->nombre ?? 'Sin nombre' }}</dd>

                        <dt class="col-sm-4">Descripción:</dt>
                        <dd class="col-sm-8">{{ $fondo->descripcion ?? 'Sin descripción' }}</dd>

                        <dt class="col-sm-4">Creado el:</dt>
                        <dd class="col-sm-8">{{ $fondo->created_at->format('d/m/Y H:i') }}</dd>

                        <dt class="col-sm-4">Última modificación:</dt>
                        <dd class="col-sm-8">{{ $fondo->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('fondos.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Volver al listado
                    </a>
                    <a href="{{ route('fondos.edit', $fondo->id) }}" class="btn btn-success">
                        <i class="fa-solid fa-pencil"></i> Editar
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
