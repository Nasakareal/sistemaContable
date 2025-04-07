@extends('adminlte::page')

@section('title', 'Editar Asignación Presupuestal')

@section('content_header')
    <h1>Editar Asignación Presupuestal</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Modifique los datos necesarios</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('asignacion_presupuestal.update', $asignacion->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Fondo -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fondo_id">Fondo</label>
                                    <select name="fondo_id" id="fondo_id" class="form-control" required>
                                        @foreach ($fondos as $fondo)
                                            <option value="{{ $fondo->id }}" {{ $fondo->id == $asignacion->fondo_id ? 'selected' : '' }}>
                                                {{ $fondo->clave }} - {{ $fondo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Cuenta Bancaria -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cuenta_bancaria_id">Cuenta Bancaria</label>
                                    <select name="cuenta_bancaria_id" id="cuenta_bancaria_id" class="form-control" required>
                                        @foreach ($cuentas as $cuenta)
                                            <option value="{{ $cuenta->id }}" {{ $cuenta->id == $asignacion->cuenta_bancaria_id ? 'selected' : '' }}>
                                                {{ $cuenta->numero }} - {{ $cuenta->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Unidad Responsable -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="unidad_responsable_id">Unidad Responsable</label>
                                    <select name="unidad_responsable_id" id="unidad_responsable_id" class="form-control" required>
                                        @foreach ($unidades as $unidad)
                                            <option value="{{ $unidad->id }}" {{ $unidad->id == $asignacion->unidad_responsable_id ? 'selected' : '' }}>
                                                {{ $unidad->clave }} - {{ $unidad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Partida -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="partida_id">Partida</label>
                                    <select name="partida_id" id="partida_id" class="form-control" required>
                                        @foreach ($partidas as $partida)
                                            <option value="{{ $partida->id }}" {{ $partida->id == $asignacion->partida_id ? 'selected' : '' }}>
                                                {{ $partida->nombre }} - {{ $partida->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Monto -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="monto">Monto</label>
                                    <input type="number" step="0.01" name="monto" id="monto" class="form-control"
                                           value="{{ old('monto', $asignacion->monto) }}" required>
                                </div>
                            </div>

                            <!-- Periodo -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="periodo">Periodo</label>
                                    <input type="month" name="periodo" id="periodo" class="form-control"
                                           value="{{ old('periodo', $asignacion->periodo) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Justificación -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="justificacion">Justificación</label>
                                    <textarea name="justificacion" id="justificacion" class="form-control" rows="3"
                                              placeholder="Explique brevemente la asignación">{{ old('justificacion', $asignacion->justificacion) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <!-- Botones -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-check"></i> Actualizar Asignación
                                </button>
                                <a href="{{ route('asignacion_presupuestal.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-ban"></i> Cancelar
                                </a>
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
