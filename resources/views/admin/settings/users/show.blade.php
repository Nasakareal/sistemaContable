@extends('adminlte::page')

@section('title', 'Detalles del Usuario')

@section('content_header')
    <h1>Detalles del Usuario</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Datos Registrados</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Nombre y Correo --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <p class="form-control-static">{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <p class="form-control-static">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Área y Estado --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="area">Área</label>
                                <p class="form-control-static">{{ $user->area ?? 'No especificada' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <p class="form-control-static">{{ $user->estado }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Rol y Foto de Perfil --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Rol</label>
                                <p class="form-control-static">{{ $user->roles->pluck('name')->join(', ') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto_perfil">Foto de Perfil</label>
                                @if ($user->foto_perfil)
                                    <div>
                                        <img src="{{ asset('storage/' . $user->foto_perfil) }}" alt="Foto de Perfil" style="max-width: 150px; max-height: 150px;" class="img-thumbnail">
                                    </div>
                                @else
                                    <p class="form-control-static">No tiene foto de perfil.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        {{-- Botón de regreso --}}
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
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
    <script> console.log("Vista de detalles del usuario cargada correctamente."); </script>
@stop
