<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ViaticosComprobacion extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'viaticos_comprobacions';

    protected $fillable = [
        'viatico_id',
        'cuenta_contable',
        'monto',
        'tipo',
        'fecha_comprobacion',
    ];

    protected $casts = [
        'fecha_comprobacion' => 'date',
    ];

    /**
     * Configuración de Spatie Activity Log
     */
    protected static $logAttributes = [
        'cuenta_contable',
        'monto',
        'tipo',
        'fecha_comprobacion',
    ];

    protected static $logName = 'comprobacion';

    protected static $logOnlyDirty = true;

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }

    public function viatico()
    {
        return $this->belongsTo(Viatico::class);
    }

    public function partidas()
    {
        return $this->belongsToMany(Partida::class, 'partida_viatico', 'viaticos_comprobacion_id', 'partida_id')
                    ->withPivot('monto')
                    ->withTimestamps();
    }
}
