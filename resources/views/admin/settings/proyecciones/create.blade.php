@extends('adminlte::page')

@section('title', 'Nueva Proyección')

@section('content_header')
    <h1>Registrar Proyección Presupuestal</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Llene los Datos</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('proyecciones.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Cuenta Bancaria -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cuenta_bancaria_id">Cuenta Bancaria</label>
                                <select name="cuenta_bancaria_id" id="cuenta_bancaria_id" 
                                        class="form-control @error('cuenta_bancaria_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Seleccione una cuenta</option>
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

                        <!-- Mes -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="month">Mes</label>
                                <select name="month" id="month" 
                                        class="form-control @error('month') is-invalid @enderror" required>
                                    <option value="" disabled selected>Seleccione un mes</option>
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>
                                            {{ ucfirst(\Carbon\Carbon::create()->month($m)->locale('es')->monthName) }}
                                        </option>
                                    @endfor
                                </select>
                                @error('month')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Año -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="year">Año</label>
                                <input type="number" name="year" id="year" min="2020" max="2100"
                                       value="{{ old('year', date('Y')) }}"
                                       class="form-control @error('year') is-invalid @enderror" required>
                                @error('year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Monto -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="monto">Monto Proyectado</label>
                                <input type="number" name="monto" id="monto" step="0.01" min="0"
                                       value="{{ old('monto') }}"
                                       class="form-control @error('monto') is-invalid @enderror" required>
                                @error('monto')
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
                                <a href="{{ route('proyecciones.index') }}" class="btn btn-secondary">
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
        @if (session('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Error en el formulario',
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
