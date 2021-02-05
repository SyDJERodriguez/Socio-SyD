<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Exports\CustomerExport;
use App\VueTables\EloquentVueTables;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{

    public function index()
    {
        //$data = Customer::with('branch')->latest('updated_at')->orderBy('id', 'desc')->get()->take(100);


        $data = DB::table('customers')
            ->join('collectors', 'collectors.id', '=', 'customers.collector_id')
            ->select(DB::raw('customers.id, customers.client_number, customers.name, customers.last_name, customers.second_last_name,
                customers.email, customers.mobile_number, collectors.name AS form, customers.str_branch as branch_leads,
                customers.created_at, customers.is_new, (SELECT branches.name FROM branches WHERE branches.id = customers.branch_id) as branch'))
            //->selectSub('branches.name From branches Where branches.id =  customers.branch_id','sucursal')
            ->orderBy('customers.id', 'desc')
            ->get();
        //$data = response(-$data);
        //dd($data);
        return view('Admin.Customers.index', compact('data'));
    }

    public function datatable(Request $request){

	    $data = Customer::with('branch')->latest('updated_at')->get()->take(3);
	    return $data;
	    /*return Datatables::of($data)
	                     ->addIndexColumn()
		                 ->addColumn('branch_name', function ($row) {
		                 	if($row->branch)
		                 	    return $row->branch->name;
		                 	elseif ($row->str_branch)
                                return $row->str_branch;

		                 	return '';
		                 })
                        ->addColumn('collector_id', function ($row){
                            if($row->collector_id === 2)
                                return 'Landing Lineas';
                            elseif ($row->collector_id === 3)
                                return 'Landing Leads';
                            elseif ($row->collector_id === 4)
                                return 'Formulario Sucursales';
                            elseif ($row->collector_id === 5)
                                return 'Formulario Clientes';
                            return '';
                        })
					    ->addColumn('flag', function ($row) {
						    $label = ($row->is_new == 1)? 'Cliente nuevo' : 'No';
						    return $label;
					    })
		                ->rawColumns(['flag'])
		                ->make(true);*/

    }

    public function export_all(){

    	return Excel::download(new CustomerExport, 'ClubDarCustomers.xlsx');
    }

    public function customers_json(){
    	$vueDataTables = new EloquentVueTables();
    	$data          = $vueDataTables->get(new Customer, ['id','client_number','name',
		    'last_name','second_last_name', 'email','mobile_number'],['branch']);
    	return response()->json($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $code    = $request->number_client;

        if(strlen($code) != 8){
	        return response()->json(array('message'=>'El código debe tener 8 digitos'),400);
        }

        if($code){
        	//Validando que el codigo no exista
	        $client_number = DB::table('client_numbers_temp')->where('client_number',$code)->first();
	        if($client_number){
		        return response()->json(array('message'=>'El codigo ya existe en el sistema'),400);
	        }
	        /*//Validando que no este en la lista de clientes bloqueados
	        $client_number = DB::table('client_block')->where('client_number',$code)->first();
	        if($client_number){
		        return response()->json(array('message'=>'Este codigo se encuentra bloquado para registro'),400);
	        }*/
	        //se guarda el codigo
	        $res = DB::table('client_numbers_temp')->insert([
	        	'client_number' => $code,
		        'plazo'         => $request->codition,
		        'flags'         => 'new_client,api_insert',
		        'creacion_sap'  => $request->creation_sap,
		        'created_at'    => date('Y-m-d H:i:s')
	        ]);

	        return response()->json(array('message'=>"El código ${code} fue almacenado con éxito", 'data'=>$res),201);

        }else{
        	return response()->json(array('message'=>'No se recibió el parametro client_number'),400);
        }
    }


    public function show(Customer $customer)
    {
        //
    }

    public function edit(Customer $customer)
    {
        //
    }

    public function destroy(Customer $customer)
    {
        //
    }

}
