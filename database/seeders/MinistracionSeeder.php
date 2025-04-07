<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fondo;
use App\Models\UnidadResponsable;
use App\Models\CuentaBancaria;
use App\Models\Partida;
use App\Models\Ministracion;
use Carbon\Carbon;

class MinistracionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['fecha' => '2025-01-14', 'fondo_clave' => '251528091', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 986434.40, 'tipo_gasto' => 'Nom01-(Ene15)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-01', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-01-30', 'fondo_clave' => '251528091', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 1048371.42, 'tipo_gasto' => 'Nom02-(Ene31)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-01', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-01-14', 'fondo_clave' => '252511AE1', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 986434.40, 'tipo_gasto' => 'Nom01-(Ene15)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-01', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-01-30', 'fondo_clave' => '252511AE1', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 650000.00, 'tipo_gasto' => 'Nom02-(Ene31)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-01', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-01-14', 'fondo_clave' => '251101021', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 457571.76, 'tipo_gasto' => 'Nom01-(Ene15)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-01', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-01-30', 'fondo_clave' => '251101021', 'ur_clave' => '1603053001053007', 'capitulo' => '421011', 'importe' => 70000.00, 'tipo_gasto' => 'N-P CCT', 'descripcion' => 'Prestaciones establecidas por CGT ó CCT', 'periodo' => '2025-01', 'observaciones' => 'Gastos Representacion Sututem'],
            ['fecha' => '2025-01-30', 'fondo_clave' => '251101021', 'ur_clave' => '1603053001053007', 'capitulo' => '421011', 'importe' => 10000.00, 'tipo_gasto' => 'N-P CCT', 'descripcion' => 'Prestaciones establecidas por CGT ó CCT', 'periodo' => '2025-01', 'observaciones' => 'Operatividad de Oficinas Sututem'],
            ['fecha' => '2025-01-30', 'fondo_clave' => '251101021', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 541452.55, 'tipo_gasto' => 'Nom02-(Ene31)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-01', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-02-06', 'fondo_clave' => '252511AE1', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 15908.34, 'tipo_gasto' => 'Nom02-(Ene31)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-01', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-02-06', 'fondo_clave' => '252511AE1', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 91886.33, 'tipo_gasto' => 'Nom02-(Ene31)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-01', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-02-13', 'fondo_clave' => '252511AE1', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 185137.38, 'tipo_gasto' => 'N-P Ligadas', 'descripcion' => 'Aportaciones al IMSS', 'periodo' => '2025-01', 'observaciones' => 'Cuotas Patronales'],
            ['fecha' => '2025-02-14', 'fondo_clave' => '252511AE1', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 1050524.43, 'tipo_gasto' => 'Nom03-(Feb15)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-02', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-02-14', 'fondo_clave' => '252511AE1', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 80732.18, 'tipo_gasto' => 'Nom03-(Feb15)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-02', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-02-27', 'fondo_clave' => '252511AE1', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 80732.18, 'tipo_gasto' => 'Nom04-(Feb28)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-02', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-02-27', 'fondo_clave' => '252511AE1', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 1052008.55, 'tipo_gasto' => 'Nom04-(Feb28)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-02', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-02-13', 'fondo_clave' => '251101021', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 88566.93, 'tipo_gasto' => 'N-P Ligadas', 'descripcion' => 'Aportaciones al IMSS', 'periodo' => '2025-01', 'observaciones' => 'Cuotas Patronales'],
            ['fecha' => '2025-02-14', 'fondo_clave' => '251101021', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 468693.16, 'tipo_gasto' => 'Nom03-(Feb15)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-02', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-02-17', 'fondo_clave' => '251101021', 'ur_clave' => '1603053001053007', 'capitulo' => '421031', 'importe' => 144313.00, 'tipo_gasto' => 'Gasto_3000', 'descripcion' => 'Impuesto sobre nóminas y similares', 'periodo' => '2025-01', 'observaciones' => 'UTM'],
            ['fecha' => '2025-02-18', 'fondo_clave' => '251101021', 'ur_clave' => '1603053001053007', 'capitulo' => '421011', 'importe' => 361400.00, 'tipo_gasto' => 'N-P CCT', 'descripcion' => 'Prestaciones establecidas por CGT ó CCT', 'periodo' => '2025-01', 'observaciones' => 'SUTUTEM - Ayuda Sindical'],
            ['fecha' => '2025-02-18', 'fondo_clave' => '251101021', 'ur_clave' => '1603053001053007', 'capitulo' => '421011', 'importe' => 34000.00, 'tipo_gasto' => 'N-P CCT', 'descripcion' => 'Prestaciones establecidas por CGT ó CCT', 'periodo' => '2025-01', 'observaciones' => 'SUTUTEM - Apoyo Transporte'],
            ['fecha' => '2025-02-27', 'fondo_clave' => '251101021', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 538726.46, 'tipo_gasto' => 'Nom04-(Feb28)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-02', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-02-13', 'fondo_clave' => '251528091', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 185137.38, 'tipo_gasto' => 'N-P Ligadas', 'descripcion' => 'Aportaciones al IMSS', 'periodo' => '2025-01', 'observaciones' => 'Cuotas Patronales'],
            ['fecha' => '2025-02-14', 'fondo_clave' => '251528091', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 80732.18, 'tipo_gasto' => 'Nom03-(Feb15)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-02', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-02-27', 'fondo_clave' => '251528091', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 80732.19, 'tipo_gasto' => 'Nom04-(Feb28)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-02', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-02-27', 'fondo_clave' => '251528091', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 1052008.55, 'tipo_gasto' => 'Nom04-(Feb28)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-02', 'observaciones' => 'Nomina Concurrente'],
            ['fecha' => '2025-02-14', 'fondo_clave' => '251528091', 'ur_clave' => '1603053001053', 'capitulo' => '421011', 'importe' => 1050524.43, 'tipo_gasto' => 'Nom03-(Feb15)', 'descripcion' => 'CONVENIO ESPESIFICO (Suedos y Salarios)', 'periodo' => '2025-02', 'observaciones' => 'Nomina Concurrente'],
        ];

        foreach ($data as $row) {
            $fondo = Fondo::firstOrCreate(
                ['clave' => $row['fondo_clave']],
                ['nombre' => 'Fondo '.$row['fondo_clave']]
            );

            $ur = UnidadResponsable::firstOrCreate(
                ['clave' => $row['ur_clave']],
                ['fondo_id' => $fondo->id, 'nombre' => 'UR '.$row['ur_clave']]
            );

            $partida = Partida::firstOrCreate(
                ['nombre' => $row['capitulo']],
                ['descripcion' => 'Partida '.$row['capitulo'], 'capitulo_id' => 1]
            );

            $cuenta = CuentaBancaria::firstOrCreate(
                ['numero' => '9999'],
                ['fondo_id' => $fondo->id, 'nombre' => 'Cuenta Genérica', 'saldo' => 0]
            );

            Ministracion::create([
                'fecha' => Carbon::parse($row['fecha']),
                'fondo_id' => $fondo->id,
                'unidad_responsable_id' => $ur->id,
                'partida_id' => $partida->id,
                'cuenta_bancaria_id' => $cuenta->id,
                'importe' => $row['importe'],
                'tipo_gasto' => $row['tipo_gasto'],
                'descripcion' => $row['descripcion'],
                'periodo' => $row['periodo'],
                'observaciones' => $row['observaciones'],
            ]);
        }
    }
}
