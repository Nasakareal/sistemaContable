<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    public function run()
    {
        Area::create(['nombre' => 'Área Administrativa', 'descripcion' => 'Área administrativa']);
        Area::create(['nombre' => 'Área Operativa', 'descripcion' => 'Área operativa']);
    }
}
