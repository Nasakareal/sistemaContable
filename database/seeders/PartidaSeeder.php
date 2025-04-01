<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partida;

class PartidaSeeder extends Seeder
{
    public function run()
    {
        $partidas = [
            ['nombre' => '11301', 'descripcion' => 'Sueldo'],
            ['nombre' => '13101', 'descripcion' => 'Quinquenio'],
            ['nombre' => '13104', 'descripcion' => 'P. Antigüedad'],
            ['nombre' => '13201', 'descripcion' => 'P. Vacacional'],
            ['nombre' => '13202', 'descripcion' => 'Aguinaldo'],
            ['nombre' => '13301', 'descripcion' => 'Horas Extras'],
            ['nombre' => '13414', 'descripcion' => 'Despensa'],
            ['nombre' => '13416', 'descripcion' => 'M. Didáctico'],
            ['nombre' => '15401', 'descripcion' => 'Bono Administrativo'],
            ['nombre' => '15401', 'descripcion' => 'Excelencia al Servicio'],
            ['nombre' => '15401', 'descripcion' => 'Pres No/Ligadas (B/Día Maestro)'],
            ['nombre' => '15401', 'descripcion' => 'Pres No/Ligadas (Día Madre)'],
        ];

        foreach ($partidas as $partida) {
            Partida::create([
                'nombre' => $partida['nombre'],
                'descripcion' => $partida['descripcion'],
                'capitulo_id' => 1,
            ]);
        }
    }
}
