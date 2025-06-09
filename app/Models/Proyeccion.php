<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyeccion extends Model
{
    use HasFactory;

    protected $table = 'proyecciones';

    protected $fillable = [
        'cuenta_bancaria_id',
        'month',
        'year',
        'monto',
    ];

    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }

    public function getNombreMesAttribute()
    {
        return ucfirst(\Carbon\Carbon::create()->month($this->month)->locale('es')->monthName);
    }

    public function fondo()
    {
        return $this->belongsTo(Fondo::class);
    }

    public function unidadResponsable()
    {
        return $this->belongsTo(UnidadResponsable::class);
    }
}
