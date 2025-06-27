<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Ministracion extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'ministraciones';

    protected $fillable = [
        'fecha',
        'fondo_id',
        'cuenta_bancaria_id',
        'unidad_responsable_id',
        'partida_id',
        'importe',
        'tipo_gasto',
        'descripcion',
        'periodo',
        'observaciones',
        'referencia_gasto',
        'referencia_desc_gasto',
        'ref_fondo',
        'ref_partida',
        'ref_ur',
        'ref_part',
        'cuenta_bancaria_origen',
        'cuenta_aplicacion'
    ];

    /**
     * Configuración del historial de actividad
     */
    protected static $logAttributes = [
        'fecha',
        'fondo_id',
        'cuenta_bancaria_id',
        'unidad_responsable_id',
        'partida_id',
        'importe',
        'tipo_gasto',
        'descripcion',
        'periodo',
        'observaciones',
        'referencia_gasto',
        'referencia_desc_gasto',
        'ref_fondo',
        'ref_partida',
        'ref_ur',
        'ref_part',
        'cuenta_bancaria_origen',
        'cuenta_aplicacion'
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'ministracion';

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
