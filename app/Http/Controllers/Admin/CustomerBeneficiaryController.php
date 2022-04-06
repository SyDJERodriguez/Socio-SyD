<?php

namespace App\Http\Controllers\Admin;
use App\CustomerPlatform;
use App\CustomersSession;
use App\Helpers\Twilio\TwilioService;
use Carbon\Carbon;
use App\Customer;
use App\Exports\CustomerExport;
use App\VueTables\EloquentVueTables;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Auth;

class CustomerBeneficiaryController extends Controller
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

            $beneficiaries = DB::table('beneficiaries')
            ->where('customer_id','=', $data->id)
            ->get();
            $beneficiaries = json_decode($beneficiaries);
            $beneficiary = (array)$beneficiaries;//convert to array

            
        //$data = response(-$data);
        //dd($data);
        return view('Admin.beneficiary.index', compact('data','beneficiaries'));
    }

    public function datatable(Request $request){

	    $data = Customer::with('branch')->latest('updated_at')->get()->take(3);
	    return $data;

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

    public function add_beneficiaries (Request $request) {

        $request = $request->input();
        $email = $request['email'][0];

        $data = DB::table('customer_platforms')->where('email', $email)->first();
        $data_session = DB::table('customers_sessions')->where('email', $email)->first();
        $data->branch_number = $data_session->branch_number;
        $account = DB::table('customers_sessions')
        ->where('email', '=', $email)
        ->first();
        $client_number = $account->client_number;
        $branch_number = $account->branch_number;

        $customerData = DB::table('customer_platforms')
            ->where('email', '=', $email)
            ->first();

            $now = Carbon::now();
            $current_month = $now->month;
            $current_year = $now->year;
            $previus_month =$now->month - 1;
    
            if ($previus_month == 0) {
                $current_year = $now->year-1;
                $previus_month =$now->month + 11;
                $data_customer_before = DB::table('transactions')
                ->where('client_number', $client_number)
                ->where('branch_number', $branch_number)
                ->whereMonth('transaction_date','=',$previus_month)
                ->whereYear('transaction_date', '=', $current_year )
                ->get();
            }
            else{
               $data_customer_before = DB::table('transactions')
               ->where('client_number', $client_number)
               ->where('branch_number', $branch_number)
               ->whereMonth('transaction_date','=',$previus_month)
               ->whereYear('transaction_date', '=', $current_year )
               ->get();
            }
            $current_year = $now->year;
            $transactions = DB::table('transactions')
                ->where('client_number', $client_number)
                ->where('branch_number', $branch_number)
                ->whereMonth('transaction_date','=',$current_month)
                ->whereYear('transaction_date', '=', $current_year )
                ->get();
    
            $totalAmount = 0.0;
            $totalAmount_before = 0.0;
    
            foreach ($data_customer_before as $transaction){
                $amount_customer_before = floatval($transaction->amount);
                strpos($transaction->amount, '-') ? $totalAmount_before -= $amount_customer_before : $totalAmount_before += $amount_customer_before ;
    
                $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
                $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
                $transaction->payment_method = $payment_method->payment_method;
                $transaction->sale_office    = $sale_office->sale_office;
            }
    
            foreach ($transactions as $transaction){
                $amount_customer = floatval($transaction->amount);
                strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
    
                $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
                $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
                $transaction->payment_method = $payment_method->payment_method;
                $transaction->sale_office    = $sale_office->sale_office;
            }
    
            $level_before = 0;
            if ($account->client_type!= "2" || $account->client_type !== "5"){
                if ($totalAmount_before>2500 && $totalAmount_before<=4500) {
                    $level_before = 1;
                }
                if ($totalAmount_before>4500 && $totalAmount_before<=7000) {
                    $level_before = 2;
                }
                if ($totalAmount_before>7000) {
                    $level_before = 3;
                }
            }
    
            if ($account->client_type === "2"|| $account->client_type === "5"){
                if ($totalAmount_before>200 && $totalAmount_before<=500) {
                    $level_before = 1;
                }
                if ($totalAmount_before>500 && $totalAmount_before<=1300) {
                    $level_before = 2;
                }
                if ($totalAmount_before>1300) {
                    $level_before = 3;
                }
            }
    
    
            $level = 0;
            if ($account->client_type === "1" || $account->client_type === "3" || $account->client_type === "4"){
                if ($totalAmount>2500 && $totalAmount<=4500) {
                    $level = 1;
                }
                if ($totalAmount>4500 && $totalAmount<=7000) {
                    $level = 2;
                }
                if ($totalAmount>7000) {
                    $level = 3;
                }
            }
    
            if ($account->client_type === "2" || $account->client_type === "5"){
                if ($totalAmount>200 && $totalAmount<=500) {
                    $level = 1;
                }
                if ($totalAmount>500 && $totalAmount<=1300) {
                    $level = 2;
                }
                if ($totalAmount>1300) {
                    $level = 3;
                }
            }
            $now = Carbon::now();
            $user = Auth::user();
            $nowDate = $now->toDateString();
            $nowTime = $now->toTimeString();
            $insert_log = DB::table('log_admin_searches')->insert([
                'user' => $user->email,
                'name' => $user->name,
                'wanted_client' => $email,
                'date' => $nowDate,
                'time' => $nowTime
    
            ]);
    
            $associates = DB::table('associates')
                ->where([['client_number','=',$client_number], ['active_association', '=', 1]])
                ->get();
    
             $beneficiaries = DB::table('beneficiaries')
                            ->where('customer_id','=', $data->id)
                            ->get();
            $beneficiaries = json_decode($beneficiaries);
            $beneficiary = (array)$beneficiaries;//convert to array

        $number = '';
        if ($data_session->client_type === "3"){
            $data = DB::table('customer_platforms')->where('email', $request['email'][0])->first();
            $data->branch_number =  $data_session->branch_number;
            $number = DB::table('associates')
                ->select('number')
                ->where('email', $email)
                ->first();
        }

        $count = 0;
        $total_percent = 0;


        foreach ($request['percent'] as $percent){
            if($percent != ""){
                $count++;
                //Sum the all percent
                $total_percent += intval($percent);
            }
        }

        //Verify if is one o two registers
        $client_number = $data_session->client_number;
        $branch_number = $data_session->branch_number;
        if ($count == 2){
            if ($total_percent !== 100){
                //Here the response if total percent of beneficiaries is not 100
                $error = 'El porcentaje total debe ser de 100%';
                return view('Admin.customerBeneficiary', compact(
                    'error', 'client_number', 'account', 'transactions', 'totalAmount', 'customerData', 'level', 'associates','level_before'));
                //dd($total_percent);
            }

            $valid = false;
            foreach ($request['phone'] as $mobile) {
                $valid = $this->phoneValidator($mobile);

                if ($valid === false){
                    $error = 'Un número de teléfono ingresado no es válido';

                    return view('Admin.customerBeneficiary', compact(
                        'error', 'client_number', 'account', 'transactions', 'totalAmount', 'customerData', 'level', 'associates','level_before'));
                }
            }

            try{
                //Here insert each register of the form
                for ($i = 0; $i<=1; $i++){
                    //valid name,last,secondLast
                    if($request['second_lastname'][$i] == null || $request['lastname'][$i] == null
                        || $request['name'][$i] == null || $request['parent'][$i] == null){
                        $error = 'Un campo se encuentra vacío. Por favor de corroborar datos';

                        return view('Admin.customerBeneficiary', compact(
                            'error', 'client_number', 'account', 'transactions', 'totalAmount', 'customerData', 'level', 'associates','level_before'));
                    }

                    if (isset($request['name'][$i])){
                        if ($request['name'][$i] !== null){
                            $insert = DB::table('beneficiaries')->insert([
                                'name'             => $request['name'][$i],
                                'last_name'        => $request['lastname'][$i],
                                'second_last_name' => $request['second_lastname'][$i],
                                'relationship'     => $request['parent'][$i],
                                'mobile_number'    => $request['phone'][$i],
                                'percent'          => $request['percent'][$i],
                                'customer_id'      => $data->id,
                                'branch_number'    => $request['branch_number'][0]
                            ]);
                        }
                    }
                }

                //$generatePDF = $this->generatePDF();
                //if ($generatePDF === 'success') {
                $success = 'Los beneficiarios han sido agregados correctamente.';
                $beneficiaries = DB::table('beneficiaries')
                    ->where('customer_id','=', $data->id)
                    ->get();
                $beneficiaries = json_decode($beneficiaries);
                $beneficiary = (array)$beneficiaries;//convert to array
                //send email if individual account added a beneficiary
                //if($data_session->client_type === "2"){
                    $this->send_email_alta($data->email);
                //}
                return view('Admin.customerBeneficiary', compact('success','beneficiary','client_number', 'account', 'transactions', 'totalAmount', 'customerData', 'level', 'associates','level_before'));
                //}

            }catch(\Exception $e){
                $error = $e;
                return view('Admin.customerBeneficiary', compact(
                    'error', 'client_number', 'account', 'transactions', 'totalAmount', 'customerData', 'level', 'associates','level_before'));
            }

        }elseif ($count == 1){
            if (intval($request['percent'][0]) !== 100){
                //Here the response if total percent of beneficiaries is not 100
                $error = 'El porcentaje total debe ser de 100%';
                return view('Admin.customerBeneficiary', compact(
                    'error', 'client_number', 'account', 'transactions', 'totalAmount', 'customerData', 'level', 'associates','level_before'));
            }

            //valid name,last,secondLast
            if($request['second_lastname'][0] == null || $request['lastname'][0] == null
                || $request['name'][0] == null || $request['parent'][0] == null){
                $error = 'Un campo se encuentra vacío. Por favor de corroborar datos';

                return view('Admin.customerBeneficiary', compact(
                    'error', 'client_number', 'account', 'transactions', 'totalAmount', 'customerData', 'level', 'associates','level_before'));
            }

            $valid = false;
            $valid = $this->phoneValidator($request['phone'][0]);
            if ($valid === false){
                $error = 'Un número de teléfono ingresado no es válido';

                return view('Admin.customerBeneficiary', compact(
                    'error', 'client_number', 'account', 'transactions', 'totalAmount', 'customerData', 'level', 'associates','level_before'));
            }

            $insertBeneficiary = DB::table('beneficiaries')->insert([
                'name'             => $request['name'][0],
                'last_name'        => $request['lastname'][0],
                'second_last_name' => $request['second_lastname'][0],
                'relationship'     => $request['parent'][0],
                'mobile_number'    => $request['phone'][0],
                'percent'          => $request['percent'][0],
                'customer_id'      => $data->id,
                'branch_number'    => $request['branch_number'][0]
            ]);

            //$generatePDF = $this->generatePDF();

            //if ($generatePDF === 'success'){
            $success = 'El beneficiario ha sido agregado correctamente.';
            $beneficiaries = DB::table('beneficiaries')
                ->where('customer_id','=', $data->id)
                ->get();
            $beneficiaries = json_decode($beneficiaries);
            $beneficiary = (array)$beneficiaries;//convert to array
            //send email if individual account added a beneficiary
            //if($data_session->client_type === "2"){
                $this->send_email_alta($data->email);
            //}

         
            return view('Admin.customerBeneficiary', compact('success','beneficiary','client_number', 'account', 'transactions', 'totalAmount', 'customerData', 'level', 'associates','level_before'));
    
    }
}
public function send_email_alta($email){
    $data = CustomerPlatform::where('email', $email)->first();
    $dataSession = CustomersSession::where('email', $email)->first();

    $route = "/sms_pdf/{$dataSession->client_number}/{$dataSession->branch_number}";
    $url = url($route);
    $messsage = 'Ya estas asegurado con el programa Socio SYD. Descarga tu poliza de Seguro de Accidentes Personales aqui: '.$url;

    try {
        TwilioService::send_sms($messsage,'+52'.$dataSession->mobile);
        \Mail::send('emails.beneficiariesAdded',['data'=>$data], function($m) use ($data){
            $m->from('noreply@syd.com.mx',"Socio SYD");
            $m->to($data->email, $data->name.' '.$data->last_name)->subject('Haz registrado exitosamente a tus beneficiarios en el programa de lealtad SYD');
        });
        return response()->json(['success'=>'true','status' =>200]);
    } catch (\Throwable $th) {
        return response()->json(['success'=>'false','status' =>401]);
    }
}
public function phoneValidator($mobile){
    $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
    try {
        $numberProtocol = $phoneUtil->parse($mobile,"MX");

        $isValidRegion= $phoneUtil->isValidNumberForRegion($numberProtocol,"MX");
        $isValidNum = $phoneUtil->isValidNumber($numberProtocol);
        $isPossibleNum = $phoneUtil->isPossibleNumber($numberProtocol);

        if(substr($mobile,0,3) === "888"){ //validate number china
            return false;
        }

        if($isValidNum === true && $isValidRegion === true && $isPossibleNum === true){
            return true;
        }else{
            return false;
        }
    } catch (\libphonenumber\NumberParseException $e) {
        throw $e;
    }
    return false;
}

}
