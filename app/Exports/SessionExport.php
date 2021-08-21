<?php

namespace App\Exports;

use App\CustomersSession;
use Maatwebsite\Excel\Concerns\FromCollection;

class SessionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CustomersSession::all();
    }
}
