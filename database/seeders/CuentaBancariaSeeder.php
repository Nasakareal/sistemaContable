<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CuentaBancaria;
use App\Models\Fondo;

class CuentaBancariaSeeder extends Seeder
{
    public function run()
    {
        $datos = [
            [
                'clave_fondo' => '02',
                'nombre'      => 'BBVA - 4911',
                'numero'      => '4911',
                'saldo'       => 15562411.00,
            ],
            [
                'clave_fondo' => '09',
                'nombre'      => 'BBVA - 9445',
                'numero'      => '9445',
                'saldo'       => 36836400.00,
            ],
            [
                'clave_fondo' => 'AE',
                'nombre'      => 'BBVA - 9763',
                'numero'      => '9763',
                'saldo'       => 38174019.00,
            ],
            [
                'clave_fondo' => 'MN',
                'nombre'      => 'BBVA - MN',
                'numero'      => 'MN001',
                'saldo'       => 0.00,
            ],

        ];

        foreach ($datos as $dato) {
            $fondo = Fondo::where('clave', $dato['clave_fondo'])->first();

            if ($fondo) {
                CuentaBancaria::updateOrCreate(
                    ['numero' => $dato['numero'] ?: null, 'fondo_id' => $fondo->id],
                    [
                        'nombre' => $dato['nombre'],
                        'saldo'  => $dato['saldo'],
                    ]
                );
            } else {
                \Log::warning("No se encontró el fondo con clave: {$dato['clave_fondo']}");
            }
        }
    }
}
