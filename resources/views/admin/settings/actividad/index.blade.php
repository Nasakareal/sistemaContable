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
    </style>
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
