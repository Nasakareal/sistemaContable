<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViaticosComprobacion extends Model
{
    use HasFactory;

    protected $table = 'viaticos_comprobacions';

    protected $fillable = [
        'viatico_id',
        'cuenta_contable',
        'monto',
        'tipo',
    ];

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
