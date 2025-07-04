@extends('adminlte::page')

@section('title', 'Listado de Viáticos')

@section('content_header')
    <h1>Listado de Viáticos</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Viáticos</h3>
                    <div class="card-tools">
                        <a href="{{ route('viaticos.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Añadir Viático
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table id="viaticos" class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th><center>#</center></th>
                                <th><center>Empleado</center></th>
                                <th><center>Solicita</center></th>
                                <th><center>Fecha</center></th>
                                <th><center>Fondo</center></th>
                                <th><center>Cuenta Bancaria</center></th>
                                <th><center>Importe</center></th>
                                <th><center>Estatus</center></th>
                                <th><center>Revisado</center></th>
                                <th><center>Acciones</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($viaticos as $index => $v)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        {{ optional($v->empleado)->nombre ?? '—' }}
                                    </td>
                                    <td>{{ $v->quien_solicita ?? '—' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($v->fecha_entrega)->format('d/m/Y') }}</td>
                                    <td>{{ $v->fondo->clave ?? '—' }}</td>
                                    <td>{{ $v->cuentaBancaria->numero ?? '—' }}</td>
                                    <td>${{ number_format($v->importe_total, 2) }}</td>
                                    <td>
                                        <span class="badge 
                                            @switch($v->estatus)
                                                @case('PENDIENTE') bg-warning @break
                                                @case('COMPROBADO') bg-success @break
                                                @case('PARCIAL') bg-info @break
                                                @case('CANCELADO') bg-danger @break
                                                @default bg-secondary
                                            @endswitch
                                        ">
                                            {{ $v->estatus }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($v->revisado)
                                            <span class="badge bg-success">Sí</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('viaticos.show', $v->id) }}" class="btn btn-info btn-sm">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <a href="{{ route('viaticos.edit', $v->id) }}" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="{{ route('comprobaciones.index', $v->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-file-invoice-dollar"></i>
                                        </a>
                                        <form action="{{ route('viaticos.destroy', $v->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#viaticos').DataTable({
                "dom": '<"row"<"col-sm-6"l><"col-sm-6"Bf>>rtip',
                "pageLength": 10,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                "language": {
                    "emptyTable": "No hay información disponible",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Viaticos",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Viaticos",
                    "infoFiltered": "(filtrado de _MAX_ Viaticos en total)",
                    "lengthMenu": "Mostrar _MENU_ Viaticos",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron resultados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": [
                    {
                        extend: 'collection',
                        text: 'Opciones',
                        buttons: [
                            { extend: 'copy', text: 'Copiar' },
                            { extend: 'pdf', text: 'PDF' },
                            { extend: 'csv', text: 'CSV' },
                            { extend: 'excel', text: 'Excel' },
                            { extend: 'print', text: 'Imprimir' }
                        ]
                    },
                    {
                        extend: 'colvis',
                        text: 'Visor de columnas'
                    }
                ]
            });
        });

        @if (session('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: '¿Estás seguro de eliminar este fondo?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@stop
