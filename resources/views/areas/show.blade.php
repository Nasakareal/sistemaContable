@extends('adminlte::page')

@section('title', 'Detalle del Área')

@section('content_header')
    <h1>Detalle del Área</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Información del Área</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Nombre del Área:</dt>
                        <dd class="col-sm-8">{{ $area->nombre }}</dd>

                        <dt class="col-sm-4">Descripción:</dt>
                        <dd class="col-sm-8">{{ $area->descripcion ?? 'Sin descripción' }}</dd>

                        <dt class="col-sm-4">Fecha de Registro:</dt>
                        <dd class="col-sm-8">{{ $area->created_at->format('d/m/Y H:i') }}</dd>

                        <dt class="col-sm-4">Última Actualización:</dt>
                        <dd class="col-sm-8">{{ $area->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('areas.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Volver al listado
                    </a>
                    <a href="{{ route('areas.edit', $area->id) }}" class="btn btn-success">
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
