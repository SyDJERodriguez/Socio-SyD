<?php

namespace App\Exports;

use App\LogRegisters;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LogRegistersExport implements FromCollection,  WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LogRegisters::all();
    }

	public function map($log): array
	{
		$detail = json_decode($log->form_data);

		return [
			isset($log->client_number) ? $log->client_number : '',
			isset($log->ip) ? $log->ip : '',
			isset($log->device) ? $log->device : '',
			isset($log->status) ? $log->status : '',
			isset($log->msg) ? $log->msg : '',
			isset($detail->email) ? $detail->email : '',
			isset($detail->name) ? $detail->name : '',
			isset($detail->last_name) ? $detail->last_name : '',
			isset($detail->second_last_name) ? $detail->second_last_name : '',
			isset($detail->mobile_number) ? $detail->mobile_number : '',
			isset($log->created_at) ? $log->created_at : '',
		];
	}

	public function headings(): array
	{
		return [
			'Numero de cliente',
			'IP del dispositivo',
			'Dispositivo',
			'Estatus',
			'Mensaje',
			'Email',
			'Nombre',
			'Apellido paterno',
			'Apellido materno',
			'Teléfono',
			'Fecha'

		];
	}
}
