@extends('adminlte::page')

@section('title', 'Gestionar Permisos')

@section('content_header')
    <h1>Gestionar Permisos para el Rol: {{ $role->name }}</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Asignar Permisos</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.assignPermissions', $role->id) }}" method="POST">
                        @csrf
                        <table class="table table-striped table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th><center>Número</center></th>
                                    <th><center>Descripción del Permiso</center></th>
                                    <th><center>Asignar</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $index => $permission)
                                    <tr>
                                        <td style="text-align: center">{{ $index + 1 }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td style="text-align: center">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group mt-3 text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-check"></i> Guardar Permisos
                            </button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                                <i class="fa-solid fa-ban"></i> Cancelar
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
