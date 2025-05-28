@extends('adminlte::page')

@section('title', 'Registrar Ministración')

@section('content_header')
    <h1>Registro de una Nueva Ministración</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Llene los Datos de la Ministración</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('ministraciones.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Fecha -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" name="fecha" id="fecha"
                                           class="form-control @error('fecha') is-invalid @enderror"
                                           value="{{ old('fecha') }}" required>
                                    @error('fecha')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fondo -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fondo_id">Fondo</label>
                                    <select name="fondo_id" id="fondo_id"
                                            class="form-control @error('fondo_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un fondo</option>
                                        @foreach ($fondos as $fondo)
                                            <option value="{{ $fondo->id }}" {{ old('fondo_id') == $fondo->id ? 'selected' : '' }}>
                                                {{ $fondo->nombre }}
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

                            <!-- Cuenta Bancaria -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cuenta_bancaria_id">Cuenta Bancaria</label>
                                    <select name="cuenta_bancaria_id" id="cuenta_bancaria_id"
                                            class="form-control @error('cuenta_bancaria_id') is-invalid @enderror" required>
                                        <option value="">Seleccione una cuenta</option>
                                    </select>

                                    @error('cuenta_bancaria_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Unidad Responsable -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unidad_responsable_id">Unidad Responsable</label>
                                    <select name="unidad_responsable_id" id="unidad_responsable_id"
                                            class="form-control @error('unidad_responsable_id') is-invalid @enderror" required>
                                        <option value="">Seleccione una unidad</option>
                                        @foreach ($unidades as $unidad)
                                            <option value="{{ $unidad->id }}" {{ old('unidad_responsable_id') == $unidad->id ? 'selected' : '' }}>
                                                {{ $unidad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unidad_responsable_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Capítulo -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="capitulo_id">Capítulo</label>
                                    <select id="capitulo_id" class="form-control">
                                        <option value="">Seleccione un capítulo</option>
                                        @foreach ($capitulos as $capitulo)
                                            <option value="{{ $capitulo->id }}">{{ $capitulo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <!-- Partida -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="partida_id">Partida</label>
                                    <select name="partida_id" id="partida_id"
                                            class="form-control @error('partida_id') is-invalid @enderror">
                                        <option value="">Seleccione una partida (opcional)</option>
                                        @foreach ($partidas as $partida)
                                            <option value="{{ $partida->id }}" {{ old('partida_id') == $partida->id ? 'selected' : '' }}>
                                                {{ $partida->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('partida_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Importe -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="importe">Importe</label>
                                    <input type="number" step="0.01" name="importe" id="importe"
                                           class="form-control @error('importe') is-invalid @enderror"
                                           value="{{ old('importe') }}" placeholder="0.00" required>
                                    @error('importe')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tipo de Gasto -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_gasto">Tipo de Gasto</label>
                                    <input type="text" name="tipo_gasto" id="tipo_gasto"
                                           class="form-control @error('tipo_gasto') is-invalid @enderror"
                                           value="{{ old('tipo_gasto') }}" placeholder="Opcional">
                                    @error('tipo_gasto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Descripción -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea name="descripcion" id="descripcion"
                                              class="form-control @error('descripcion') is-invalid @enderror"
                                              rows="3">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Campos adicionales opcionales -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="periodo">Periodo</label>
                                    <input type="text" name="periodo" id="periodo"
                                           class="form-control" value="{{ old('periodo') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <input type="text" name="observaciones" id="observaciones"
                                           class="form-control" value="{{ old('observaciones') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Referencias -->
                        <div class="row">
                            @php
                                $referencias = [
                                    'referencia_gasto' => 'Referencia Gasto',
                                    'referencia_desc_gasto' => 'Descripción Ref. Gasto',
                                    'ref_fondo' => 'Referencia Fondo',
                                    'ref_partida' => 'Referencia Partida',
                                    'ref_ur' => 'Referencia Unidad Responsable',
                                    'ref_part' => 'Referencia Part'
                                ];
                            @endphp

                            @foreach ($referencias as $campo => $etiqueta)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{ $campo }}">{{ $etiqueta }}</label>
                                        <input type="text" name="{{ $campo }}" id="{{ $campo }}"
                                               class="form-control" value="{{ old($campo) }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Cuentas adicionales -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cuenta_bancaria_origen">Cuenta Bancaria Origen</label>
                                    <input type="text" name="cuenta_bancaria_origen" id="cuenta_bancaria_origen"
                                           class="form-control" value="{{ old('cuenta_bancaria_origen') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cuenta_aplicacion">Cuenta Aplicación</label>
                                    <input type="text" name="cuenta_aplicacion" id="cuenta_aplicacion"
                                           class="form-control" value="{{ old('cuenta_aplicacion') }}">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Registrar
                            </button>
                            <a href="{{ route('ministraciones.index') }}" class="btn btn-secondary">
                                <i class="fas fa-ban"></i> Cancelar
                            </a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Al seleccionar un fondo, cargar cuentas bancarias
            document.getElementById('fondo_id').addEventListener('change', function () {
                const fondoId = this.value;
                const cuentaSelect = document.getElementById('cuenta_bancaria_id');
                cuentaSelect.innerHTML = '<option value="">Cargando...</option>';

                fetch(`{{ url('/cuentas/fondo') }}/${fondoId}`)
                    .then(response => response.json())
                    .then(data => {
                        cuentaSelect.innerHTML = '<option value="">Seleccione una cuenta</option>';
                        data.forEach(cuenta => {
                            cuentaSelect.innerHTML += `<option value="${cuenta.id}">${cuenta.nombre} (${cuenta.numero})</option>`;
                        });
                    });
            });

            // Al seleccionar un capítulo, cargar partidas
            document.getElementById('capitulo_id').addEventListener('change', function () {
                const capituloId = this.value;
                const partidaSelect = document.getElementById('partida_id');
                partidaSelect.innerHTML = '<option value="">Cargando...</option>';

                fetch(`{{ url('/partidas/capitulo') }}/${capituloId}`)
                    .then(response => response.json())
                    .then(data => {
                        partidaSelect.innerHTML = '<option value="">Seleccione una partida</option>';
                        data.forEach(partida => {
                            partidaSelect.innerHTML += `<option value="${partida.id}">${partida.nombre}</option>`;
                        });
                    });
            });
        });
    </script>

@stop
