<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Evidencia extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'evidencias';

    protected $fillable = [
        'solicitud_dev_id',
        'ruta',
    ];

    /**
     * Configuración de historial con Spatie
     */
    protected static $logAttributes = [
        'solicitud_dev_id',
        'ruta',
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'evidencia';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }

    public function solicitudDev()
    {
        return $this->belongsTo(SolicitudDev::class);
    }
}
