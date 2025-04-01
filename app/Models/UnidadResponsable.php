<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadResponsable extends Model
{
    use HasFactory;

    protected $table = 'unidad_responsables';

    protected $fillable = [
        'clave',
        'nombre',
        'descripcion',
        'fondo_id'
    ];


    public function fondo()
    {
        return $this->belongsTo(Fondo::class);
    }

}
