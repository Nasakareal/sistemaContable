@extends('adminlte::page')

@section('title', 'Listado de Transacciones')

@section('content_header')
    <h1>Listado de Transacciones</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Transacciones</h3>
                    <div class="card-tools">
                        <a href="{{ route('transacciones.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-money-bill-transfer"></i> Nueva Transacción
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table id="transacciones" class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Cuenta Bancaria</th>
                                <th>Capítulo</th>
                                <th>Partida</th>
                                <th>UR</th>
                                <th>Área</th>
                                <th>Solicitud</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transacciones as $index => $transaccion)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge badge-{{ $transaccion->tipo == 'ingreso' ? 'success' : 'danger' }}">
                                            {{ ucfirst($transaccion->tipo) }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($transaccion->monto, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaccion->fecha)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $transaccion->cuentaBancaria->nombre ?? 'N/A' }}</td>
                                    <td>{{ $transaccion->capitulo->nombre ?? '—' }}</td>
                                    <td>{{ $transaccion->partida->nombre ?? '—' }}</td>
                                    <td>{{ $transaccion->unidadResponsable->nombre ?? '—' }}</td>
                                    <td>{{ $transaccion->area->nombre ?? '—' }}</td>
                                    <td>{{ $transaccion->solicitudDev->codigo ?? '—' }}</td>
                                    <td>
                                        <a href="{{ route('transacciones.show', $transaccion->id) }}" class="btn btn-info btn-sm">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <a href="{{ route('transacciones.edit', $transaccion->id) }}" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('transacciones.destroy', $transaccion->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn">
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
            $('#transacciones').DataTable({
                dom: '<"row"<"col-sm-6"l><"col-sm-6"Bf>>rtip',
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                language: {
                    emptyTable: "No hay transacciones registradas",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ transacciones",
                    infoEmpty: "Mostrando 0 a 0 de 0 transacciones",
                    infoFiltered: "(filtrado de _MAX_ transacciones en total)",
                    lengthMenu: "Mostrar _MENU_ transacciones",
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
