<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Capitulo;

class CapituloSeeder extends Seeder
{
    public function run()
    {
        Capitulo::create([
            'nombre'      => '10000',
            'descripcion' => 'SERVICIOS PERSONALES'
        ]);
        Capitulo::create([
            'nombre'      => '20000',
            'descripcion' => 'MATERIALES Y SUMINISTRO'
        ]);
        Capitulo::create([
            'nombre'      => '30000',
            'descripcion' => 'SERVICIOS GENERALES'
        ]);
        Capitulo::create([
            'nombre'      => '40000',
            'descripcion' => 'TRANSFERENCIAS, ASIGNACIONES, SUBSIDIOS Y OTRAS AYUDAS'
        ]);
        Capitulo::create([
            'nombre'      => '50000',
            'descripcion' => 'BIENES MUEBLES, INMUEBLES E INTANGIBLES'
        ]);
        Capitulo::create([
            'nombre'      => '60000',
            'descripcion' => 'INVERSIÓN PÚBLICA'
        ]);
        Capitulo::create([
            'nombre'      => '70000',
            'descripcion' => 'INVERSIONES FINANCIERAS Y OTRAS PROVISIONES'
        ]);
        Capitulo::create([
            'nombre'      => '80000',
            'descripcion' => 'PARTICIPACIONES Y APORTACIONES'
        ]);
        Capitulo::create([
            'nombre'      => '90000',
            'descripcion' => 'DEUDA PÚBLICA'
        ]);
    }
}
