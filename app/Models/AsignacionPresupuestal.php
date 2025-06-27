<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AsignacionPresupuestal extends Model
{
    use HasFactory, LogsActivity;

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

    /**
     * Configuración para el historial de actividades
     */
    protected static $logAttributes = [
        'fondo_id',
        'cuenta_bancaria_id',
        'unidad_responsable_id',
        'partida_id',
        'monto',
        'periodo',
        'justificacion',
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'asignacion_presupuestal';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }

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
