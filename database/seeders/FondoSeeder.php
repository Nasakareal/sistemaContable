<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fondo;

class FondoSeeder extends Seeder
{
    public function run()
    {
        Fondo::create(['nombre' => 'Fondo A', 'descripcion' => 'Fondo de recursos A']);
        Fondo::create(['nombre' => 'Fondo B', 'descripcion' => 'Fondo de recursos B']);
    }
}
