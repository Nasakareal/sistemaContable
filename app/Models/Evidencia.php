<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    use HasFactory;

    protected $table = 'evidencias';

    protected $fillable = [
        'solicitud_dev_id',
        'ruta',
    ];

    public function solicitudDev()
    {
        return $this->belongsTo(SolicitudDev::class);
    }
}
