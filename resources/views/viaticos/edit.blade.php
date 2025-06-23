@extends('adminlte::page')

@section('title', 'Editar Viático')

@section('content_header')
    <h1>Editar Viático</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Modificar datos del viático</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('viaticos.update', $viatico->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Empleado -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="empleado_id">Empleado</label>
                                <select name="empleado_id" class="form-control" required>
                                    <option value="">Seleccione un empleado</option>
                                    @foreach ($empleados as $empleado)
                                        <option value="{{ $empleado->id }}"
                                            {{ old('empleado_id', $viatico->empleado_id) == $empleado->id ? 'selected' : '' }}>
                                            {{ $empleado->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_entrega">Fecha de Entrega</label>
                                <input type="date" name="fecha_entrega" class="form-control"
                                    value="{{ old('fecha_entrega', $viatico->fecha_entrega) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Fondo -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fondo_id">Fondo</label>
                                <select name="fondo_id" class="form-control" required>
                                    <option value="">Seleccione un fondo</option>
                                    @foreach ($fondos as $fondo)
                                        <option value="{{ $fondo->id }}"
                                            {{ old('fondo_id', $viatico->fondo_id) == $fondo->id ? 'selected' : '' }}>
                                            {{ $fondo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Cuenta -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cuenta_bancaria_id">Cuenta Bancaria</label>
                                <select name="cuenta_bancaria_id" class="form-control" required>
                                    <option value="">Seleccione una cuenta</option>
                                    @foreach ($cuentas as $cuenta)
                                        <option value="{{ $cuenta->id }}"
                                            {{ old('cuenta_bancaria_id', $viatico->cuenta_bancaria_id) == $cuenta->id ? 'selected' : '' }}>
                                            {{ $cuenta->nombre }} ({{ $cuenta->numero }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Importe -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="importe_total">Importe Total</label>
                                <input type="number" step="0.01" name="importe_total" class="form-control"
                                    value="{{ old('importe_total', $viatico->importe_total) }}" required>
                            </div>
                        </div>

                        <!-- Estatus -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estatus">Estatus</label>
                                <select name="estatus" class="form-control" required>
                                    @foreach (['PENDIENTE', 'COMPROBADO', 'PARCIAL', 'CANCELADO'] as $estado)
                                        <option value="{{ $estado }}"
                                            {{ old('estatus', $viatico->estatus) == $estado ? 'selected' : '' }}>
                                            {{ $estado }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Capítulo -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="capitulo_id">Capítulo</label>
                                <select id="capitulo_id" name="capitulo_id" class="form-control" required>
                                    <option value="">Seleccione un capítulo</option>
                                    @foreach ($capitulos as $capitulo)
                                        <option value="{{ $capitulo->id }}"
                                            {{ $capituloSeleccionado == $capitulo->id ? 'selected' : '' }}>
                                            {{ $capitulo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Partidas -->
                    @php
                        $oldPartidas = old('partidas', $viatico->partidas->map(function ($partida) {
                            return ['id' => $partida->id, 'monto' => $partida->pivot->monto];
                        })->toArray());
                    @endphp

                    @for ($i = 0; $i < 2; $i++)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Partida {{ $i + 1 }}</label>
                                    <select name="partidas[{{ $i }}][id]" class="form-control partida-select">
                                        <option value="">Seleccione una partida</option>
                                        @foreach ($partidas as $p)
                                            <option value="{{ $p->id }}"
                                                {{ isset($oldPartidas[$i]['id']) && $oldPartidas[$i]['id'] == $p->id ? 'selected' : '' }}>
                                                {{ $p->nombre }} - {{ $p->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Monto</label>
                                    <input type="number" name="partidas[{{ $i }}][monto]" step="0.01" class="form-control"
                                           value="{{ $oldPartidas[$i]['monto'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    @endfor



                    <!-- Observaciones -->
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones', $viatico->observaciones) }}</textarea>
                    </div>

                    <hr>

                    

                    <hr>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Viático
                    </button>
                    <a href="{{ route('viaticos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-ban"></i> Cancelar
                    </a>
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

