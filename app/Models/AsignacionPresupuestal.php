<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionPresupuestal extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_presupuestales';

    protected $fillable = [
        'fondo_id',
        'cuenta_bancaria_id',
        'unidad_responsable_id',
        'partida_id',
        'monto',
        'periodo',
        'justificacion',
    ];

    public function fondo()
    {
        return $this->belongsTo(Fondo::class);
    }

    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }

    public function unidadResponsable()
    {
        return $this->belongsTo(UnidadResponsable::class);
    }

    public function partida()
    {
        return $this->belongsTo(Partida::class);
    }
}
