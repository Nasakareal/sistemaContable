<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SolicitudDev;

class SolicitudDevSeeder extends Seeder
{
    public function run()
    {
        SolicitudDev::create([
            'codigo' => 'DEV-001',
            'descripcion' => 'Solicitud para insumos',
            'documento_origen' => 'documento_origen.pdf',
        ]);
    }
}
