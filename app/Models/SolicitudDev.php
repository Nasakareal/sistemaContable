<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SolicitudDev extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'solicitud_devs';

    protected $fillable = [
        'codigo',
        'descripcion',
        'documento_origen',
    ];

    /**
     * Configuración del historial de actividades
     */
    protected static $logAttributes = [
        'codigo',
        'descripcion',
        'documento_origen',
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'solicitud_dev';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }
}
