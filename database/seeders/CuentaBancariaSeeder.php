<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CuentaBancaria;

class CuentaBancariaSeeder extends Seeder
{
    public function run()
    {
        CuentaBancaria::create([
            'fondo_id' => 1,
            'nombre' => 'Cuenta Principal',
            'numero' => '1234567890',
            'saldo' => 10000.00,
        ]);

        CuentaBancaria::create([
            'fondo_id' => 2,
            'nombre' => 'Cuenta Secundaria',
            'numero' => '0987654321',
            'saldo' => 5000.00,
        ]);
    }
}
