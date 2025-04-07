<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fondo extends Model
{
    use HasFactory;

    protected $fillable = [
        'clave',
        'nombre',
        'descripcion'
    ];

    public function cuentasBancarias()
    {
        return $this->hasMany(\App\Models\CuentaBancaria::class);
    }


    public function unidadesResponsables()
    {
        return $this->hasMany(UnidadResponsable::class);
    }
}
