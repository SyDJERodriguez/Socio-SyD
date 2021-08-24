<?php

namespace App\Exports;

use App\CustomersSession;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class SessionExport implements FromCollection
{
    protected $data;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($data){
        $this->data = $data;
    }

    public function collection()
    {
        return new Collection( $this->data );
    }
}
