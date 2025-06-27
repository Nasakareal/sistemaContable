@extends('adminlte::page')

@section('title', 'Historial de Actividad - ' . ucfirst($log))

@section('content_header')
    <h1>Actividades del módulo: {{ ucfirst($log) }}</h1>
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

        /* Estilo oscuro para los módulos listados */
        .list-group {
            background-color: #1f2937 !important;
        }

        .list-group-item {
            background-color: #111827 !important;
            color: white !important;
            border: 1px solid #374151;
        }

        .list-group-item:hover {
            background-color: #1e293b !important;
        }

        .btn-primary {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
        }

        .btn-primary:hover {
            background-color: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
        }

    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@stop

@section('content')
    @php
        if (!function_exists('formatValue')) {
            function formatValue($val, $color = null) {
                $style = $color ? "color: {$color};" : '';
                if (is_array($val)) {
                    return "<pre style='{$style} background-color: transparent; padding: 0; margin: 0;'>" 
                        . json_encode($val, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) 
                        . "</pre>";
                }
                return "<span style='{$style}'>" . e($val) . "</span>";
            }
        }
    @endphp

    <div class="card card-outline card-primary">
        <div class="card-body table-responsive">
            <table id="actividad" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actividades as $actividad)
                        <tr>
                            <td>{{ $actividad->id }}</td>
                            <td>
                                <strong>{{ ucfirst($actividad->description) }}</strong><br>
                                @php
                                    $props = $actividad->properties->toArray();
                                    $old  = $props['old'] ?? [];
                                    $new  = $props['attributes'] ?? [];
                                @endphp

                                @if($actividad->description === 'updated' && $old)
                                    <ul class="mb-0 text-left" style="list-style: none; padding-left: 1rem;">
                                        @foreach($new as $key => $val)
                                            @php $oldVal = $old[$key] ?? null; @endphp
                                            @if($oldVal != $val)
                                                <li>
                                                    <strong>{{ ucfirst($key) }}:</strong>
                                                    {!! formatValue($oldVal, 'red') !!} &rarr;
                                                    {!! formatValue($val, 'green') !!}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif

                                @if($actividad->description === 'created' && $new)
                                    <ul class="mb-0 text-left" style="list-style: none; padding-left: 1rem;">
                                        @foreach($new as $key => $val)
                                            <li>
                                                <strong>{{ ucfirst($key) }}:</strong>
                                                {!! formatValue($val, 'green') !!}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if($actividad->description === 'deleted' && $props)
                                    <ul class="mb-0 text-left" style="list-style: none; padding-left: 1rem;">
                                        @foreach($props as $key => $val)
                                            <li>
                                                <strong>{{ ucfirst($key) }}:</strong>
                                                {!! formatValue($val, 'red') !!}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>{{ $actividad->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ optional($actividad->causer)->name ?? 'Desconocido' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop


@section('js')
<script>
    $(function () {
        $('#actividad').DataTable();
    });
</script>
@stop
