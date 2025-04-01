<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaccion;
use Carbon\Carbon;

class TransaccionSeeder extends Seeder
{
    public function run()
    {
        $transacciones = [
            [
                'tipo' => 'ingreso',
                'monto' => 12500.50,
                'fecha' => Carbon::now()->subDays(10),
                'descripcion' => 'Ingreso por venta de producto XYZ a cliente corporativo',
                'cuenta_bancaria_id' => 1,
                'capitulo_id' => 1,
                'partida_id' => 1,
                'unidad_responsable_id' => 1,
                'area_id' => 1,
                'solicitud_dev_id' => 1,
            ],
            [
                'tipo' => 'ingreso',
                'monto' => 23500.00,
                'fecha' => Carbon::now()->subDays(8),
                'descripcion' => 'Ingreso por prestación de servicios de consultoría estratégica',
                'cuenta_bancaria_id' => 1,
                'capitulo_id' => 1,
                'partida_id' => 2,
                'unidad_responsable_id' => 1,
                'area_id' => 1,
                'solicitud_dev_id' => 1,
            ],
            [
                'tipo' => 'egreso',
                'monto' => 45000.00,
                'fecha' => Carbon::now()->subDays(7),
                'descripcion' => 'Egreso por pago de nómina mensual y prestaciones sociales',
                'cuenta_bancaria_id' => 2,
                'capitulo_id' => 2,
                'partida_id' => 3,
                'unidad_responsable_id' => 2,
                'area_id' => 2,
                'solicitud_dev_id' => null,
            ],
            [
                'tipo' => 'egreso',
                'monto' => 8000.75,
                'fecha' => Carbon::now()->subDays(6),
                'descripcion' => 'Egreso por compra de materiales y suministros de oficina',
                'cuenta_bancaria_id' => 2,
                'capitulo_id' => 2,
                'partida_id' => 4,
                'unidad_responsable_id' => 2,
                'area_id' => 2,
                'solicitud_dev_id' => null,
            ],
            [
                'tipo' => 'egreso',
                'monto' => 12000.00,
                'fecha' => Carbon::now()->subDays(5),
                'descripcion' => 'Egreso por mantenimiento y reparación de equipos informáticos',
                'cuenta_bancaria_id' => 3,
                'capitulo_id' => 3,
                'partida_id' => 5,
                'unidad_responsable_id' => 3,
                'area_id' => 3,
                'solicitud_dev_id' => null,
            ],
            [
                'tipo' => 'ingreso',
                'monto' => 50000.00,
                'fecha' => Carbon::now()->subDays(4),
                'descripcion' => 'Ingreso por financiamiento recibido para proyectos estratégicos',
                'cuenta_bancaria_id' => 1,
                'capitulo_id' => 1,
                'partida_id' => 6,
                'unidad_responsable_id' => 1,
                'area_id' => 1,
                'solicitud_dev_id' => 2,
            ],
            [
                'tipo' => 'egreso',
                'monto' => 75000.00,
                'fecha' => Carbon::now()->subDays(3),
                'descripcion' => 'Egreso por inversión en infraestructura y modernización tecnológica',
                'cuenta_bancaria_id' => 2,
                'capitulo_id' => 2,
                'partida_id' => 7,
                'unidad_responsable_id' => 2,
                'area_id' => 2,
                'solicitud_dev_id' => null,
            ],
            [
                'tipo' => 'ingreso',
                'monto' => 3200.00,
                'fecha' => Carbon::now()->subDays(2),
                'descripcion' => 'Ingreso por reembolso de gastos de viaje y representación',
                'cuenta_bancaria_id' => 3,
                'capitulo_id' => 3,
                'partida_id' => 8,
                'unidad_responsable_id' => 3,
                'area_id' => 3,
                'solicitud_dev_id' => 3,
            ],
            [
                'tipo' => 'egreso',
                'monto' => 22000.00,
                'fecha' => Carbon::now()->subDay(),
                'descripcion' => 'Egreso por inversión en campaña de publicidad y marketing digital',
                'cuenta_bancaria_id' => 1,
                'capitulo_id' => 1,
                'partida_id' => 9,
                'unidad_responsable_id' => 1,
                'area_id' => 1,
                'solicitud_dev_id' => null,
            ],
            [
                'tipo' => 'ingreso',
                'monto' => 18000.00,
                'fecha' => Carbon::now(),
                'descripcion' => 'Ingreso por devolución de impuestos y ajustes contables',
                'cuenta_bancaria_id' => 2,
                'capitulo_id' => 2,
                'partida_id' => 10,
                'unidad_responsable_id' => 2,
                'area_id' => 2,
                'solicitud_dev_id' => 4,
            ],
        ];

        foreach ($transacciones as $transaccion) {
            Transaccion::create($transaccion);
        }
    }
}
