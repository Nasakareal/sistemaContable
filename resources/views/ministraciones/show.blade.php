
@extends('adminlte::page')

@section('title', 'Detalle de Ministración')

@section('content_header')
    <h1>Detalle de la Ministración</h1>
@stop

@section('content')
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Información registrada</h3>
            <div class="card-tools">
                <a href="{{ route('ministraciones.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <a href="{{ route('ministraciones.edit', $ministracion->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Fecha</dt>
                <dd class="col-sm-9">{{ $ministracion->fecha }}</dd>

                <dt class="col-sm-3">Fondo</dt>
                <dd class="col-sm-9">{{ $ministracion->fondo->nombre ?? 'No disponible' }}</dd>

                <dt class="col-sm-3">Cuenta Bancaria</dt>
                <dd class="col-sm-9">{{ $ministracion->cuentaBancaria->nombre ?? 'No disponible' }} ({{ $ministracion->cuentaBancaria->numero ?? '---' }})</dd>

                <dt class="col-sm-3">Unidad Responsable</dt>
                <dd class="col-sm-9">{{ $ministracion->unidadResponsable->nombre ?? 'No disponible' }}</dd>

                <dt class="col-sm-3">Partida</dt>
                <dd class="col-sm-9">{{ $ministracion->partida->nombre ?? 'No asignada' }}</dd>

                <dt class="col-sm-3">Importe</dt>
                <dd class="col-sm-9">${{ number_format($ministracion->importe, 2) }}</dd>

                <dt class="col-sm-3">Tipo de Gasto</dt>
                <dd class="col-sm-9">{{ $ministracion->tipo_gasto ?? '---' }}</dd>

                <dt class="col-sm-3">Descripción</dt>
                <dd class="col-sm-9">{{ $ministracion->descripcion ?? '---' }}</dd>

                <dt class="col-sm-3">Periodo</dt>
                <dd class="col-sm-9">{{ $ministracion->periodo ?? '---' }}</dd>

                <dt class="col-sm-3">Observaciones</dt>
                <dd class="col-sm-9">{{ $ministracion->observaciones ?? '---' }}</dd>

                <!-- Referencias -->
                <dt class="col-sm-3">Referencia Gasto</dt>
                <dd class="col-sm-9">{{ $ministracion->referencia_gasto ?? '---' }}</dd>

                <dt class="col-sm-3">Descripción Ref. Gasto</dt>
                <dd class="col-sm-9">{{ $ministracion->referencia_desc_gasto ?? '---' }}</dd>

                <dt class="col-sm-3">Referencia Fondo</dt>
                <dd class="col-sm-9">{{ $ministracion->ref_fondo ?? '---' }}</dd>

                <dt class="col-sm-3">Referencia Partida</dt>
                <dd class="col-sm-9">{{ $ministracion->ref_partida ?? '---' }}</dd>

                <dt class="col-sm-3">Referencia Unidad Responsable</dt>
                <dd class="col-sm-9">{{ $ministracion->ref_ur ?? '---' }}</dd>

                <dt class="col-sm-3">Referencia Part</dt>
                <dd class="col-sm-9">{{ $ministracion->ref_part ?? '---' }}</dd>

                <!-- Cuentas adicionales -->
                <dt class="col-sm-3">Cuenta Bancaria Origen</dt>
                <dd class="col-sm-9">{{ $ministracion->cuenta_bancaria_origen ?? '---' }}</dd>

                <dt class="col-sm-3">Cuenta Aplicación</dt>
                <dd class="col-sm-9">{{ $ministracion->cuenta_aplicacion ?? '---' }}</dd>
            </dl>
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
