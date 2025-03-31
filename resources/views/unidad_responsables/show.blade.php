@extends('adminlte::page')

@section('title', 'Detalle de la Unidad Responsable')

@section('content_header')
    <h1>Detalle de la Unidad Responsable</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Información general</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Nombre:</dt>
                        <dd class="col-sm-8">{{ $unidad_responsable->nombre }}</dd>

                        <dt class="col-sm-4">Descripción:</dt>
                        <dd class="col-sm-8">
                            {{ $unidad_responsable->descripcion ?? 'Sin descripción' }}
                        </dd>

                        <dt class="col-sm-4">Creado el:</dt>
                        <dd class="col-sm-8">{{ $unidad_responsable->created_at->format('d/m/Y H:i') }}</dd>

                        <dt class="col-sm-4">Última modificación:</dt>
                        <dd class="col-sm-8">{{ $unidad_responsable->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('unidad_responsables.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Volver al listado
                    </a>
                    <a href="{{ route('unidad_responsables.edit', $unidad_responsable->id) }}" class="btn btn-success">
                        <i class="fa-solid fa-pencil"></i> Editar
                    </a>
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
