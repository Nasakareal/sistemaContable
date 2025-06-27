<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaccion extends Model
{
    use LogsActivity;

    protected $table = 'transacciones';

    protected $fillable = [
        'tipo',
        'monto',
        'fecha',
        'descripcion',
        'cuenta_bancaria_id',
        'capitulo_id',
        'partida_id',
        'unidad_responsable_id',
        'area_id',
        'solicitud_dev_id'
    ];

    /**
     * Configuración del historial
     */
    protected static $logAttributes = [
        'tipo',
        'monto',
        'fecha',
        'descripcion',
        'cuenta_bancaria_id',
        'capitulo_id',
        'partida_id',
        'unidad_responsable_id',
        'area_id',
        'solicitud_dev_id',
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'transaccion';

    public function getLogNameToUse(string $eventName = ''): string
    {
        return static::$logName;
    }

    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }

    public function capitulo()
    {
        return $this->belongsTo(Capitulo::class);
    }

    public function partidas()
    {
        return $this->belongsToMany(Partida::class, 'partida_transaccion')
                    ->withPivot('monto')
                    ->withTimestamps();
    }

    public function unidadResponsable()
    {
        return $this->belongsTo(UnidadResponsable::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function solicitudDev()
    {
        return $this->belongsTo(SolicitudDev::class);
    }
}
