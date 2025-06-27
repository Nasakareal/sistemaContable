@extends('adminlte::page')

@section('title')

@section('content_header')
    <h1>Configuraciones del Sistema</h1>
@stop

@section('content')
    <div class="row">

        <!-- Usuarios -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="fa-solid fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Usuarios</b></span>
                    <a href="{{ url('/admin/settings/users') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Roles -->
         <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-navy"><i class="fa-regular fa-flag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Roles</b></span>
                    <a href="{{ url('/admin/settings/roles') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

         <!-- Cuentas Bancarias -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa-solid fa-university"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Cuentas Bancarias</b></span>
                    <a href="{{ url('/admin/settings/cuentas') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Estadisticas -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa-solid fa-chart-pie"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Estadisticas</b></span>
                    <a href="{{ url('/admin/settings/estadisticas') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Asignación Presupuestal -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-olive"><i class="fa-solid fa-money-bill"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Asignación Presupuestal</b></span>
                    <a href="{{ url('/admin/settings/asignacion_presupuestal') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Proyecciones Presupuestales -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-fuchsia"><i class="fa-solid fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Proyección Presupuestal</b></span>
                    <a href="{{ url('/admin/settings/proyecciones') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Registro de Actividad  -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-indigo"><i class="fa-solid fa-user-secret"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Registro de Actividad</b></span>
                    <a href="{{ url('/admin/settings/historial') }}" class="btn btn-primary btn-sm">Acceder</a>
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

        .info-box {
            background-color: #111827 !important;
            border: 1px solid #374151;
            color: white !important;
        }

        .info-box .info-box-content {
            color: white !important;
        }

        .info-box .btn {
            color: white !important;
            background-color: #2563eb !important;
            border: none;
        }

    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@stop

@section('js')
    <script> console.log("Configuraciones del Sistema cargadas."); </script>
@stop
