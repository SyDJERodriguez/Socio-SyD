<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DailyReport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $data;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($data){
        $this->data = $data;
    }
    public function headings(): array
    {
        return [
            'numero_cliente',
            'numero_destinatario',
            'tipo_cliente',
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'genero',
            'fecha_nacimiento',
            'rfc',
            'razon_social',
            'rfc_compania',
            'email',
            'fecha_registro',
            'activado',
            'telefono',
            'sucursal',
            'CNT'
        ];
    }

    public function collection()
    {
        return new Collection( $this->data );
    }
}
