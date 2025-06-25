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
        return $this->viaticos->flatMap(function($via) {
            // datos base del viático
            $base = [
                'Empleado'         => $via->empleado->nombre ?? 'N/A',
                'Fondo'            => $via->fondo->nombre   ?? 'N/A',
                'Cuenta Bancaria'  => $via->cuentaBancaria->numero ?? 'N/A',
                'Importe Total'    => $via->importe_total,
                'Fecha Entrega'    => $via->fecha_entrega,
                'Estatus'          => $via->estatus,
            ];

            if ($via->comprobaciones->isEmpty()) {
                // sin comprobaciones: una sola fila con espacios vacíos
                return [ (object) array_merge($base, [
                    'Cuenta Contable'   => '—',
                    'Descripción'       => '—',
                    'Monto Comprobado'  => '—',
                    'Tipo'              => '—',
                ]) ];
            }

            // con comprobaciones: una fila por cada comprobación
            return $via->comprobaciones->map(function($c) use($base) {
                return (object) array_merge($base, [
                    'Cuenta Contable'   => $c->cuenta_contable,
                    'Descripción'       => $c->descripcion  ?: '—',
                    'Monto Comprobado'  => $c->monto,
                    'Tipo'              => $c->tipo,
                ]);
            });
        });
    }

    /**
     * Encabezados de la hoja Excel.
     */
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
        ];
    }
}
