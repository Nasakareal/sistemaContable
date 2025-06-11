@extends('adminlte::page')

@section('title', 'Detalle de Requisición')

@section('content_header')
    <h1>Detalle de Requisición</h1>
@stop

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-body">
            <table class="table table-bordered table-sm">
                <tbody>
                    <tr><th>ID</th><td>{{ $requisicion->id }}</td></tr>
                    <tr><th>Fecha de Requisición</th><td>{{ $requisicion->fecha_requisicion }}</td></tr>
                    <tr><th>Fecha de Oficio de Pago</th><td>{{ $requisicion->fecha_oficio_pago }}</td></tr>
                    <tr><th>Número de Requisición</th><td>{{ $requisicion->numero_requisicion }}</td></tr>
                    <tr><th>UR</th><td>{{ $requisicion->ur }}</td></tr>
                    <tr><th>Departamento</th><td>{{ $requisicion->departamento }}</td></tr>
                    <tr><th>Partida</th><td>{{ $requisicion->partida }}</td></tr>
                    <tr><th>Segunda Partida</th><td>{{ $requisicion->partida2 ?? 'N/A' }}</td></tr>

                    <tr><th>Producto o Material</th><td>{{ $requisicion->producto_material }}</td></tr>
                    <tr><th>Justificación</th><td>{{ $requisicion->justificacion }}</td></tr>
                    <tr><th>Oficio de Pago</th><td>{{ $requisicion->oficio_pago }}</td></tr>
                    <tr><th>Número de Factura</th><td>{{ $requisicion->numero_factura }}</td></tr>
                    <tr><th>Proveedor</th><td>{{ $requisicion->proveedor }}</td></tr>
                    <tr><th>Monto</th><td>${{ number_format($requisicion->monto, 2) }}</td></tr>
                    <tr><th>Status de Requisición</th><td>{{ $requisicion->status_requisicion }}</td></tr>
                    <tr><th>Turnado a</th><td>{{ $requisicion->turnado_a }}</td></tr>
                    <tr><th>Fecha de Entrega a RF</th><td>{{ $requisicion->fecha_entrega_rf }}</td></tr>
                    <tr><th>Fecha de Pago</th><td>{{ $requisicion->fecha_pago }}</td></tr>
                    <tr><th>Banco</th><td>{{ $requisicion->banco }}</td></tr>
                    <tr><th>Pago</th><td>${{ number_format($requisicion->pago ?? 0, 2) }}</td></tr>
                    <tr><th>Status de Pago</th><td>{{ $requisicion->status_pago }}</td></tr>
                    <tr><th>Observaciones</th><td>{{ $requisicion->observaciones }}</td></tr>
                    <tr><th>Referencia</th><td>{{ $requisicion->referencia }}</td></tr>
                    <tr><th>Mes</th><td>{{ $requisicion->mes }}</td></tr>
                    <tr><th>ID Cuenta Bancaria</th><td>{{ $requisicion->cuenta_bancaria_id }}</td></tr>
                    <tr><th>Creado el</th><td>{{ $requisicion->created_at }}</td></tr>
                    <tr><th>Actualizado el</th><td>{{ $requisicion->updated_at }}</td></tr>
                </tbody>
            </table>

            <a href="{{ route('movimientos.index') }}" class="btn btn-secondary mt-3">
                <i class="fa fa-arrow-left"></i> Volver al listado
            </a>

           <form action="{{ route('movimientos.bloquear', $requisicion->id) }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn {{ $requisicion->bloqueada ? 'btn-success' : 'btn-danger' }}">
                    <i class="fas {{ $requisicion->bloqueada ? 'fa-unlock' : 'fa-lock' }}"></i>
                    {{ $requisicion->bloqueada ? 'Desbloquear requisición' : 'Marcar como revisada y bloquear en sistemaInventarios' }}
                </button>
            </form>

            <form action="{{ route('movimientos.alertar', $requisicion->id) }}" method="POST" class="mt-3">
                @csrf
                <div class="form-group">
                    <label for="mensaje" class="fw-bold">Mensaje de alerta <span class="text-danger">*</span></label>
                    <textarea name="mensaje" id="mensaje" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-warning mt-2">
                    <i class="fas fa-bell"></i> Enviar alerta a sistemaInventarios
                </button>
            </form>

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

