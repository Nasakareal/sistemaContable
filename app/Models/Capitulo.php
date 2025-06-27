<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Capitulo extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'capitulos';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Configuración de historial con Spatie
     */
    protected static $logAttributes = [
        'nombre',
        'descripcion',
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'capitulo';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }

    public function partidas()
    {
        return $this->hasMany(Partida::class);
    }
}
