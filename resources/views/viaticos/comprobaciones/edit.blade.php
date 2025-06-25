@extends('adminlte::page')

@section('title', 'Editar Comprobación')

@section('content_header')
    <h1>Editar Comprobación del Viático #{{ $viatico->id }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Modifique los Datos de la Comprobación</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('comprobaciones.update', [$viatico->id, $comprobacion->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row comprobacion-item mb-3">
                            <div class="col-md-3">
                                <label>Cuenta Contable</label>
                                <input type="text" name="cuenta_contable" class="form-control" value="{{ $comprobacion->cuenta_contable }}" readonly disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Descripción</label>
                                <input type="text" name="descripcion" class="form-control" value="{{ $comprobacion->descripcion }}">
                            </div>
                            <div class="col-md-3">
                                <label>Monto</label>
                                <input type="number" step="0.01" name="monto" class="form-control" value="{{ $comprobacion->monto }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Tipo</label>
                                <select name="tipo" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <option value="GASTO" {{ $comprobacion->tipo == 'GASTO' ? 'selected' : '' }}>GASTO</option>
                                    <option value="REINTEGRO" {{ $comprobacion->tipo == 'REINTEGRO' ? 'selected' : '' }}>REINTEGRO</option>
                                    <option value="ADICIONAL" {{ $comprobacion->tipo == 'ADICIONAL' ? 'selected' : '' }}>ADICIONAL</option>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Actualizar Comprobación
                            </button>
                            <a href="{{ route('comprobaciones.index', $viatico->id) }}" class="btn btn-secondary">
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
@stop
