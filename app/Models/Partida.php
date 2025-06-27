<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Partida extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'nombre',
        'descripcion',
        'capitulo_id',
    ];

    /**
     * Configuración del historial de actividad
     */
    protected static $logAttributes = [
        'nombre',
        'descripcion',
        'capitulo_id',
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'partida';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }

    public function capitulo()
    {
        return $this->belongsTo(Capitulo::class);
    }
}
