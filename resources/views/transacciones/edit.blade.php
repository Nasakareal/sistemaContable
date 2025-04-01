@extends('adminlte::page')

@section('title', 'Editar Transacción')

@section('content_header')
    <h1>Editar Transacción</h1>
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
                            <div class="col-md-6">
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

                            <!-- Capítulo -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="capitulo_id">Capítulo</label>
                                    <select name="capitulo_id" id="capitulo_id"
                                            class="form-control @error('capitulo_id') is-invalid @enderror">
                                        <option value="">-- Seleccione --</option>
                                        @foreach ($capitulos as $capitulo)
                                            <option value="{{ $capitulo->id }}"
                                                {{ $transaccion->capitulo_id == $capitulo->id ? 'selected' : '' }}>
                                                {{ $capitulo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('capitulo_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Partida -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="partida_id">Partida</label>
                                    <select name="partida_id" id="partida_id"
                                            class="form-control @error('partida_id') is-invalid @enderror">
                                        <option value="">-- Seleccione --</option>
                                        @foreach ($partidas as $partida)
                                            <option value="{{ $partida->id }}"
                                                {{ $transaccion->partida_id == $partida->id ? 'selected' : '' }}>
                                                {{ $partida->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('partida_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Unidad Responsable -->
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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

@section('css')
    <style>
        .form-group label {
            font-weight: bold;
        }
    </style>
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
@stop
