<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BeneficiariesReport implements FromCollection, WithHeadings, ShouldAutoSize
{
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
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'tipo_cliente',
            'telefono',
            'email',
            'nombre_beneficiario',
            'apellido_pat_beneficiario',
            'apellido_mat_beneficiario',
            'porcentaje',
            'relacion',
            'telefono_celular'
        ];
    }

    public function collection()
    {
        return new Collection( $this->data );
    }
}
