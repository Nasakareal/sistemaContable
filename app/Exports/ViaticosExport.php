<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ViaticosExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $viaticos;

    public function __construct($viaticos)
    {
        $this->viaticos = $viaticos;
    }

    public function collection()
    {
        return $this->viaticos->flatMap(function ($via) {
            $base = [
                'Empleado'         => $via->empleado->nombre ?? 'N/A',
                'Fondo'            => $via->fondo->nombre   ?? 'N/A',
                'Cuenta Bancaria'  => $via->cuentaBancaria->numero ?? 'N/A',
                'Importe Total'    => $via->importe_total,
                'Fecha Entrega'    => optional($via->fecha_entrega)->format('Y-m-d'),
                'Estatus'          => $via->estatus,
            ];

            if ($via->comprobaciones->isEmpty()) {
                return [(object) array_merge($base, [
                    'Cuenta Contable'     => '—',
                    'Descripción'         => '—',
                    'Monto Comprobado'    => '—',
                    'Tipo'                => '—',
                    'Fecha Comprobación'  => '—',
                ])];
            }

            return $via->comprobaciones->map(function ($c) use ($base) {
                return (object) array_merge($base, [
                    'Cuenta Contable'     => $c->cuenta_contable,
                    'Descripción'         => $c->descripcion ?: '—',
                    'Monto Comprobado'    => $c->monto,
                    'Tipo'                => $c->tipo,
                    'Fecha Comprobación'  => optional($c->fecha_comprobacion)->format('Y-m-d') ?? '—',
                ]);
            });
        });
    }

    public function headings(): array
    {
        return [
            'Empleado',
            'Fondo',
            'Cuenta Bancaria',
            'Importe Total',
            'Fecha Entrega',
            'Estatus',
            'Cuenta Contable',
            'Descripción',
            'Monto Comprobado',
            'Tipo',
            'Fecha Comprobación',
        ];
    }
}
