<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    use HasFactory;

    protected $fillable = [
        'fondo_id',
        'nombre',
        'numero',
        'saldo',
    ];

    public function fondo()
    {
        return $this->belongsTo(Fondo::class);
    }
}
