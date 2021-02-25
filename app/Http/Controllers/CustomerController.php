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
    public function addEmployee(Request $request){
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

        //calculated number in associates table
        $number = $this->getNumber($request['customer_id']);

        //insert data in associates table
        $update_associates ='';
        if($data !== null) {
            //insert data in associates table
            $update_associates = DB::table('associates')->insert([
                'customer_id'       => $request['customer_id'],
                'client_number'     => $client_number,
                'name'              => $request['name'],
                'last_name'         => $request['last_name'],
                'second_last_name'  => $request['second_last_name'],
                'role'              => isset($request['role']) ? $request['role'] : "",
                'active_association'=> 1,
                'number'            => $number,
                'birthday'          => $request['bday'],
                'created_at'        => date('Y-m-d H:i:s'),
                'mobile_number'     => $request['mobile_number'],
                'email'             => $request['email']
            ]);
        }

        if ($update_associates === 1){
            return response()->json(['success'=>'true', 'update'=>$update_associates,'client_number'=>$request['client_number']]);
        }elseif ($update_associates === true){
            return response()->json(['success'=>'true', 'update'=>$update_associates, 'client_number'=>$request['client_number']]);
        }elseif ($update_associates === 0){
            return response()->json(['success'=>'true', 'update'=>$update_associates, 'client_number'=>$request['client_number']]);
        }
        else{
            return response()->json(['success'=>'false', 'update'=>$update_associates]);
        }
    }

    public function updateEmployee(Request $request){
        $request       = $request->input();
        $client_number = $request['client_number'];

        //Verify is the email has not a relation with other client number
        $verify_mobile_number = Customer::where('mobile_number', $request['mobile_number'])->first();
        if(!empty($verify_mobile_number)){
            if ($verify_mobile_number->client_number !== $client_number ){
                return response()->json(['success'=>'false', 'verify_mobile_number'=>'false']);
            }
        }

        //update data in associates table
        $update_associates ='';
        //update data in associates table
        $update_associates = DB::table('associates')->where('number', '=', $request['number'])->update([
            'customer_id'       => $request['customer_id'],
            'client_number'     => $client_number,
            'name'              => $request['name'],
            'last_name'         => $request['last_name'],
            'second_last_name'  => $request['second_last_name'],
            'role'              => isset($request['role']) ? $request['role'] : "",
            'active_association'=> 1,
            'birthday'          => $request['bday'],
            'updated_at'        => date('Y-m-d H:i:s'),
            'mobile_number'     => $request['mobile_number'],
            'email'             => $request['email']
        ]);

        if ($update_associates === 1){
            return response()->json(['success'=>'true', 'update'=>$update_associates,'client_number'=>$request['client_number']]);
        }elseif ($update_associates === true){
            return response()->json(['success'=>'true', 'update'=>$update_associates, 'client_number'=>$request['client_number']]);
        }elseif ($update_associates === 0){
            return response()->json(['success'=>'true', 'update'=>$update_associates, 'client_number'=>$request['client_number']]);
        }
        else{
            return response()->json(['success'=>'false', 'update'=>$update_associates]);
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
            ++$number; //LIMIT REACHED
        }
        return $number;
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
        /*if(!empty($verify_mobile_number)){
            if ($verify_mobile_number->client_number !== $client_number ){
                return response()->json(['success'=>'false', 'verify_mobile_number'=>'false']);
            }
        }*/

        //Verify is the email has not a relation with other client number
        /*$verify_email_number = Customer::where('email', $request['email'])->first();
        if (!empty($verify_email_number)){
            if ($verify_email_number->client_number !== $client_number ){
                return response()->json(['success'=>'false', 'verify_email_number'=>'false']);
            }
        }*/


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

    public function send_restore_password(Request $request) {
        $request = $request->input();
        $data_session = $verify_email = CustomersSession::where('email', $request['email'])->first();
        $data = Customer::where('client_number', $data_session->client_number)->first();
        try {
            \Mail::send('emails.restorePassword',['data'=>$data], function($m) use ($data){
                $m->from('noreply@quaxar.info',"Club Dar");
                $m->to($data->email, $data->name.' '.$data->last_name)->subject('Restablecer Contraseña Plataforma SYD');
            });
            return response()->json(['success'=>'true','status' =>200]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>'true','status' =>401]);
        }
    }

    public function edit_password($client_number) {
        return view('pages.restorePassword', compact('client_number'));
    }

    public function update_password(Request $request) {

        $request = $request->input();
        $password      = Hash::make($request['password']);
        $update_customer = DB::table('customers_sessions')->where('client_number', '=', $request['client_number'])->update([
            'password' => $password,
        ]);

        if ($update_customer === 1){
            return response()->json(['success'=>'true','status' =>200]);
        }
        return response()->json(['success'=>'false','status' =>401]);
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
        $data = Customer::where('client_number', Auth::user()->client_number)->first();
        return view('pages.Account.documents', compact('data'));
    }

    public function register_beneficiary () {
        $data = Customer::where('client_number', Auth::user()->client_number)->first();

        $beneficiaries = DB::table('beneficiaries')->where('customer_id', $data['id'])->first();
        if($beneficiaries !== null){
            $beneficiary = 'true';
            return view('pages.Account.beneficiary', compact('data', 'beneficiary'));
        }
        return view('pages.Account.beneficiary', compact('data'));
    }

    public function benefits () {
        $data = Customer::where('client_number', Auth::user()->client_number)->first();
        return view('pages.Account.benefitSafe', compact('data'));
    }

    public function benefits_signature () {
        $data = Customer::where('client_number', Auth::user()->client_number)->first();
        return view('pages.Account.signature', compact('data'));
    }

    public function efirm(Request $request){
        //QUITAR CAPTCHA COMMENTAR
        //define('SITE_KEY', '6Lcj42QaAAAAACUH7dgidlq-nEKhvz2crDWbUQJ5');
        //$SECRET_KEY ='6Lcj42QaAAAAAMwOwhWsYwaykqN2448EhRYRPXWP';
        
        //validated with recatpcha
        //if($request['googleResponseToken']){ //if token exist
            //$googleToken = $request['googleResponseToken'];

            /*$response = file_get_contents(
                "https://www.google.com/recaptcha/api/siteverify?secret=". $SECRET_KEY."&response={$googleToken}"
            );
            $response = json_decode($response);
            $response = (array)$response;
            //return response()->json($response);

            if($response['success']){
                if($response['score'] && $response['score'] > 0.5){*/
                    //save the efirm into db
                    $user = Customer::where('client_number', Auth::user()->client_number)->first();
                    $data = DB::table('signatures')
                                ->where('client_number','=',$user['client_number'])
                                ->get();
            
                    $data = json_decode($data);
                    $data = (array)$data;
                    
                    //if dont exists, insert
                    $updateCustomer= '';
                    $idSign ='';
                    if (is_array($data) == true) { //check if an array
                        if(empty($data) === false){
                            $idSign = DB::table('signatures')
                                        ->where('client_number','=',$user['client_number'])
                                        ->update([
                                            'imgData'    => $request['imgData'],
                                            'updated_at' => date('Y-m-d H:i:s')
                                        ]);
                        }

                        if(empty($data) === true){
                            $idSign = DB::table('signatures')->insertGetId([
                                'client_number'   => $user['client_number'],
                                'created_at'      => date('Y-m-d H:i:s'),
                                'imgData'         => $request['imgData'] 
                            ]);
                
                            //then update customer table,signature id
                            $updateCustomer = DB::table('customers_sessions')
                                                ->where('client_number', '=', $user['client_number'])
                                                ->update([
                                                    'signature_id' => $idSign
                                                ]);
                        }
                    }
                    
                    
            
                    if ($idSign === 1 ||  $idSign === true || is_null($idSign) == false){ //if everything ok, redirect
                        return redirect()->route('customer.benefits');
                    }
                //}
                //else u r a robot
            //}
        //}
    }

    public function benefits_assistance () {
        $data = Customer::where('client_number', Auth::user()->client_number)->first();
        return view('pages.Account.assistance', compact('data'));
    }

    public function beneficiaries ()
    {
        $data = Customer::where('client_number', Auth::user()->client_number)->first();
        return view('pages.Account.beneficiaries', compact('data'));
    }
    //load data from associates
    public function employees () {
        $data = Customer::where('client_number', Auth::user()->client_number)->first();
        $associates = DB::table('associates')
                    ->where('client_number','=',$data['client_number'])
                    ->get();
        return view('pages.Account.employees', compact('data','associates'));
    }

    public function editEmployees($user){
        $query = DB::table('associates')
                    ->where('number','=',$user)
                    ->get();
        $employee = $query[0];
        return view('pages.Account.editEmployees', compact('employee','user'));
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


    public function contact_us(Request $request){
        $data = $request->all();
        try {
            \Mail::send('emails.message',['data'=>$data], function($m) use ($data){
                $m->from('noreply@quaxar.info',"Club Dar");
                $m->to('gtzjafet@gmail.com', 'Jafet Gtz')->subject('Nuevo Registro de Club Dar');
            });
            return response()->json(['success'=>'submitted successfully','status' =>200]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>'submitted successfully','status' =>401]);
        }
     }

    protected function guard()
    {
        return Auth::guard();
    }
}
