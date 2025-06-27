<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Proyeccion extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'proyecciones';

    protected $fillable = [
        'cuenta_bancaria_id',
        'month',
        'year',
        'monto',
    ];

    /**
     * Configuración del historial
     */
    protected static $logAttributes = [
        'cuenta_bancaria_id',
        'month',
        'year',
        'monto',
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'proyeccion';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }

    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }

    public function getNombreMesAttribute()
    {
        return ucfirst(\Carbon\Carbon::create()->month($this->month)->locale('es')->monthName);
    }

    public function fondo()
    {
        return $this->belongsTo(Fondo::class);
    }

    public function unidadResponsable()
    {
        return $this->belongsTo(UnidadResponsable::class);
    }
}
