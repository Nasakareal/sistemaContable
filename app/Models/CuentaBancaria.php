<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CuentaBancaria extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'fondo_id',
        'nombre',
        'numero',
        'saldo',
    ];

    /**
     * Configuración de historial con Spatie
     */
    protected static $logAttributes = [
        'fondo_id',
        'nombre',
        'numero',
        'saldo',
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'cuenta_bancaria';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }

    public function fondo()
    {
        return $this->belongsTo(Fondo::class);
    }
}
