<?php

namespace App\Exports;

use App\CustomersSession;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class SessionExport implements FromCollection, WithHeadings, ShouldAutoSize
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
            '# Cliente',
            'Nombre(s)',
            'Primer Apellido',
            'Segundo Apellido',
            'RFC',
            'Fecha de Nacimiento',
            'Género'
        ];
    }

    public function collection()
    {
        return new Collection( $this->data );
    }
}
