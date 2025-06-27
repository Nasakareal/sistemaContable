<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Movimiento extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'movimientos';

    protected $fillable = [
        'tipo',
        'referencia',
        'descripcion',
        'fecha',
        'monto',
        'status',
        'origen',
        'cuenta_bancaria_id'
    ];

    /**
     * Configuración del historial de actividad
     */
    protected static $logAttributes = [
        'tipo',
        'referencia',
        'descripcion',
        'fecha',
        'monto',
        'status',
        'origen',
        'cuenta_bancaria_id'
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'movimiento';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }

    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }
}
