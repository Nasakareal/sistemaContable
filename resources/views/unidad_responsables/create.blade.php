@extends('adminlte::page')

@section('title', 'Crear Unidad Responsable')

@section('content_header')
    <h1>Creación de una Nueva Unidad Responsable</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Llene los Datos de la Unidad</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('unidad_responsables.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Clave -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="clave">Clave de la Unidad</label>
                                    <input type="text" name="clave" id="clave"
                                           class="form-control @error('clave') is-invalid @enderror"
                                           value="{{ old('clave') }}" placeholder="Ej: 1603053001053" required>
                                    @error('clave')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nombre -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre">Nombre de la Unidad</label>
                                    <input type="text" name="nombre" id="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre') }}" placeholder="Ej: Unidad de Recursos Humanos">
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fondo (select) -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fondo_id">Fondo Asignado</label>
                                    <select name="fondo_id" id="fondo_id"
                                            class="form-control @error('fondo_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un fondo</option>
                                        @foreach ($fondos as $fondo)
                                            <option value="{{ $fondo->id }}" {{ old('fondo_id') == $fondo->id ? 'selected' : '' }}>
                                                {{ $fondo->clave }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('fondo_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <input type="text" name="descripcion" id="descripcion"
                                           class="form-control @error('descripcion') is-invalid @enderror"
                                           value="{{ old('descripcion') }}" placeholder="Descripción opcional">
                                    @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-check"></i> Registrar
                                    </button>
                                    <a href="{{ route('unidad_responsables.index') }}" class="btn btn-secondary">
                                        <i class="fa-solid fa-ban"></i> Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>

                    </form>
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
    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Errores en el formulario',
                html: `
                    <ul style="text-align: left;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonText: 'Aceptar'
            });
        @endif
    </script>
@stop
