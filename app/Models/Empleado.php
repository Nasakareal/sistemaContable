<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $connection = 'humanos';
    protected $table = 'empleados';

    public $timestamps = false;

    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = ['nombre'];

    public function test()
    {
        dd('Sí lo está leyendo completo');
    }
}
