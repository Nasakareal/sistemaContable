<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado;
use App\Models\Fondo;
use App\Models\CuentaBancaria;
use App\Models\Partida;

class ViaticoReal extends Model
{
    use HasFactory;

    protected $table = 'viaticos';

    protected $fillable = [
        'empleado_id',
        'fondo_id',
        'cuenta_bancaria_id',
        'fecha_entrega',
        'importe_total',
        'estatus',
        'observaciones',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function fondo()
    {
        return $this->belongsTo(Fondo::class);
    }

    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }

    public function partidas()
    {
        return $this->belongsToMany(Partida::class, 'partida_viatico', 'viatico_id', 'partida_id')
                    ->withPivot('monto')
                    ->withTimestamps();
    }

    public function comprobaciones()
    {
        return $this->hasMany(ViaticosComprobacion::class, 'viatico_id');
    }
}
