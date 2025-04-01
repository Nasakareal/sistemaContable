<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    public function run()
    {
        Area::create([
            'nombre' => 'Área Administrativa',
            'descripcion' => 'Responsable de la gestión interna, recursos humanos y procesos administrativos'
        ]);

        Area::create([
            'nombre' => 'Área Operativa',
            'descripcion' => 'Encargada de la ejecución directa de actividades y servicios'
        ]);

        Area::create([
            'nombre' => 'Área Técnica',
            'descripcion' => 'Especializada en soporte técnico, infraestructura y sistemas'
        ]);

        Area::create([
            'nombre' => 'Área de Finanzas',
            'descripcion' => 'Gestiona presupuestos, transacciones, contabilidad y fondos'
        ]);

        Area::create([
            'nombre' => 'Área de Proyectos',
            'descripcion' => 'Encargada de la planeación, ejecución y supervisión de proyectos institucionales'
        ]);
    }
}
