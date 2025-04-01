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
            ['clave_fondo' => '02', 'nombre' => 'Cuenta Fondo 02', 'numero' => '0000000002', 'saldo' => 15562411.00],
            ['clave_fondo' => '09', 'nombre' => 'Cuenta Fondo 09', 'numero' => '0000000009', 'saldo' => 36836400.00],
            ['clave_fondo' => 'AE', 'nombre' => 'Cuenta Fondo AE', 'numero' => '00000000AE', 'saldo' => 38174019.00],
            ['clave_fondo' => 'MB', 'nombre' => 'Cuenta Fondo MB', 'numero' => '00000000MB', 'saldo' => 90572830.00],
            ['clave_fondo' => 'MN', 'nombre' => 'Cuenta Fondo MN', 'numero' => '00000000MN', 'saldo' => 0.00],
        ];

        foreach ($datos as $dato) {
            $fondo = Fondo::where('clave', $dato['clave_fondo'])->first();

            if ($fondo) {
                CuentaBancaria::create([
                    'fondo_id' => $fondo->id,
                    'nombre'   => $dato['nombre'],
                    'numero'   => $dato['numero'],
                    'saldo'    => $dato['saldo'],
                ]);
            } else {
                \Log::warning("No se encontró el fondo con clave: {$dato['clave_fondo']}");
            }
        }
    }
}
