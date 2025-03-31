@extends('adminlte::page')

@section('title', 'Crear Partida')

@section('content_header')
    <h1>Creación de una Nueva Partida</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Llene los Datos de la Partida</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('partidas.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre de la Partida</label>
                                    <input type="text" name="nombre" id="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre') }}" placeholder="Ej: Partida 2000" required>
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <input type="text" name="descripcion" id="descripcion"
                                           class="form-control @error('descripcion') is-invalid @enderror"
                                           value="{{ old('descripcion') }}" placeholder="Descripción opcional">
                                    @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Capítulo -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="capitulo_id">Capítulo</label>
                                    <select name="capitulo_id" id="capitulo_id"
                                            class="form-control @error('capitulo_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un capítulo</option>
                                        @foreach ($capitulos as $capitulo)
                                            <option value="{{ $capitulo->id }}"
                                                {{ old('capitulo_id') == $capitulo->id ? 'selected' : '' }}>
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
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-check"></i> Registrar
                                    </button>
                                    <a href="{{ route('partidas.index') }}" class="btn btn-secondary">
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
