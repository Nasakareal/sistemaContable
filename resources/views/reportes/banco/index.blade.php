@extends('adminlte::page')

@section('title', 'Reporte Banco - Show')

@section('content_header')
    <h1>Reporte Banco</h1>
@stop

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Reporte Banco</h3>
    </div>
    <div class="card-body">
         <div class="table-responsive">
            <table id="banco" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th rowspan="2">mes</th>
                        <th rowspan="2">Trim</th>
                        <th rowspan="2">PERIODO</th>
                    
                        @foreach($todasCuentas as $cuenta)
                            <th colspan="4">{{ $cuenta->nombre }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($todasCuentas as $cuenta)
                            <th>Origen</th>
                            <th>1000 y 3000</th>
                            <th>Otros Mov</th>
                            <th>Saldo</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($datos as $fila)
                        <tr>
                            <td>{{ $fila['mes'] }}</td>
                            <td>{{ $fila['trim'] }}</td>
                            <td>{{ $fila['periodo'] ?? '-' }}</td>

                            <!-- Pintamos las columnas de cada cuenta -->
                            @foreach($todasCuentas as $cuenta)
                                @php
                                    $sub = $fila['datos'][$cuenta->id] ?? null;
                                @endphp

                                @if($sub)
                                    {{-- Origen --}}
                                    <td>
                                        @if(is_null($sub['origen']))
                                            -
                                        @else
                                            {{ number_format($sub['origen'], 2) }}
                                        @endif
                                    </td>
                                    {{-- 1000y3000 --}}
                                    <td>{{ number_format($sub['1000y3000'], 2) }}</td>
                                    {{-- Otros Mov --}}
                                    <td>{{ number_format($sub['otrosMov'], 2) }}</td>
                                    {{-- Saldo --}}
                                    <td>
                                        @if(is_null($sub['saldo']))
                                            -
                                        @else
                                            {{ number_format($sub['saldo'], 2) }}
                                        @endif
                                    </td>
                                @else
                                    {{-- Si por alguna razón no existe, mostramos guiones --}}
                                    <td>-</td><td>-</td><td>-</td><td>-</td>
                                @endif

                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 3 + ($todasCuentas->count() * 4) }}">
                                No hay datos
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
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
            $('#banco').DataTable({
                dom: '<"row"<"col-sm-6"l><"col-sm-6"Bf>>rtip',
                pageLength: 15,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                language: {
                    emptyTable: "No hay banco registradas",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ banco",
                    infoEmpty: "Mostrando 0 a 0 de 0 banco",
                    infoFiltered: "(filtrado de _MAX_ banco en total)",
                    lengthMenu: "Mostrar _MENU_ banco",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    search: "Buscar:",
                    zeroRecords: "No se encontraron resultados",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                buttons: [
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
                title: '¿Estás seguro de eliminar esta transacción?',
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
