<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UsersSeeder::class,
            FondoSeeder::class,
            CuentaBancariaSeeder::class,
            CapituloSeeder::class,
            PartidaSeeder::class,
            UnidadResponsableSeeder::class,
            AreaSeeder::class,
            SolicitudDevSeeder::class,
            EvidenciaSeeder::class,
            TransaccionSeeder::class,
        ]);
    }
}
