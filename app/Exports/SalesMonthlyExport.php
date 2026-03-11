<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesMonthlyExport implements FromCollection, WithHeadings, ShouldAutoSize
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
            'client_number',
            'branch_number',
            'month',
            'total_sales',
            'benefit',
            'client_type',
            'email'
        ];
    }
    public function collection()
    {
        return new Collection( $this->data );
    }
}
