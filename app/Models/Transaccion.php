<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = 'transacciones';

    protected $fillable = [
        'tipo',
        'monto',
        'fecha',
        'descripcion',
        'cuenta_bancaria_id',
        'capitulo_id',
        'partida_id',
        'unidad_responsable_id',
        'area_id',
        'solicitud_dev_id'
    ];
}
