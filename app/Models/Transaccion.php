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

    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }

    public function capitulo()
    {
        return $this->belongsTo(Capitulo::class);
    }

    public function partida()
    {
        return $this->belongsTo(Partida::class);
    }

    public function unidadResponsable()
    {
        return $this->belongsTo(UnidadResponsable::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function solicitudDev()
    {
        return $this->belongsTo(SolicitudDev::class);
    }
}
