<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fondo;

class FondoSeeder extends Seeder
{
    public function run()
    {
        // Fondos con unidades responsables
        $fondo1 = Fondo::create(['clave' => '251101021', 'nombre' => 'Fondo 1']);
        $fondo1->unidadesResponsables()->create([
            'clave' => '1603053001053',
            'nombre' => 'Unidad 1603053001053'
        ]);

        $fondo2 = Fondo::create(['clave' => '251528091', 'nombre' => 'Fondo 2']);
        $fondo2->unidadesResponsables()->create([
            'clave' => '1603053001053001',
            'nombre' => 'Unidad 1603053001053001'
        ]);

        $fondo3 = Fondo::create(['clave' => '252511AE1', 'nombre' => 'Fondo 3']);
        $fondo3->unidadesResponsables()->create([
            'clave' => '1603053001053007',
            'nombre' => 'Unidad 1603053001053007'
        ]);

        $fondo4 = Fondo::create(['clave' => '252511MB1', 'nombre' => 'Fondo 4']);
        $fondo4->unidadesResponsables()->create([
            'clave' => '1603053001053008',
            'nombre' => 'Unidad 1603053001053008'
        ]);

        $fondo5 = Fondo::create(['clave' => '252511MN1', 'nombre' => 'Fondo 5']);
        $fondo5->unidadesResponsables()->createMany([
            ['clave' => '01-RECTORIA',         'nombre' => 'RECTORIA'],
            ['clave' => '07-ADMINISTRACION',   'nombre' => 'ADMINISTRACION'],
            ['clave' => "08-ACADEMICO PA'S",   'nombre' => "ACADÉMICO PA'S"],
            ['clave' => "08-ACADEMICO PTC'S",  'nombre' => "ACADÉMICO PTC'S"],
            ['clave' => "08-ACADEMICO TA'S",   'nombre' => "ACADÉMICO TA'S"],
        ]);

        Fondo::create(['clave' => '02', 'nombre' => 'Fondo 02']);
        Fondo::create(['clave' => '09', 'nombre' => 'Fondo 09']);
        Fondo::create(['clave' => 'AE', 'nombre' => 'Fondo AE']);
        Fondo::create(['clave' => 'MB', 'nombre' => 'Fondo MB']);
        Fondo::create(['clave' => 'MN', 'nombre' => 'Fondo MN']);
    }
}
