@extends('adminlte::page')

@section('title', 'Editar Transacción')

@section('content_header')
    <h1>Editar Transacción</h1>
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

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Modificar los datos de la transacción</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('transacciones.update', $transaccion->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Tipo -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tipo">Tipo</label>
                                    <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror">
                                        <option value="ingreso" {{ $transaccion->tipo == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                                        <option value="egreso" {{ $transaccion->tipo == 'egreso' ? 'selected' : '' }}>Egreso</option>
                                    </select>
                                    @error('tipo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Monto -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="monto">Monto</label>
                                    <input type="number" step="0.01" name="monto" id="monto"
                                           class="form-control @error('monto') is-invalid @enderror"
                                           value="{{ old('monto', $transaccion->monto) }}">
                                    @error('monto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="datetime-local" name="fecha" id="fecha"
                                           class="form-control @error('fecha') is-invalid @enderror"
                                           value="{{ old('fecha', \Carbon\Carbon::parse($transaccion->fecha)->format('Y-m-d\TH:i')) }}">
                                    @error('fecha')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" id="descripcion"
                                      class="form-control @error('descripcion') is-invalid @enderror"
                                      rows="3">{{ old('descripcion', $transaccion->descripcion) }}</textarea>
                            @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Cuenta Bancaria -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cuenta_bancaria_id">Cuenta Bancaria</label>
                                    <select name="cuenta_bancaria_id" id="cuenta_bancaria_id"
                                            class="form-control @error('cuenta_bancaria_id') is-invalid @enderror">
                                        <option value="">-- Seleccione una cuenta --</option>
                                        @foreach ($cuentas as $cuenta)
                                            <option value="{{ $cuenta->id }}"
                                                {{ $transaccion->cuenta_bancaria_id == $cuenta->id ? 'selected' : '' }}>
                                                {{ $cuenta->nombre }} ({{ $cuenta->numero }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cuenta_bancaria_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Unidad Responsable -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="unidad_responsable_id">Unidad Responsable</label>
                                    <select name="unidad_responsable_id" id="unidad_responsable_id"
                                            class="form-control @error('unidad_responsable_id') is-invalid @enderror">
                                        <option value="">-- Seleccione --</option>
                                        @foreach ($unidades as $unidad)
                                            <option value="{{ $unidad->id }}"
                                                {{ $transaccion->unidad_responsable_id == $unidad->id ? 'selected' : '' }}>
                                                {{ $unidad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unidad_responsable_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Área -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="area_id">Área</label>
                                    <select name="area_id" id="area_id"
                                            class="form-control @error('area_id') is-invalid @enderror">
                                        <option value="">-- Seleccione --</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}"
                                                {{ $transaccion->area_id == $area->id ? 'selected' : '' }}>
                                                {{ $area->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('area_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Solicitud Dev -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="solicitud_dev_id">Solicitud de Devolución</label>
                                    <select name="solicitud_dev_id" id="solicitud_dev_id"
                                            class="form-control @error('solicitud_dev_id') is-invalid @enderror">
                                        <option value="">-- Seleccione --</option>
                                        @foreach ($solicitudes as $solicitud)
                                            <option value="{{ $solicitud->id }}"
                                                {{ $transaccion->solicitud_dev_id == $solicitud->id ? 'selected' : '' }}>
                                                {{ $solicitud->codigo }} - {{ $solicitud->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('solicitud_dev_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- CONTENEDOR PARA PARTIDAS -->
                        <div id="partidas-container">
                            @foreach ($transaccion->partidas as $index => $p)
                                <div class="row partida-row mb-2" data-index="{{ $index }}">
                                    <div class="col-md-4">
                                        <label>Capítulo</label>
                                        <select class="form-control capitulo-select" required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach ($capitulos as $capitulo)
                                                <option value="{{ $capitulo->id }}"
                                                    {{ $p->capitulo_id == $capitulo->id ? 'selected' : '' }}>
                                                    {{ $capitulo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Partida</label>
                                        <select name="partidas[{{ $index }}][id]" class="form-control partida-select" required>
                                            <option value="{{ $p->id }}">{{ $p->nombre }}</option> <!-- Precargada -->
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Monto</label>
                                        <input type="number" name="partidas[{{ $index }}][monto]" value="{{ $p->pivot->monto }}" class="form-control" step="0.01" required>
                                    </div>

                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-remove-partida">&times;</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- BOTÓN PARA AÑADIR MÁS FILAS -->
                        <div class="text-right mt-3">
                            <button type="button" id="add-partida" class="btn btn-secondary">+ Agregar otra partida</button>
                        </div>



                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa-solid fa-save"></i> Actualizar Transacción
                            </button>
                            <a href="{{ route('transacciones.index') }}" class="btn btn-secondary">
                                <i class="fa-solid fa-ban"></i> Cancelar
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
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

        @if (session('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    </script>

    <script>
    let partidaIndex = {{ $transaccion->partidas->count() }}; // ← Continuamos donde se quedó
    const capitulos = @json($capitulos);
    const partidasUrlBase = "{{ url('/partidas/capitulo') }}";

    function createPartidaRow(idx) {
        return `
            <div class="row partida-row mb-2" data-index="${idx}">
                <div class="col-md-4">
                    <label>Capítulo</label>
                    <select class="form-control capitulo-select" required>
                        <option value="">-- Seleccione --</option>
                        ${capitulos.map(c => `<option value="${c.id}">${c.nombre}</option>`).join('')}
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Partida</label>
                    <select name="partidas[${idx}][id]" class="form-control partida-select" required>
                        <option value="">-- Seleccione --</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Monto</label>
                    <input type="number" name="partidas[${idx}][monto]" class="form-control" step="0.01" required>
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove-partida">&times;</button>
                </div>
            </div>
        `;
    }

    document.getElementById('add-partida').addEventListener('click', function () {
        const container = document.getElementById('partidas-container');
        container.insertAdjacentHTML('beforeend', createPartidaRow(partidaIndex));
        partidaIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove-partida')) {
            const rows = document.querySelectorAll('.partida-row');
            if (rows.length > 1) {
                e.target.closest('.partida-row').remove();
            }
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('capitulo-select')) {
            const capituloId = e.target.value;
            const row = e.target.closest('.partida-row');
            const partidaSelect = row.querySelector('.partida-select');

            if (!capituloId) {
                partidaSelect.innerHTML = '<option value="">-- Seleccione --</option>';
                return;
            }

            partidaSelect.innerHTML = '<option value="">Cargando...</option>';
            const url = `${partidasUrlBase}/${capituloId}?t=${Date.now()}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Error al obtener partidas');
                    return response.json();
                })
                .then(data => {
                    partidaSelect.innerHTML = '<option value="">-- Seleccione --</option>';
                    data.forEach(partida => {
                        const option = document.createElement('option');
                        option.value = partida.id;
                        option.text = `${partida.nombre} - ${partida.descripcion ?? ''}`;
                        partidaSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar las partidas:', error);
                    partidaSelect.innerHTML = '<option value="">-- Seleccione --</option>';
                });
        }
    });
</script>

@stop
