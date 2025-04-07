<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fondo;
use App\Models\CuentaBancaria;
use App\Models\UnidadResponsable;
use App\Models\Partida;
use App\Models\AsignacionPresupuestal;

class AsignacionesPresupuestalesSeeder extends Seeder
{
    public function run()
    {
        $datos = [
            [
                'fondo' => '02',
                'cuenta' => '4911',
                'unidad' => '01', // ← Buscará '01-%'
                'partida' => '421011',
                'monto' => 15886130.00,
                'periodo' => '2025-01',
                'justificacion' => 'Asignación fondo 02 - UR 01',
            ],
            [
                'fondo' => '09',
                'cuenta' => '9445',
                'unidad' => '07',
                'partida' => '421011',
                'monto' => 26249605.00,
                'periodo' => '2025-01',
                'justificacion' => 'Asignación fondo 09 - UR 07',
            ],
            [
                'fondo' => 'AE',
                'cuenta' => '9763',
                'unidad' => '08',
                'partida' => '421011',
                'monto' => 48437095.00,
                'periodo' => '2025-01',
                'justificacion' => 'Asignación fondo AE - UR 08',
            ]
        ];

        foreach ($datos as $dato) {
            $fondo = Fondo::where('clave', $dato['fondo'])->first();
            $cuenta = CuentaBancaria::where('numero', $dato['cuenta'])->first();
            $unidad = UnidadResponsable::where('clave', 'like', $dato['unidad'] . '%')->first(); // ← clave comienza con '01', '07' o '08'
            $partida = Partida::where('nombre', $dato['partida'])->first();

            if ($fondo && $cuenta && $unidad && $partida) {
                AsignacionPresupuestal::updateOrCreate(
                    [
                        'fondo_id' => $fondo->id,
                        'cuenta_bancaria_id' => $cuenta->id,
                        'unidad_responsable_id' => $unidad->id,
                        'partida_id' => $partida->id,
                        'periodo' => $dato['periodo'],
                    ],
                    [
                        'monto' => $dato['monto'],
                        'justificacion' => $dato['justificacion'],
                    ]
                );
            } else {
                \Log::warning("Faltó algo al guardar asignación:", $dato);
            }
        }
    }
}
