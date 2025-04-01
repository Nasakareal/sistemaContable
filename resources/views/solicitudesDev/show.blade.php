@extends('adminlte::page')

@section('title', 'Detalle de la Solicitud de Devolución')

@section('content_header')
    <h1>Detalle de la Solicitud</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Información General</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <!-- Código -->
                        <dt class="col-sm-3">Código</dt>
                        <dd class="col-sm-9">{{ $solicitudDev->codigo ?? 'N/A' }}</dd>

                        <!-- Descripción -->
                        <dt class="col-sm-3">Descripción</dt>
                        <dd class="col-sm-9">{{ $solicitudDev->descripcion ?? 'Sin descripción' }}</dd>

                        <!-- Documento Origen -->
                        <dt class="col-sm-3">Documento Origen</dt>
                        <dd class="col-sm-9">{{ $solicitudDev->documento_origen ?? 'N/A' }}</dd>

                        <!-- Fecha de creación -->
                        <dt class="col-sm-3">Creado el</dt>
                        <dd class="col-sm-9">{{ $solicitudDev->created_at->format('d/m/Y H:i') }}</dd>

                        <!-- Última actualización -->
                        <dt class="col-sm-3">Última modificación</dt>
                        <dd class="col-sm-9">{{ $solicitudDev->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>

                    <div class="form-group mt-4">
                        <a href="{{ route('solicitudesDev.edit', $solicitudDev->id) }}" class="btn btn-success">
                            <i class="fa-solid fa-pencil"></i> Editar
                        </a>
                        <a href="{{ route('solicitudesDev.index') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left"></i> Volver al listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        dt {
            font-weight: bold;
        }
    </style>
@stop
