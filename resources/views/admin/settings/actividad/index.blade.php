@extends('adminlte::page')

@section('title', 'Historial de Actividad')

@section('content_header')
    <h1>Historial de Actividad</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Registro de Actividades</h3>
                </div>
                <div class="card-body">
                    <table id="actividad" class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th><center>Número</center></th>
                                <th><center>Fecha</center></th>
                                <th><center>Usuario</center></th>
                                <th><center>Acción</center></th>
                                <th><center>Detalles</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activities as $index => $activity)
                                <tr>
                                    <td style="text-align: center">{{ $index + 1 }}</td>
                                    <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $activity->causer ? $activity->causer->name : 'Sistema' }}</td>
                                    <td>{{ $activity->description }}</td>
                                    <td>
                                        @if($activity->properties->isNotEmpty())
                                            @php
                                                $properties = $activity->properties->toArray();
                                            @endphp

                                            @if(isset($properties['attributes']))
                                                <ul style="list-style: none; padding: 0; margin:0;">
                                                    @foreach($properties['attributes'] as $key => $value)
                                                        <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <pre>{{ json_encode($properties, JSON_PRETTY_PRINT) }}</pre>
                                            @endif
                                        @else
                                            Sin detalles
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    {{ $activities->links() }}
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
        $(function () {
            $('#actividad').DataTable({
                "pageLength": 5,
                "language": {
                    "emptyTable": "No hay información disponible",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ actividades",
                    "infoEmpty": "Mostrando 0 a 0 de 0 actividades",
                    "infoFiltered": "(filtrado de _MAX_ actividades en total)",
                    "lengthMenu": "Mostrar _MENU_ actividades",
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
                    { extend: 'colvis', text: 'Visor de columnas' }
                ],
            }).buttons().container().appendTo('#actividad_wrapper .col-md-6:eq(0)');
        });
    </script>
@stop
