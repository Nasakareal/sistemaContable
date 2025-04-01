@extends('adminlte::page')

@section('title', 'Cargar Evidencia')

@section('content_header')
    <h1>Cargar Nueva Evidencia</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Seleccione la Solicitud y Cargue la Evidencia</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('evidencias.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <!-- Solicitud asociada -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="solicitud_dev_id">Solicitud de Devolución</label>
                                    <select name="solicitud_dev_id" id="solicitud_dev_id"
                                            class="form-control @error('solicitud_dev_id') is-invalid @enderror">
                                        <option value="">-- Seleccione una solicitud --</option>
                                        @foreach ($solicitudes as $solicitud)
                                            <option value="{{ $solicitud->id }}" {{ old('solicitud_dev_id') == $solicitud->id ? 'selected' : '' }}>
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

                            <!-- Archivo -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ruta">Archivo</label>
                                    <input type="file" name="ruta" id="ruta"
                                           class="form-control @error('ruta') is-invalid @enderror"
                                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    @error('ruta')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">Formatos permitidos: JPG, PNG, PDF, DOC, DOCX (Máx: 2MB)</small>
                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-upload"></i> Subir Evidencia
                                    </button>
                                    <a href="{{ route('evidencias.index') }}" class="btn btn-secondary">
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
