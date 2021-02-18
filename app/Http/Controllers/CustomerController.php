<?php

namespace App\Http\Controllers;

use App\ClientNumber;
use App\Customer;
use App\CustomersSession;
use App\CustomerCollector;
use App\Branch;
use App\CustomerCollectorDetail;
use App\Collector;
use App\CustomerStage;
use App\Helpers\CustomersService;
use App\Helpers\Twilio\TwilioService;
use App\Helpers\Utils;
use App\LogRegisters;
use App\VueTables\EloquentVueTables;
use DB;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\get_message_body_summary;
use Hash;
use http\Env\Response;
use http\Message;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Str;
use Validator;
use Yajra\DataTables\DataTables;
use GuzzleHttp\Client;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class CustomerController extends Controller
{
    use AuthenticatesUsers;
    //protected $redirectTo = '/customer/account/';
    /*Here check if the client client number exist in the DB
    if exist return the information to put in the inputs*/
    public function verify_client_number(Request $request){
        $request = $request->input();
        $client_number = '00'.$request['client_number'];
        $verify_client_number = DB::table('client_numbers')->where('client_number',$client_number)->first();
        if ($verify_client_number == null) {
            return response()->json(['success'=>'false', 'verify_client_number'=>'false']);
        }
        $data = Customer::where('client_number', $client_number)->first();
        return response($data);
    }

    //update data in beneficiaries table 
    public function addBeneficiary(Request $request){
        $request       = $request->input();
        $client_number = $request['client_number'];

        //Verify is the email has not a relation with other client number
        $verify_mobile_number = Customer::where('mobile_number', $request['mobile_number'])->first();
        if(!empty($verify_mobile_number)){
            if ($verify_mobile_number->client_number !== $client_number ){
                return response()->json(['success'=>'false', 'verify_mobile_number'=>'false']);
            }
        }
        
        //Check if the client number is already in the DB
        $data = Customer::where('client_number', $client_number)->first();
        $full_last_name = explode(" ", $request['last_name'], 2);
        $last_name = $full_last_name[0];
        $second_last_name = $full_last_name[1];

        //calculated number in associates table
        $number = $this->getNumber($request['customer_id']);

        //insert data in associates table
        $update_associates ='';
        if($data !== null) {
            //insert data in associates table
            $update_associates = DB::table('associates')->insert([
                'customer_id'       => $request['customer_id'],
                'client_number'     => $client_number, //aqui va el id del associate table
                'name'              => $request['name'],
                'last_name'         => $last_name,
                'second_last_name'  => $second_last_name,
                'role'              => isset($request['role']) ? $request['role'] : '',
                'number'            => $number
            ]);
        }

        //get the associate_id
        $associate_id = 0;
        if($update_associates <= 1 || $update_associates === true){
            $associate_id = $this->getAssociateId($last_name, $number);
        }

        //insert data in beneficiaries table
        $update_beneficiary ='';
        if($update_associates <= 1 || $update_associates === true) {
            //insert data in beneficiary table
            $update_beneficiary = DB::table('beneficiaries')->insert([
                'customer_id'      => $request['customer_id'],
                'associate_id'     => $associate_id, //aqui va el id del associate table
                'name'             => $request['name'],
                'last_name'        => $last_name,
                'second_last_name' => $second_last_name,
                'mobile_number'    => $request['mobile_number'],
                'percent'          => $request['percent'],
                'relationship'     => $request['relationship']
            ]);
        }

        if ($update_beneficiary === 1 && $update_associates === 1){
            return response()->json(['success'=>'true', 'update'=>$update_beneficiary,'client_number'=>$request['client_number']]);
        }elseif ($update_beneficiary === true && $update_associates === true){
            return response()->json(['success'=>'true', 'update'=>$update_beneficiary, 'client_number'=>$request['client_number']]);
        }elseif ($update_beneficiary === 0 && $update_associates === 0){
            return response()->json(['success'=>'true', 'update'=>$update_beneficiary, 'client_number'=>$request['client_number']]);
        }
        else{
            return response()->json(['success'=>'false', 'update'=>$update_beneficiary]);
        }
    }

    //function to calculated number of associate
    public function getNumber($customer_id){
        $number = DB::table('associates')
        ->where('customer_id','=', $customer_id)
        ->count();
        if( $number < 6 ){ //limit under 5
            ++$number;
        }else{
            $number; //LIMIT REACHED
        }
        return $number;
    }

    //function to get associate_id
    public function getAssociateId($last_name, $number){
        $match = ['last_name' => $last_name, 'number' => $number];
        $query = DB::table('associates')
        ->where($match)
        ->get();
        return $query[0]->id;
    }

    //Update data in customers table and insert new data en customer_session table
    public function update(Request $request){
        $request          = $request->input();

        //For customer_session table
        $client_number = '00'.$request['client_number'];
        $passwordVerify = $request['password'];
        $passwordConfirm = $request['confirmPassword'];

        if ($passwordVerify !== $passwordConfirm){
            return response()->json(['success'=>'false', 'verify_password'=>'false']);
        }

        $password      = Hash::make($request['password']);

        //Check if the email already has an account

        $verify_email = CustomersSession::where('email', $request['email'])->first();

        if ($verify_email !== null) {
            return response()->json(['success'=>'false', 'verify_email'=>'false']);
        }

        //Verify is the email has not a relation with other client number
        $verify_mobile_number = Customer::where('mobile_number', $request['mobile'])->first();
        if(!empty($verify_mobile_number)){
            if ($verify_mobile_number->client_number !== $client_number ){
                return response()->json(['success'=>'false', 'verify_mobile_number'=>'false']);
            }
        }

        //Verify is the email has not a relation with other client number
        $verify_email_number = Customer::where('email', $request['email'])->first();
        if (!empty($verify_email_number)){
            if ($verify_email_number->client_number !== $client_number ){
                return response()->json(['success'=>'false', 'verify_email_number'=>'false']);
            }
        }


        //Check if the client number is already in the DB
        $data = Customer::where('client_number', $client_number)->first();

        $update_customer ='';
        if($data !== null) {
            //Update data in customers table
            $update_customer = DB::table('customers')->where('client_number', '=', $client_number)->update([
                'name'             => $request['name'],
                'last_name'        => $request['last_name'],
                'second_last_name' => $request['second_last_name'],
                'email'            => $request['email'], //This is for customers_session table too
                'mobile_number'    => $request['mobile'],
                'company'          => isset($request['company']) ? $request['company'] : '',
                'birthday'         => $request['birthday'],
                'rfc'              => isset($request['rfc']) ? $request['rfc'] : '',
                'work'             => isset($request['work']) ? $request['work'] : ''
            ]);
        }

        if ($data == null) {
            //Insert data in customers table
            $update_customer = DB::table('customers')->insert([
                'client_number'    => $client_number,
                'name'             => $request['name'],
                'last_name'        => $request['last_name'],
                'second_last_name' => $request['second_last_name'],
                'email'            => $request['email'], //This is for customers_session table too
                'mobile_number'    => $request['mobile'],
                'company'          => isset($request['company']) ? $request['company'] : '',
                'birthday'         => $request['birthday'],
                'rfc'              => isset($request['rfc']) ? $request['rfc'] : '',
                'work'             => isset($request['work']) ? $request['work'] : ''
            ]);
        }


        $save_register = DB::table('customers_sessions')->insert([
            'client_number' => $client_number,
            'client_type'   => $request['client_type'],
            'email'         => $request['email'],
            'password'      => $password
        ]);

        $name = $request['name'].' '.$request['last_name'].' '.$request['second_last_name'];

        if ($update_customer === 1 && $save_register === true){
            return response()->json(['success'=>'true', 'update'=>$update_customer, 'save'=>$save_register, 'name'=>$name, 'client_number'=>$request['client_number']]);
        }elseif ($update_customer === true && $save_register === true){
            return response()->json(['success'=>'true', 'update'=>$update_customer, 'save'=>$save_register, 'name'=>$name, 'client_number'=>$request['client_number']]);
        }elseif ($update_customer === 0 && $save_register === true){
            return response()->json(['success'=>'true', 'update'=>$update_customer, 'save'=>$save_register, 'name'=>$name, 'client_number'=>$request['client_number']]);
        }
        else{
            return response()->json(['success'=>'false', 'update'=>$update_customer, 'save'=>$save_register]);
        }


    }

    public function login(Request $request){
        //Validando
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'password.min' => 'El usuario y/o contraseña son incorrecto(s), por favor verifique sus datos.'
        ]);

        //Login
        if(Auth::guard('customer')->attempt([
            'email'    => $request->email,
            'password' => $request->password
        ])){
            //dd(Auth::check());
            return redirect()->route('customer.myAccount');

        }else{
            return back()->withInput($request->only('email', 'remember'))->with('error','El usuario y/o contraseña son incorrecto(s), por favor verifique sus datos.');
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    public function account_status(){
        //dd(Auth::user()->client_number);
        $data = Customer::where('client_number', Auth::user()->client_number)->first();
        $tr = $this->get_trans($data['client_number']);
        //dd($customer_trans);
        return view('pages.Account.status', compact('data', 'tr'));
        //return redirect()->route('customer.myAccount');
    }

    public function get_trans($client_number){
        $now = Carbon::now();
        $customer_trans = DB::table('transactions')
            ->join('material_type', 'transactions.tmat', '=', 'material_type.code')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $client_number)
            ->whereMonth('transaction_date','=',$now)
            ->get();
        return $customer_trans;
    }

    public function my_documents() {
        return view('pages.Account.documents');
    }

    public function register_beneficiary () {
        return view('pages.Account.beneficiary');
    }

    public function benefits () {
        return view('pages.Account.benefitSafe');
    }

    public function benefits_signature () {
        return view('pages.Account.signature');
    }

    public function benefits_assistance () {
        return view('pages.Account.assistance');
    }

    public function employees () {
        return view('pages.Account.employees');
    }

    public function update_stage_two(Customer $customer, Request $request){
	    $request = $request->all();
	    if($request['client_type'] === 'otro')
	        $request['client_type'] = $request['other'];

        Validator::make($request,[
            'gender' => 'required',
            'phone' => 'required',
            'birthday' => 'required',
            'client_type' => 'required',
            'street' => 'required',
            'colonia' => 'required',
            'postal_code' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'education' => 'required',
        ],[
            'gender.required' => 'Este campo es obligatorio',
            'phone.required' => 'Este campo es obligatorio',
            'birthday.required' => 'Este campo es obligatorio',
            'client_type.required' => 'Este campo es obligatorio',
            'street.required' => 'Este campo es obligatorio',
            'colonia.required' => 'Este campo es obligatorio',
            'postal_code.required' => 'Este campo es obligatorio',
            'city_id.required' => 'Este campo es obligatorio',
            'state_id.required' => 'Este campo es obligatorio',
            'education.required' => 'Este campo es obligatorio',
        ])->validate();
        try {
            $request['customer_level'] = 3;
            $customer->fill($request);
            $customer->save();
            //Se agrega el stage actual del usuario
            CustomerStage::create(['customer_id' => $customer->id, 'stage'=>2 ]);

            return redirect()->route('collector.stage.two_thanks');
        }catch(\Exception $e){
            //Utils::set_log(0,'Error de sistema '.$e->getCode().' '.$e->getMessage(),null,$request);
            return redirect()->back()->withInput()->with('error','Ocurrio un error verifique sus datos e intentelo de nuevo  '.$e->getMessage());
        }

    }



    public function send_email($name, $email, $token){
    	\Mail::send('Collectors.email_customer',['name'=>$name,'token'=>$token], function($m) use ($email, $name){
    		$m->from('noreply@quaxar.info',"Club Dar");
    		$m->to($email, $name)->subject('Gracias por actualizar tus datos');
	    });
    }

    public function send_email_erick($register){
        \Mail::send('Collectors.email_erick',['register'=>$register], function($m) use ($register){
            $m->from('noreply@quaxar.info',"Club Dar");
            $m->to('eovalle@quaxar.com', 'Erick O.')->subject('Nuevo Registro de Club Dar');
        });
    }

    public function email_validate($token){
    	$register = Customer::where('email_validate',$token)->first();
    	$register->email_validate = 'true';
    	$register->save();
    	return view('Collectors.verify_email', ['name'=> $register->name.' '.$register->last_name]);
    }

    public function phone_validate(Request $request){
        try{
            $register = Customer::where('phone_validate',$request->code)->first();
            if(!$register)
                return ['status' => 0 , 'msg'  => 'El código ingresado es incorrecto'];

            $register->phone_validate = 1;
            $register->save();
            return ['status' => 1 , 'msg'  => 'Process is success'];
        }catch(\Exception $e){
            return ['status' => 0 , 'msg'  => $e->getMessage()];
        }
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
