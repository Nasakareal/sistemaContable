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
        'descripcion',
        'monto',
        'tipo',
    ];

    public function viatico()
    {
        return $this->belongsTo(Viatico::class);
    }
}
