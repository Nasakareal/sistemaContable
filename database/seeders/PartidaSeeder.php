<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partida;

class PartidaSeeder extends Seeder
{
    public function run()
    {
        Partida::create([
            'nombre'      => '10000',
            'descripcion' => 'SERVICIOS PERSONALES',
            'capitulo_id' => 1,
        ]);
        Partida::create([
            'nombre'      => '20000',
            'descripcion' => 'MATERIALES Y SUMINISTRO',
            'capitulo_id' => 1,
        ]);
        Partida::create([
            'nombre'      => '30000',
            'descripcion' => 'SERVICIOS GENERALES',
            'capitulo_id' => 1,
        ]);
        Partida::create([
            'nombre'      => '40000',
            'descripcion' => 'TRANSFERENCIAS, ASIGNACIONES, SUBSIDIOS Y OTRAS AYUDAS',
            'capitulo_id' => 1,
        ]);
        Partida::create([
            'nombre'      => '50000',
            'descripcion' => 'BIENES MUEBLES, INMUEBLES E INTANGIBLES',
            'capitulo_id' => 1,
        ]);
        Partida::create([
            'nombre'      => '60000',
            'descripcion' => 'INVERSIÓN PÚBLICA',
            'capitulo_id' => 1,
        ]);
        Partida::create([
            'nombre'      => '70000',
            'descripcion' => 'INVERSIONES FINANCIERAS Y OTRAS PROVISIONES',
            'capitulo_id' => 1,
        ]);
        Partida::create([
            'nombre'      => '80000',
            'descripcion' => 'PARTICIPACIONES Y APORTACIONES',
            'capitulo_id' => 1,
        ]);
        Partida::create([
            'nombre'      => '90000',
            'descripcion' => 'DEUDA PÚBLICA',
            'capitulo_id' => 1,
        ]);
    }
}
