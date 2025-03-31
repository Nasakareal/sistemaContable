<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaccion;

class TransaccionSeeder extends Seeder
{
    public function run()
    {
        Transaccion::create([
            'tipo' => 'ingreso',
            'monto' => 5000.00,
            'fecha' => now(),
            'descripcion' => 'Ingreso por venta',
            'cuenta_bancaria_id' => 1,
            'capitulo_id' => 1,
            'partida_id' => 1,
            'unidad_responsable_id' => 1,
            'area_id' => 1,
            'solicitud_dev_id' => 1,
        ]);

        Transaccion::create([
            'tipo' => 'egreso',
            'monto' => 1500.00,
            'fecha' => now(),
            'descripcion' => 'Gasto en suministros',
            'cuenta_bancaria_id' => 1,
            'capitulo_id' => 2,
            'partida_id' => 2,
            'unidad_responsable_id' => 2,
            'area_id' => 2,
            'solicitud_dev_id' => null,
        ]);
    }
}
