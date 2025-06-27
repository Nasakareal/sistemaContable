<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class UnidadResponsable extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'unidad_responsables';

    protected $fillable = [
        'clave',
        'nombre',
        'descripcion',
        'fondo_id'
    ];

    /**
     * Configuración del historial de actividad
     */
    protected static $logAttributes = [
        'clave',
        'nombre',
        'descripcion',
        'fondo_id'
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'unidad_responsable';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }

    public function fondo()
    {
        return $this->belongsTo(Fondo::class);
    }
}
