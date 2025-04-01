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
            'documento_origen' => 'documento_origen1.pdf',
        ]);

        SolicitudDev::create([
            'codigo' => 'DEV-002',
            'descripcion' => 'Solicitud para papelería',
            'documento_origen' => 'documento_origen2.pdf',
        ]);

        SolicitudDev::create([
            'codigo' => 'DEV-003',
            'descripcion' => 'Solicitud para mantenimiento',
            'documento_origen' => 'documento_origen3.pdf',
        ]);

        SolicitudDev::create([
            'codigo' => 'DEV-004',
            'descripcion' => 'Solicitud para viáticos',
            'documento_origen' => 'documento_origen4.pdf',
        ]);
    }
}
