@extends('adminlte::page')

@section('title', 'Editar Cuenta Bancaria')

@section('content_header')
    <h1>Editar Cuenta Bancaria</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Modificar los Datos de la Cuenta</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('cuentas.update', $cuentaBancaria) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre de la Cuenta</label>
                                    <input type="text" name="nombre" id="nombre" 
                                           class="form-control @error('nombre') is-invalid @enderror" 
                                           value="{{ old('nombre', $cuentaBancaria->nombre) }}" required>
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Número -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numero">Número de Cuenta</label>
                                    <input type="text" name="numero" id="numero" 
                                           class="form-control @error('numero') is-invalid @enderror" 
                                           value="{{ old('numero', $cuentaBancaria->numero) }}" required>
                                    @error('numero')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Saldo -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="saldo">Saldo</label>
                                    <input type="number" name="saldo" id="saldo" step="0.01"
                                           class="form-control @error('saldo') is-invalid @enderror" 
                                           value="{{ old('saldo', $cuentaBancaria->saldo) }}" required>
                                    @error('saldo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fondo -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fondo_id">Fondo Asociado</label>
                                    <select name="fondo_id" id="fondo_id" class="form-control @error('fondo_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un fondo</option>
                                        @foreach ($fondos as $fondo)
                                            <option value="{{ $fondo->id }}" 
                                                {{ old('fondo_id', $cuentaBancaria->fondo_id) == $fondo->id ? 'selected' : '' }}>
                                                {{ $fondo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('fondo_id')
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
                                        <i class="fa-solid fa-save"></i> Guardar Cambios
                                    </button>
                                    <a href="{{ route('cuentas.index') }}" class="btn btn-secondary">
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
