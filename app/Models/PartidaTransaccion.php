<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PartidaTransaccion extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'partida_transaccion';

    protected $fillable = [
        'transaccion_id',
        'partida_id',
        'monto',
    ];

    /**
     * Configuración del historial de actividad
     */
    protected static $logAttributes = [
        'transaccion_id',
        'partida_id',
        'monto',
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'partida_transaccion';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }

    public function transaccion()
    {
        return $this->belongsTo(Transaccion::class);
    }

    public function partida()
    {
        return $this->belongsTo(Partida::class);
    }
}
