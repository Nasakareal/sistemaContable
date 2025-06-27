<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Area extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'areas';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Configuración para el log de actividad
     */
    protected static $logAttributes = [
        'nombre',
        'descripcion',
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'area';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }
}
