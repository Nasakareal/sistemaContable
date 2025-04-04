<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capitulo extends Model
{
    use HasFactory;

    protected $table = 'capitulos';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function partidas()
    {
        return $this->hasMany(Partida::class);
    }
}
