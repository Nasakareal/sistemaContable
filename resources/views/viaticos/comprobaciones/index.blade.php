@extends('adminlte::page')

@section('title', 'Comprobaciones del Viático')

@section('content_header')
    <h1>Comprobaciones del Viático #{{ $viatico->id }}</h1>
@stop

@section('content')
    <div class="mb-3">
        <a href="{{ route('viaticos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a Viáticos
        </a>
        <a href="{{ route('comprobaciones.create', $viatico->id) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Añadir Comprobación
        </a>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Comprobaciones registradas</h3>
        </div>

        <div class="card-body">
            @if ($comprobaciones->isEmpty())
                <p>No hay comprobaciones registradas para este viático.</p>
            @else
                <table class="table table-bordered table-striped table-sm" id="comprobaciones-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cuenta contable</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comprobaciones as $index => $comp)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $comp->cuenta_contable }}</td>
                                <td>{{ $comp->descripcion }}</td>
                                <td>${{ number_format($comp->monto, 2) }}</td>
                                <td>
                                    <span class="badge 
                                        @switch($comp->tipo)
                                            @case('GASTO') bg-success @break
                                            @case('ADICIONAL') bg-warning @break
                                            @case('REINTEGRO') bg-info @break
                                            @default bg-secondary
                                        @endswitch
                                    ">
                                        {{ $comp->tipo }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('comprobaciones.show', [$viatico->id, $comp->id]) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('comprobaciones.edit', [$viatico->id, $comp->id]) }}" class="btn btn-sm btn-success">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('comprobaciones.destroy', [$viatico->id, $comp->id]) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger delete-btn" type="submit">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
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
    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: '¿Eliminar comprobación?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@stop
