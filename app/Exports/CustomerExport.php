<?php

namespace App\Exports;

use App\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class CustomerExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data =  $data = DB::table('customers')
            ->join('collectors', 'collectors.id', '=', 'customers.collector_id')
            ->select(DB::raw('customers.id, customers.client_number, customers.name, customers.last_name, customers.second_last_name,
                customers.email, customers.mobile_number, collectors.name AS form, customers.str_branch as branch_leads,
                customers.created_at, customers.is_new, (SELECT branches.name FROM branches WHERE branches.id = customers.branch_id) as branch'))
            ->orderBy('customers.id', 'desc')
            ->get();
        return $data;
        //return Customer::all();
    }

	public function map($customer): array
	{
		return [
		    isset($customer->id) ? $customer->id : '',
			isset($customer->client_number) ? $customer->client_number : '',
			isset($customer->name) ? $customer->name: '',
			isset($customer->last_name) ? $customer->last_name : '',
			isset($customer->second_last_name) ? $customer->second_last_name : '',
			isset($customer->email) ? $customer->email : '',
			isset($customer->mobile_number) ? $customer->mobile_number : '',
            isset($customer->branch_leads) ? $customer->branch_leads : '',
            //($customer->phone_validate <= 1)? 'Validado':'No Validado',
			isset($customer->branch) ? $customer->branch : '',
            isset($customer->form) ? $customer->form : '',
            isset($customer->created_at) ? $customer->created_at : '',
			($customer->is_new == 1)? 'Cliente nuevo' : '',
           // isset($customer->source) ? $customer->source : '',

		];
	}

	public function headings(): array
	{
		return [
		    'ID',
			'Numero de cliente',
			'Nombre',
			'Apellido paterno',
			'Apellido materno',
			'Email',
			'Teléfono',
            'Sucursal Leads',
            //'Telefono validado',
			'Sucursal',
            'Source',
            'Fecha de creación',
			'Flag'
		];
	}
}
