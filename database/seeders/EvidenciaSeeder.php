<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evidencia;

class EvidenciaSeeder extends Seeder
{
    public function run()
    {
        Evidencia::create([
            'solicitud_dev_id' => 1,
            'ruta' => 'evidencias/documento_evidencia.pdf',
        ]);
    }
}
