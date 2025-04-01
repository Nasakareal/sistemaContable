@extends('adminlte::page')

@section('title', 'Editar Evidencia')

@section('content_header')
    <h1>Editar Evidencia</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Modificar Evidencia</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('evidencias.update', $evidencia->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <!-- Solicitud asociada -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="solicitud_dev_id">Solicitud de Devolución</label>
                                    <select name="solicitud_dev_id" id="solicitud_dev_id"
                                            class="form-control @error('solicitud_dev_id') is-invalid @enderror">
                                        <option value="">-- Seleccione una solicitud --</option>
                                        @foreach ($solicitudes as $solicitud)
                                            <option value="{{ $solicitud->id }}"
                                                {{ $evidencia->solicitud_dev_id == $solicitud->id ? 'selected' : '' }}>
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

                            <!-- Archivo nuevo -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ruta">Archivo nuevo (opcional)</label>
                                    <input type="file" name="ruta" id="ruta"
                                           class="form-control @error('ruta') is-invalid @enderror"
                                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    @error('ruta')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">Deje vacío si no desea reemplazar el archivo.</small>
                                </div>
                            </div>

                        </div>

                        <!-- Archivo actual -->
                        @if ($evidencia->ruta)
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        <strong>Archivo actual:</strong>
                                        <a href="{{ asset('storage/' . $evidencia->ruta) }}" target="_blank">
                                            <i class="fa-solid fa-paperclip"></i> Ver archivo
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endif

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa-solid fa-save"></i> Actualizar
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
