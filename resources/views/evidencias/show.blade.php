@extends('adminlte::page')

@section('title', 'Detalle de Evidencia')

@section('content_header')
    <h1>Detalle de Evidencia</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Información de la Evidencia</h3>
                </div>
                <div class="card-body">

                    <!-- Solicitud relacionada -->
                    <div class="mb-3">
                        <strong>Solicitud Relacionada:</strong>
                        <p>
                            @if ($evidencia->solicitudDev)
                                {{ $evidencia->solicitudDev->codigo }} - {{ $evidencia->solicitudDev->descripcion }}
                            @else
                                <span class="text-muted">Sin solicitud asignada</span>
                            @endif
                        </p>
                    </div>

                    <!-- Archivo -->
                    <div class="mb-3">
                        <strong>Archivo:</strong><br>
                        @if ($evidencia->ruta)
                            @php
                                $extension = pathinfo($evidencia->ruta, PATHINFO_EXTENSION);
                                $url = asset('storage/' . $evidencia->ruta);
                            @endphp

                            @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                <img src="{{ $url }}" alt="Evidencia" class="img-fluid rounded border" style="max-height: 400px;">
                            @elseif ($extension === 'pdf')
                                <embed src="{{ $url }}" type="application/pdf" width="100%" height="600px" />
                            @else
                                <a href="{{ $url }}" target="_blank" class="btn btn-outline-success">
                                    <i class="fa-solid fa-paperclip"></i> Ver archivo adjunto
                                </a>
                            @endif
                        @else
                            <p class="text-muted">Sin archivo cargado</p>
                        @endif
                    </div>

                    <!-- Botón Regresar -->
                    <div class="mt-4">
                        <a href="{{ route('evidencias.index') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left"></i> Regresar al listado
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

@section('js')
    @if (session('success'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
@stop
