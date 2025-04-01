@extends('adminlte::page')

@section('title', 'Crear Solicitud de Devolución')

@section('content_header')
    <h1>Creación de una Nueva Solicitud</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Llene los Datos de la Solicitud</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('solicitudesDev.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Código -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="codigo">Código</label>
                                    <input type="text" name="codigo" id="codigo"
                                           class="form-control @error('codigo') is-invalid @enderror"
                                           value="{{ old('codigo') }}" placeholder="Ej: DEV-2025-001">
                                    @error('codigo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <input type="text" name="descripcion" id="descripcion"
                                           class="form-control @error('descripcion') is-invalid @enderror"
                                           value="{{ old('descripcion') }}" placeholder="Motivo o detalle de la devolución">
                                    @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Documento Origen -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="documento_origen">Documento Origen</label>
                                    <input type="text" name="documento_origen" id="documento_origen"
                                           class="form-control @error('documento_origen') is-invalid @enderror"
                                           value="{{ old('documento_origen') }}" placeholder="Ej: Req-123, Factura-456">
                                    @error('documento_origen')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-check"></i> Registrar
                                    </button>
                                    <a href="{{ route('solicitudesDev.index') }}" class="btn btn-secondary">
                                        <i class="fa-solid fa-ban"></i> Cancelar
                                    </a>
                                </div>
                            </div>
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
    </script>
@stop
