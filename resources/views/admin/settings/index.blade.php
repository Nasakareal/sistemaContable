@extends('adminlte::page')

@section('title')

@section('content_header')
    <h1>Configuraciones del Sistema</h1>
@stop

@section('content')
    <div class="row">

        <!-- Usuarios -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="fa-solid fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Usuarios</b></span>
                    <a href="{{ url('/admin/settings/users') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Roles -->
         <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-navy"><i class="fa-regular fa-flag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Roles</b></span>
                    <a href="{{ url('/admin/settings/roles') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

         <!-- Cuentas Bancarias -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa-solid fa-university"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Cuentas Bancarias</b></span>
                    <a href="{{ url('/admin/settings/cuentas') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Estadisticas -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa-solid fa-chart-pie"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Estadisticas</b></span>
                    <a href="{{ url('#') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Vacias Base de Datos -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fa-solid fa-dumpster"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Vaciar Base de Datos</b></span>
                    <a href="{{ url('/admin/vaciados') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Registro de Actividad  -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-indigo"><i class="fa-solid fa-user-secret"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Registro de Actividad</b></span>
                    <a href="{{ url('/admin/settings/actividad') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .info-box-content {
            text-align: center;
        }
        .info-box-text {
            font-weight: bold;
        }
    </style>
@stop

@section('js')
    <script> console.log("Configuraciones del Sistema cargadas."); </script>
@stop
