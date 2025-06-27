<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado;
use App\Models\Fondo;
use App\Models\CuentaBancaria;
use App\Models\Partida;
use Spatie\Activitylog\Traits\LogsActivity;

class ViaticoReal extends Model
{
    use HasFactory, LogsActivity;

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

    protected $casts = [
        'fecha_entrega' => 'date',
    ];

    /**
     * Configuración de Spatie Activity Log
     */
    protected static $logAttributes = [
        'estatus',
        'importe_total',
        'fecha_entrega',
        'cuenta_bancaria_id',
        'fondo_id',
        'empleado_id',
    ];

    protected static $logName = 'viatico';
    protected static $logOnlyDirty = true;

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

    public function comprobaciones()
    {
        return $this->hasMany(ViaticosComprobacion::class, 'viatico_id');
    }
}
