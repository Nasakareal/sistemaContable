<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnidadResponsable;

class UnidadResponsableSeeder extends Seeder
{
    public function run()
    {
        UnidadResponsable::create(['nombre' => 'UR 1', 'descripcion' => 'Unidad Responsable 1']);
        UnidadResponsable::create(['nombre' => 'UR 2', 'descripcion' => 'Unidad Responsable 2']);
    }
}
