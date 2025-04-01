@extends('adminlte::page')

@section('title', 'Detalles de la Transacción')

@section('content_header')
    <h1>Detalles de la Transacción</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa-solid fa-money-bill-transfer"></i> Información de la Transacción
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('transacciones.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Volver
                        </a>
                        <a href="{{ route('transacciones.edit', $transaccion->id) }}" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i> Editar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Tipo</dt>
                        <dd class="col-sm-9">
                            <span class="badge badge-{{ $transaccion->tipo === 'ingreso' ? 'success' : 'danger' }}">
                                {{ ucfirst($transaccion->tipo) }}
                            </span>
                        </dd>

                        <dt class="col-sm-3">Monto</dt>
                        <dd class="col-sm-9">${{ number_format($transaccion->monto, 2) }}</dd>

                        <dt class="col-sm-3">Fecha</dt>
                        <dd class="col-sm-9">{{ \Carbon\Carbon::parse($transaccion->fecha)->format('d/m/Y H:i') }}</dd>

                        <dt class="col-sm-3">Descripción</dt>
                        <dd class="col-sm-9">{{ $transaccion->descripcion ?? '—' }}</dd>

                        <dt class="col-sm-3">Cuenta Bancaria</dt>
                        <dd class="col-sm-9">
                            {{ $transaccion->cuentaBancaria->nombre ?? '—' }}
                            <small class="text-muted">({{ $transaccion->cuentaBancaria->numero ?? '' }})</small>
                        </dd>

                        <dt class="col-sm-3">Capítulo</dt>
                        <dd class="col-sm-9">{{ $transaccion->capitulo->nombre ?? '—' }}</dd>

                        <dt class="col-sm-3">Partida</dt>
                        <dd class="col-sm-9">{{ $transaccion->partida->nombre ?? '—' }}</dd>

                        <dt class="col-sm-3">Unidad Responsable</dt>
                        <dd class="col-sm-9">{{ $transaccion->unidadResponsable->nombre ?? '—' }}</dd>

                        <dt class="col-sm-3">Área</dt>
                        <dd class="col-sm-9">{{ $transaccion->area->nombre ?? '—' }}</dd>

                        <dt class="col-sm-3">Solicitud de Devolución</dt>
                        <dd class="col-sm-9">{{ $transaccion->solicitudDev->codigo ?? '—' }}</dd>

                        <dt class="col-sm-3">Registrado</dt>
                        <dd class="col-sm-9">{{ $transaccion->created_at->format('d/m/Y H:i') }}</dd>

                        <dt class="col-sm-3">Última Actualización</dt>
                        <dd class="col-sm-9">{{ $transaccion->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
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
