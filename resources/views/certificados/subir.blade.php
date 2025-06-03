@extends('layouts.app')

@section('title', 'Generar Certificado P12')

@section('content')
<div class="container">
    <h3 class="mb-3">Generar Archivo .p12 desde .cer y .key</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('certificados.generarP12') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="cer" class="form-label">Archivo .cer</label>
            <input type="file" class="form-control" name="cer" required>
        </div>
        <div class="mb-3">
            <label for="key" class="form-label">Archivo .key</label>
            <input type="file" class="form-control" name="key" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña del .key</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-success">Generar y Descargar .p12</button>
    </form>
</div>
@endsection
