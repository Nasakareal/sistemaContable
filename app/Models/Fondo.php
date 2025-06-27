<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Fondo extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'clave',
        'nombre',
        'descripcion'
    ];

    /**
     * Configuración de historial con Spatie
     */
    protected static $logAttributes = [
        'clave',
        'nombre',
        'descripcion'
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'fondo';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }

    public function cuentasBancarias()
    {
        return $this->hasMany(\App\Models\CuentaBancaria::class);
    }

    public function unidadesResponsables()
    {
        return $this->hasMany(UnidadResponsable::class);
    }
}
