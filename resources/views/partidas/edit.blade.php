@extends('adminlte::page')

@section('title', 'Editar Partida')

@section('content_header')
    <h1>Edición de la Partida</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Modifique los Datos de la Partida</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('partidas.update', $partida->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre de la Partida</label>
                                    <input type="text" name="nombre" id="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre', $partida->nombre) }}" required>
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
                                           value="{{ old('descripcion', $partida->descripcion) }}">
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
                                                {{ old('capitulo_id', $partida->capitulo_id) == $capitulo->id ? 'selected' : '' }}>
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
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa-solid fa-check"></i> Actualizar
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
