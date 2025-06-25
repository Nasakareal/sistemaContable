@extends('adminlte::page')

@section('title', 'Detalle de Comprobaciones')

@section('content_header')
    <h1>Comprobaciones del Viático #{{ $viatico->id }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Información General del Viático</h3>
            </div>

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <strong>Empleado:</strong>
                        <p>{{ $viatico->empleado->nombre ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Fecha Entrega:</strong>
                        <p>{{ \Carbon\Carbon::parse($viatico->fecha_entrega)->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Estatus:</strong>
                        <p>{{ $viatico->estatus }}</p>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4">
                        <strong>Fondo:</strong>
                        <p>{{ $viatico->fondo->nombre ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Cuenta Bancaria:</strong>
                        <p>{{ $viatico->cuentaBancaria->nombre ?? 'N/A' }} ({{ $viatico->cuentaBancaria->numero ?? '---' }})</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Importe Total:</strong>
                        <p>${{ number_format($viatico->importe_total, 2) }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <strong>Observaciones:</strong>
                    <p>{{ $viatico->observaciones ?: 'N/A' }}</p>
                </div>

                <hr>
                <h4>Comprobaciones Registradas</h4>

                @forelse ($viatico->comprobaciones as $comp)
                    <div class="border rounded p-3 mb-2">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Cuenta Contable:</strong>
                                <p>{{ $comp->cuenta_contable }}</p>
                            </div>
                            <div class="col-md-3">
                                <strong>Descripción:</strong>
                                <p>{{ $comp->descripcion ?: '---' }}</p>
                            </div>
                            <div class="col-md-3">
                                <strong>Monto:</strong>
                                <p>${{ number_format($comp->monto, 2) }}</p>
                            </div>
                            <div class="col-md-3">
                                <strong>Tipo:</strong>
                                <p>{{ $comp->tipo }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No se han registrado comprobaciones aún.</p>
                @endforelse

                <hr>
                <a href="{{ route('comprobaciones.index', $viatico->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Regresar
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
