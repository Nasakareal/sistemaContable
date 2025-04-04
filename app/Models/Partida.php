<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'capitulo_id',
    ];

    public function capitulo()
    {
        return $this->belongsTo(Capitulo::class);
    }
}
