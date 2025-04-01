@extends('adminlte::page')

@section('title', 'Detalle de Evidencia')

@section('content_header')
    <h1>Detalle de Evidencia</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Información de la Evidencia</h3>
                </div>
                <div class="card-body">

                    <!-- Solicitud relacionada -->
                    <div class="mb-3">
                        <strong>Solicitud Relacionada:</strong>
                        <p>
                            @if ($evidencia->solicitudDev)
                                {{ $evidencia->solicitudDev->codigo }} - {{ $evidencia->solicitudDev->descripcion }}
                            @else
                                <span class="text-muted">Sin solicitud asignada</span>
                            @endif
                        </p>
                    </div>

                    <!-- Archivo -->
                    <div class="mb-3">
                        <strong>Archivo:</strong><br>
                        @if ($evidencia->ruta)
                            @php
                                $extension = pathinfo($evidencia->ruta, PATHINFO_EXTENSION);
                                $url = asset('storage/' . $evidencia->ruta);
                            @endphp

                            @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                <img src="{{ $url }}" alt="Evidencia" class="img-fluid rounded border" style="max-height: 400px;">
                            @elseif ($extension === 'pdf')
                                <embed src="{{ $url }}" type="application/pdf" width="100%" height="600px" />
                            @else
                                <a href="{{ $url }}" target="_blank" class="btn btn-outline-success">
                                    <i class="fa-solid fa-paperclip"></i> Ver archivo adjunto
                                </a>
                            @endif
                        @else
                            <p class="text-muted">Sin archivo cargado</p>
                        @endif
                    </div>

                    <!-- Botón Regresar -->
                    <div class="mt-4">
                        <a href="{{ route('evidencias.index') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left"></i> Regresar al listado
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card-title {
            font-weight: bold;
        }
    </style>
@stop

@section('js')
    @if (session('success'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
@stop
