<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudDev extends Model
{
    use HasFactory;

    protected $table = 'solicitud_devs';

    protected $fillable = [
        'codigo',
        'descripcion',
        'documento_origen',
    ];
}
