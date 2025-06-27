<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartidaTransaccion extends Model
{
    use HasFactory;

    protected $table = 'partida_transaccion';

    protected $fillable = [
        'transaccion_id',
        'partida_id',
        'monto',
    ];

    public function transaccion()
    {
        return $this->belongsTo(Transaccion::class);
    }

    public function partida()
    {
        return $this->belongsTo(Partida::class);
    }
}
