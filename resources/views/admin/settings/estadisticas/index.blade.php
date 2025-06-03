@extends('adminlte::page')

@section('title', 'TI-UTM - Estadísticas')

@section('content_header')
    <h1>Estadísticas Disponibles</h1>
@stop

@section('content')
<div class="row">
    @foreach($estadisticas as $item)
        <div class="col-md-6 col-xl-4 mb-3">
            <div class="card card-outline card-primary h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title">{{ $item['titulo'] }}</h5>
                    <a href="{{ $item['ruta'] }}" class="btn btn-success mt-3">
                        <i class="fas fa-file-excel"></i> Descargar Excel
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@stop
