@extends('adminlte::page')

@section('title', 'Registrar Viático')

@section('content_header')
    <h1>Registro de un Nuevo Viático</h1>
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

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Llene los Datos del Viático</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('viaticos.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Empleado -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="empleado_id">Empleado</label>
                                    <select name="empleado_id" id="empleado_id"
                                            class="form-control @error('empleado_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un empleado</option>
                                        @foreach ($empleados as $empleado)
                                            <option value="{{ $empleado->id }}" {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
                                                {{ $empleado->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('empleado_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_entrega">Fecha de Entrega</label>
                                    <input type="date" name="fecha_entrega" id="fecha_entrega"
                                           class="form-control @error('fecha_entrega') is-invalid @enderror"
                                           value="{{ old('fecha_entrega') }}" required>
                                    @error('fecha_entrega')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Fondo -->
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cuenta_bancaria_id">Cuenta Bancaria</label>
                                    <select name="cuenta_bancaria_id" id="cuenta_bancaria_id"
                                            class="form-control @error('cuenta_bancaria_id') is-invalid @enderror" required>
                                        <option value="">Seleccione una cuenta</option>
                                        @foreach ($cuentas as $cuenta)
                                            <option value="{{ $cuenta->id }}" {{ old('cuenta_bancaria_id') == $cuenta->id ? 'selected' : '' }}>
                                                {{ $cuenta->nombre }} ({{ $cuenta->numero }})
                                            </option>
                                        @endforeach
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
                            <!-- Importe -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="importe_total">Importe Total</label>
                                    <input type="number" step="0.01" name="importe_total" id="importe_total"
                                           class="form-control @error('importe_total') is-invalid @enderror"
                                           value="{{ old('importe_total') }}" placeholder="0.00" required>
                                    @error('importe_total')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Estatus -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estatus">Estatus</label>
                                    <select name="estatus" id="estatus"
                                            class="form-control @error('estatus') is-invalid @enderror" required>
                                        <option value="">Seleccione un estatus</option>
                                        @foreach (['PENDIENTE', 'COMPROBADO', 'PARCIAL', 'CANCELADO'] as $estado)
                                            <option value="{{ $estado }}" {{ old('estatus') == $estado ? 'selected' : '' }}>
                                                {{ $estado }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('estatus')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                         <!-- Partidas -->
                        <div class="row">
                            <!-- Capítulo -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="capitulo_id">Capítulo</label>
                                    <select id="capitulo_id" class="form-control" required>
                                        <option value="">Seleccione un capítulo</option>
                                        @foreach ($capitulos as $capitulo)
                                            <option value="{{ $capitulo->id }}">{{ $capitulo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Partida 1 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Partida 1</label>
                                    <select name="partidas[0][id]" class="form-control partida-select" required></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Monto</label>
                                    <input type="number" name="partidas[0][monto]" class="form-control" step="0.01" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Partida 2 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Partida 2</label>
                                    <select name="partidas[1][id]" class="form-control partida-select"></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Monto</label>
                                    <input type="number" name="partidas[1][monto]" class="form-control" step="0.01">
                                </div>
                            </div>
                        </div>



                        <!-- Observaciones -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones"
                                              class="form-control @error('observaciones') is-invalid @enderror"
                                              rows="3">{{ old('observaciones') }}</textarea>
                                    @error('observaciones')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Registrar Viático
                            </button>
                            <a href="{{ route('viaticos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-ban"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
        const capituloSelect = document.getElementById('capitulo_id');
        const partidaSelects = document.querySelectorAll('.partida-select');

        capituloSelect.addEventListener('change', function () {
            const capituloId = this.value;

            partidaSelects.forEach(select => {
                select.innerHTML = '<option value="">Cargando partidas...</option>';
            });

            fetch("{{ url('/partidas/capitulo') }}/" + capituloId)
                .then(response => response.json())
                .then(data => {
                    partidaSelects.forEach(select => {
                        select.innerHTML = '<option value="">Seleccione una partida</option>';
                        data.forEach(p => {
                            const option = document.createElement('option');
                            option.value = p.id;
                            option.textContent = `${p.nombre} - ${p.descripcion}`;
                            select.appendChild(option);
                        });
                    });
                });
        });
    });
</script>
@stop

