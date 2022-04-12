<?php

namespace App\Http\Controllers;

use App\ClientNumber;
use App\Customer;
use App\CustomersSession;
use App\CustomerCollector;
use App\CustomerPlatform;
use App\Branch;
use App\CustomerCollectorDetail;
use App\Collector;
use App\CustomerStage;
use App\Helpers\CustomersService;
use App\Helpers\C3ntroService;
use App\Helpers\Utils;
use App\LogRegisters;
use App\Mail\contactMail;
use App\Office;
use App\VueTables\EloquentVueTables;
use Barryvdh\Reflection\DocBlock\Tag\AuthorTag;
use DB;
use Carbon\Carbon;
use http\Url;
use function GuzzleHttp\Psr7\get_message_body_summary;
use Hash;
use http\Env\Response;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Str;
use Validator;
use Yajra\DataTables\DataTables;
use GuzzleHttp\Client;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use PDF;
use Sabberworm\CSS\CSSList\Document;

class CustomerController extends Controller
{
    use AuthenticatesUsers;
    //protected $redirectTo = '/customer/account/';

    //REGISTER CNT THIS IS TEMPORARY

    public function insertCNTNumber() {
        $client_number = 90000000;
        for ($i = 0; $i<10000; $i++) {
            set_time_limit(30);
            $client_number = strval(++$client_number);
            $client_number = '00'.$client_number;
            DB::table('cnt_numbers')->insert([
                'client_number'    => $client_number,
            ]);
        }
    }

    public function cntRegister(Request $request) {
        $request = $request->input();
        $year = Carbon::now()->year;
        $clientYear = explode("-",$request['birthday']);
        $clientYear = (int)$clientYear[0];
        $age = $year - $clientYear;

        if( $age < 14 == true || $age > 120 == true){
            //bday validation
            return response()->json(['success'=>'false', 'bday'=>'false', 'error'=>'La fecha de nacimiento no es válida']);
        }
        //For customer_session table
        $passwordVerify = $request['password'];
        $passwordConfirm = $request['confirmPassword'];

        if( 'INA2022' !== $request['cnt_number'] ){
            return response()->json(['success'=>'false', 'cnt_number'=>'false']);
        }

        //Validate DNS email
        //$domain = explode('@', $request['email']);
        //$validate_dns = sizeof(dns_get_record($domain[1]));

        // return $validate_dns;
        /*if ($validate_dns <= 0){
            return response()->json(['success'=>'false', 'verify_valid_dns'=>'false']);
        }*/

        if ($passwordVerify !== $passwordConfirm){
            return response()->json(['success'=>'false', 'verify_password'=>'false']);
        }

        $password      = Hash::make($request['password']);

        $client_number= '';
        $number = DB::table('cnt_numbers')
            ->where('registered', '=',1)
            ->pluck('client_number')->toArray();
        $counter = count($number);
        $counter_limit = 1059;
        $counter_total = $counter - $counter_limit;

        if (!empty($request['client_number'])){

            if (0 === $counter_total){
                return response()->json(['success'=>'false', 'count_number'=>'false']);
            }

            $client_number = '00'.$request['client_number'];
            $verify_client_number = DB::table('client_numbers')->where('client_number', '=', $client_number)->first();
            if ($verify_client_number == null) {
                return response()->json(['success'=>'false', 'verify_client_number'=>'false']);
            }
        }else{
            $number = DB::table('cnt_numbers')
                ->where('registered', '=',1)
                ->pluck('client_number')->toArray();
            if (empty($number)){
                $client_number ='0090000001';
            }else{
                if (0 === $counter_total){
                    return response()->json(['success'=>'false', 'count_number'=>'false']);
                }
                $counter = $counter-1;
                $client_number = intval($number[$counter])+1;
                $client_number = strval($client_number);
                $client_number = '00'.$client_number;
            }
        }

        //Check if the email already has an account

        $verify_email = CustomersSession::where('email', $request['email'])->first();

        if ($verify_email !== null) {
            return response()->json(['success'=>'false', 'verify_email'=>'false']);
        }

        //Verify is the email has not a relation with other client number
        $verify_mobile_number = CustomersSession::where('mobile', $request['mobile'])->first();
        if(!empty($verify_mobile_number)){
            if ($verify_mobile_number->client_number !== $client_number ){
                return response()->json(['success'=>'false', 'verify_mobile_number'=>'false']);
            }
        }

      //  if (empty($request['cnt_number'])){
           //if($request['cnt_number'] !== '1000'){
             //   return response()->json(['success'=>'false', 'cnt_number'=>'false']);
           // }
        //}

        //Insert data in customers table
        $update_customer = DB::table('customer_platforms')->insert([
            'client_number'    => $client_number,
            'cnt'              => $request['cnt_number'],
            'name'             => $request['name'],
            'last_name'        => $request['last_name'],
            'second_last_name' => $request['second_last_name'],
            'email'            => $request['email'], //This is for customers_session table too
            'mobile_number'    => $request['mobile'],
            'birthday'         => $request['birthday'],
            'gender'           => isset($request['gender']) ? $request['gender'] : '',
            'rfc'              => isset($request['rfc']) ? $request['rfc'] : '',
            'collector_id'     => 6,
            //'branch_id'        => isset($request['branch_id']) ? $request['branch_id'] : '',
            //'channel'          => isset($request['channel']) ? $request['channel'] : ''
        ]);

        //create data in notifications table
        $update_notifications = DB::table('notifications')->insert([
            'client_number'     => $client_number,
            'name_id'           => 'SEGURO ASISTENCIAS'
        ]);

        $save_register = DB::table('customers_sessions')->insert([
            'client_number' => $client_number,
            'branch_number'     => $client_number,
            'client_type'   => $request['client_type'], //1 duenio; 2 independiente
            'email'         => $request['email'],
            'mobile'        => $request['mobile'],
            'active'        => 0,
            'password'      => $password
        ]);

        $save_transaction = DB::table('transactions')->insert([
            'client_number' => $client_number,
            'branch_number'     => $client_number,
            'amount'            => '250',
            'sale_office'       => '0001',
            'transaction_date'  => Carbon::now()->format('Y-m-d'),
            'payment_method'    => '0',
            'invoce'           => 'INA2022'
        ]);

        $name = $request['name'].' '.$request['last_name'].' '.$request['second_last_name'];

        if ($update_customer === 1 && $save_register === true){
            DB::table('cnt_numbers')->where('client_number', '=', $client_number)->update(['registered' => 1]);
            $this->send_welcome_email($request['email']);
            return response()->json(['success'=>'true', 'update'=>$update_customer, 'save'=>$save_register, 'name'=>$name, 'client_number'=>$client_number]);
        }elseif ($update_customer === true && $save_register === true){
            DB::table('cnt_numbers')->where('client_number', '=', $client_number)->update(['registered' => 1]);
            $this->send_welcome_email($request['email']);
            return response()->json(['success'=>'true', 'update'=>$update_customer, 'save'=>$save_register, 'name'=>$name, 'client_number'=>$client_number]);
        }elseif ($update_customer === 0 && $save_register === true){
            DB::table('cnt_numbers')->where('client_number', '=', $client_number)->update(['registered' => 1]);
            $this->send_welcome_email($request['email']);
            return response()->json(['success'=>'true', 'update'=>$update_customer, 'save'=>$save_register, 'name'=>$name, 'client_number'=>$client_number]);
        }
        else{
            return response()->json(['success'=>'false', 'update'=>$update_customer, 'save'=>$save_register]);
        }

        //return $client_number;
    }

    public function employeeToMechanic(Request $request){
        $request = $request->input();
        $client_number = '00'.$request['client_number'];
        //Remove association
        $update_associates = DB::table('associates')->where('email','=', Auth::user()->email)->update([
            'active_association' => 0
        ]);

        if ($update_associates === 1){
            //Update data in customers sessions table
            $update_customer_session = DB::table('customers_sessions')->where('email','=', Auth::user()->email)->update([
                'client_type'      => "2",
                'is_associate'     => 0,
                'client_number' => $client_number
            ]);
            if ($update_customer_session === 1){
                //Add client number to customer table
                $update_customer = DB::table('customer_platforms')->where('email','=', Auth::user()->email)->update([
                    'client_number' => $client_number
                ]);
                if($update_customer === 1){
                    return response()->json(['success'=>'true']);
                }else{
                    return response()->json(['success'=>'false']);
                }
            }else{
                return response()->json(['success'=>'false']);
            }
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function convertMechanicToDependentByEmail(Request $request){
        $request = $request->input();
        //dd($request);
        $client_number = $request['client_number'];

        $validated = $this->employeeLimit($request['email'],$request['customer_id'], Auth::user()->client_type);
        //dd($validated);
        if ($validated === false){
            return view('pages.limitDependent', ['owner' => $request['owner'], 'success'=> false]);
        }

        //calculated number in associates table
        $number = $this->getNumberAssociate($request['customer_id'],null);
        ++$number; //plus one bc 0 don't exists
        //Remove association
        $update_associates =  DB::table('associates')->insert([
            'customer_id'       => $request['customer_id'],
            'client_number'     => $client_number,
            'name'              => $request['name'],
            'last_name'         => $request['last_name'],
            'second_last_name'  => $request['second_last_name'],
            'active_association'=> 1,
            'number'            => $number,
            'birthday'          => $request['birthday'],
            'created_at'        => date('Y-m-d H:i:s'),
            'mobile_number'     => $request['mobile'],
            'email'             => $request['email']
        ]);

        if ($update_associates){
            //Update data in customers sessions table
            $update_customer_session = DB::table('customers_sessions')->where('email','=', $request['email'])->update([
                'client_type'      => "3",
                'is_associate'     => 1,
                'client_number' => $client_number
            ]);
            if ($update_customer_session === 1){
                //Remove client number to customer table
                $update_customer = DB::table('customer_platforms')->where('email','=', $request['email'])->update([
                    'client_number' => ''
                ]);
                if($update_customer === 1){
                    return view('pages.limitDependent', ['success'=>true, 'owner'=> $request['owner']]);
                }else{
                    return view('pages.limitDependent',['error'=>true]);
                }
            }else{
                return view('pages.limitDependent',['error'=>true]);
            }
        }else{
            return view('pages.limitDependent',['error'=>true]);
        }
    }

    /*Here check if the client client number exist in the DB
    if exist return the information to put in the inputs*/
    public function verify_client_number(Request $request){
        $request = $request->input();
        $client_number = '00'.$request['client_number'];
        $verify_client_number = DB::table('client_numbers')->where('client_number', '=', $client_number)->first();
        if ($verify_client_number == null) {
            return response()->json(['success'=>'false', 'verify_client_number'=>'false']);
        }
        $data = CustomerPlatform::where('client_number', $client_number)->first();
        return response($data);
    }

    public function verify_client_branch(Request $request){
        $request = $request->input();
        $client_number = '00'.$request['client_number'];
        $verify_client_number = DB::table('client_numbers')
        ->where('client_number','=',$client_number)
        ->first();
        if ($verify_client_number == null) {
            return response()->json(['success'=>'false', 'verify_client_number'=>'false']);
        }
        $data = DB::table('client_numbers')
                ->where('client_number', '=', $client_number)
                ->get();
        return response($data);
    }

    //update data in beneficiaries table
    public function addEmployee(Request $request){
        $session = $request;
        $request       = $request->input();
        $client_number = $request['client_number'];

        $year = Carbon::now()->year;
        $clientYear = explode("-",$request['bday']);
        $clientYear = (int)$clientYear[0];
        $age = $year - $clientYear;

        if( $age < 14 == true || $age > 120 == true){
            //bday validation
            return response()->json(['success'=>'false', 'bday'=>'false', 'error'=>'La fecha de nacimiento no es válida']);
        }

        if($request['second_last_name'] == null || $request['last_name'] == null || $request['name'] == null){
            //name, last name or second last name is empty
            return response()->json(['success'=>'false', 'other'=>'false', 'error'=>"Un campo se encuentra vacío. Por favor ingresa tu nombre completo"]);
        }

        //validate mobile number
        $valid = $this->phoneValidator($request['mobile_number']);
        if ($valid == false){
            return response()->json(['success'=>'false', 'verify_valid_mobile'=>'false']);
        }

        //validated email
        $apiKeySYD = "04b09b09ab3c6c723da119fddae6e4f5";
        $client = new Client([
            'base_uri' => 'https://api.towerdata.com/v5/ev?timeout=10&email=' . $request['email'] . '&api_key=' . $apiKeySYD,
            'timeout'  => 3.0,
        ]);

        $response = $client->request('GET');
        $response = json_decode($response->getBody()->getContents());

        if( $response->email_validation->status != 'valid' && $response->email_validation->status != 'unverifiable'){
            return response()->json(['success'=>'false','other'=> 'false','error'=>'El email no existe o no es verificable. Corroborar datos' ]);
        }

        //Validate DNS email
        /*$domain = explode('@', $request['email']);
        //$validate_dns = sizeof(dns_get_record($domain[1]));

        // return $validate_dns;
        if ($validate_dns <= 0){
            return response()->json(['success'=>'false', 'verify_valid_dns'=>'false']);
        }*/

        //Verify is the email has not a relation with other client number
        //$verify_mobile_number = CustomersSession::where('mobile_number', $request['mobile_number'])->first();

        //Verify if the guest has an account
        $verify_mobile_email = DB::table('customers_sessions')
            ->where('mobile', '=', $request['mobile_number'])
            ->orWhere('email', '=', $request['email'])
            ->get();

        $verify_mobile_email = json_decode($verify_mobile_email);
        $verify_mobile_email = (array)$verify_mobile_email;

        //dd(!empty($verify_mobile_email));
        //Check if the account is a mechanic account
        if(!empty($verify_mobile_email)){
            if($verify_mobile_email[0]->client_type == '2'){
                $owner = DB::table('customer_platforms')
                    ->where('client_number', '=', $request['client_number'])
                    ->first();
                $ownerName = $owner->name.' '.$owner->last_name.' '.$owner->second_last_name;

                $data = DB::table('customer_platforms')
                    ->where('email', '=', $request['email'])
                    ->first();
                $information = [
                    'test'=> 'Datos',
                    'customer_id'=> $request['customer_id'],
                    'client_number'=> $request['client_number'],
                    'name' => $data->name,
                    'last_name' => $data->last_name,
                    'second_last_name' => $data->second_last_name,
                    'birthday' => $data->birthday,
                    'mobile' => $data->mobile_number,
                    'email' => $request['email'],
                    'owner' => $ownerName
                ];
                //dd($information);
                $this->inviteMechanicToDependent($information);
                $session->session()->flash('isMechanic', 'the email/mobile number its already in db');
                return response()->json(['succes'=>'true']);
            }
        }

        //Check if th account is an owner account
        if(!empty($verify_mobile_email)){
            if ($verify_mobile_email[0]->client_type == '1' || $verify_mobile_email[0]->client_type == '4'){
                $session->session()->flash('isOwner', 'the email/mobile number its already in db');
                return response()->json(['success'=>'true']);
            }
        }

        //Check if th account is an owner account
        if(!empty($verify_mobile_email)){
            if ($verify_mobile_email[0]->client_type == '3'){
                $session->session()->flash('isDependent', 'the email/mobile number its already in db');
                return response()->json(['success'=>'true']);
            }
        }

        //Verify if the email is associates with other owner
        $query = DB::table('associates')
                    ->where('mobile_number','=',$request['mobile_number'])
                    ->orWhere('email','=',$request['email'])
                    ->where('active_association','=',1)
                    ->get();
        $query = json_decode($query);
        $query = (array)$query;//convert to array

        if (is_array($query) == true && empty($query) === false && $query[0]->active_association == 1){ //check if response exist
            if($query[0]->mobile_number === $request['mobile_number'] || $query[0]->email === $request['email']){
                $session->session()->flash('activeAssociate', 'the email/mobile number its already in db');
                return response()->json(['success'=>'true']);
            }
            $session->session()->flash('activeAssociate', 'the email/mobile number its already in db');
            return response()->json(['success'=>'true']);
        }

        //Verify if the email is deactive association with the current owner
        $deactivate = DB::table('associates')
            ->where('mobile_number','=',$request['mobile_number'])
            ->orWhere('email','=',$request['email'])
            ->where('active_association','=',0)
            ->get();
        $deactivate = json_decode($deactivate);
        $deactivate = (array)$deactivate;//convert to array

        if (is_array($query) == true && empty($query) === false && $query[0]->active_association == 0){ //check if response exist
            $session->session()->flash('deactiveAssociate', 'the email/mobile number its already in db');
            return response()->json(['success'=>'true']);
        }

        //calculated number in associates table
        $number = $this->getNumberAssociate($request['customer_id'],$request['branch_number']);
        ++$number; //plus one bc 0 don't exists

        //insert data in associates table
        $update_associates ='';
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
            'email'             => $request['email'],
            'branch_number'     => isset($request['branch_number']) ? $request['branch_number'] : null
        ]); //debo buscar el associado de aqui en la DB(pasar en lra url el numero de telefono tambien)

        if ($update_associates === 1 || $update_associates === true || $update_associates === 0){
            $this->invitation($request);
            $email = $request['email_auth'];
            //$data = CustomerPlatform::where('email', Auth::user()->email)->first();
            $response = $this->employeeLimit(
                $request['email_auth'],
                $request['customer_id'],
                $request['client_type']);

            if ($response->validated === false){

                $messsage = 'Ya diste de alta exitosamente a todos tus colaboradores en Socio SYD.';

                // TwilioService::send_sms
                C3ntroService::sendSMS($messsage,'+52'.$request['mobile_auth']);
                Mail::send('emails.allEmployees',[], function($m) use ($email){
                    $m->from('sociosyd@syd.com.mx',"Socio SYD");
                    $m->to($email)->subject("Ya diste de alta exitosamente a todos tus colaboradores en Socio SYD");
                });
            }

            $session->session()->flash('success','the email/mobile number its already in db');

            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false', 'update'=>$update_associates]);
        }
    }

    //Update employees
    public function updateEmployee(Request $request){
        $request       = $request->input();
        $client_number = $request['client_number'];

        $year = Carbon::now()->year;
        $clientYear = explode("-",$request['bday']);
        $clientYear = (int)$clientYear[0];
        $age = $year - $clientYear;

        if( $age < 14 == true || $age > 120 == true){
            //bday validation
            return response()->json(['success'=>'false', 'bday'=>'false', 'error'=>'La fecha de nacimiento no es válida']);
        }

        if($request['second_last_name'] == null || $request['last_name'] == null || $request['name'] == null){
            //name, last name or second last name is empty
            return response()->json(['success'=>'false', 'other'=>'false', 'error'=>"Un campo se encuentra vacío. Por favor ingresa tu nombre completo"]);
        }

        //validate mobile number
        $valid = $this->phoneValidator($request['mobile_number']);
        if ($valid == false){
            return response()->json(['success'=>'false', 'verify_valid_mobile'=>'false']);
        }

        //Validate DNS email
        /*$domain = explode('@', $request['email']);
        //$validate_dns = sizeof(dns_get_record($domain[1]));

        // return $validate_dns;
        if ($validate_dns <= 0){
            return response()->json(['success'=>'false', 'verify_valid_dns'=>'false']);
        }*/

        //Verify is the email has not a relation with other client number
        $verify_mobile_number = CustomerPlatform::where('mobile_number', $request['mobile_number'])->first();
        if(!empty($verify_mobile_number)){
            if ($verify_mobile_number->client_number !== $client_number ){
                return response()->json(['success'=>'false', 'verify_mobile_number'=>'false']);
            }
        }

        //update data in associates table
        $update_associates ='';
        //update data in associates table
        $update_associates = DB::table('associates')->where('id', '=', $request['id'])->update([
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

        if ($update_associates === 1 || $update_associates === true || $update_associates === 0){
            //return response()->json(['success'=>'true', 'update'=>$update_associates,'client_number'=>$request['client_number']]);
            return redirect()->route('customer.employees');
        }else{
            return response()->json(['success'=>'false', 'update'=>$update_associates]);
        }

    }
      //update data in beneficiaries table
      public function addEmployeebranch(Request $request){
        $session = $request;
        $request       = $request->input();
        $client_number = $request['client_number'];

        $year = Carbon::now()->year;
        $clientYear = explode("-",$request['bday']);
        $clientYear = (int)$clientYear[0];
        $age = $year - $clientYear;

        if( $age < 14 == true || $age > 120 == true){
            //bday validation
            return response()->json(['success'=>'false', 'bday'=>'false', 'error'=>'La fecha de nacimiento no es válida']);
        }

        if($request['second_last_name'] == null || $request['last_name'] == null || $request['name'] == null){
            //name, last name or second last name is empty
            return response()->json(['success'=>'false', 'other'=>'false', 'error'=>"Un campo se encuentra vacío. Por favor ingresa             tu nombre completo"]);
        }

        //validate mobile number
        $valid = $this->phoneValidator($request['mobile_number']);
        if ($valid == false){
            return response()->json(['success'=>'false', 'verify_valid_mobile'=>'false']);
        }

        //validated email
        $apiKeySYD = "04b09b09ab3c6c723da119fddae6e4f5";
        $client = new Client([
            'base_uri' => 'https://api.towerdata.com/v5/ev?timeout=10&email=' . $request['email'] . '&api_key=' . $apiKeySYD,
            'timeout'  => 3.0,
        ]);

        $response = $client->request('GET');
        $response = json_decode($response->getBody()->getContents());

        if( $response->email_validation->status != 'valid' && $response->email_validation->status != 'unverifiable'){
            return response()->json(['success'=>'false','other'=> 'false','error'=>'El email no existe o no es verificable.             Corroborar datos' ]);
        }

        //Validate DNS email
        /*$domain = explode('@', $request['email']);
        //$validate_dns = sizeof(dns_get_record($domain[1]));

        // return $validate_dns;
        if ($validate_dns <= 0){
            return response()->json(['success'=>'false', 'verify_valid_dns'=>'false']);
        }*/

        //Verify is the email has not a relation with other client number
        //$verify_mobile_number = CustomersSession::where('mobile_number', $request['mobile_number'])->first();

        //Verify if the guest has an account
        $verify_mobile_email = DB::table('customers_sessions')
            ->where('mobile', '=', $request['mobile_number'])
            ->orWhere('email', '=', $request['email'])
            ->get();

        $verify_mobile_email = json_decode($verify_mobile_email);
        $verify_mobile_email = (array)$verify_mobile_email;

        //dd(!empty($verify_mobile_email));
        //Check if the account is a mechanic account
        if(!empty($verify_mobile_email)){
            if($verify_mobile_email[0]->client_type == '2'){
                $owner = DB::table('customer_platforms')
                    ->where('client_number', '=', $request['client_number'])
                    ->first();
                $ownerName = $owner->name.' '.$owner->last_name.' '.$owner->second_last_name;

                $data = DB::table('customer_platforms')
                    ->where('email', '=', $request['email'])
                    ->first();
                $information = [
                    'test'=> 'Datos',
                    'customer_id'=> $request['customer_id'],
                    'client_number'=> $request['client_number'],
                    'name' => $data->name,
                    'last_name' => $data->last_name,
                    'second_last_name' => $data->second_last_name,
                    'birthday' => $data->birthday,
                    'mobile' => $data->mobile_number,
                    'email' => $request['email'],
                    'owner' => $ownerName
                ];
                //dd($information);
                $this->inviteMechanicToDependent($information);
                return response()->json(['success'=>'false','other'=> 'false','error'=>'El email y/o télefono ya está registrado en nuestro programa Socio SYD. Corroborar datos' ]);

            }
        }

        //Check if th account is an owner account
        if(!empty($verify_mobile_email)){
            if ($verify_mobile_email[0]->client_type == '1' || $verify_mobile_email[0]->client_type == '4'){
                return response()->json(['success'=>'false','other'=> 'false','error'=>'El email y/o télefono ya está registrado en nuestro programa Socio SYD. Corroborar datos' ]);
            }
        }

        //Check if th account is an owner account
        if(!empty($verify_mobile_email)){
            if ($verify_mobile_email[0]->client_type == '3'){
                return response()->json(['success'=>'false','other'=> 'false','error'=>'El email y/o télefono ya está registrado en nuestro programa Socio SYD. Corroborar datos' ]);

            }
        }

        //Verify if the email is associates with other owner
        $query = DB::table('associates')
                    ->where('mobile_number','=',$request['mobile_number'])
                    ->orWhere('email','=',$request['email'])
                    ->where('active_association','=',1)
                    ->get();
        $query = json_decode($query);
        $query = (array)$query;//convert to array

        if (is_array($query) == true && empty($query) === false && $query[0]->active_association == 1){ //check if response exist
            if($query[0]->mobile_number === $request['mobile_number'] || $query[0]->email === $request['email']){
                return response()->json(['success'=>'false','other'=> 'false','error'=>'El email y/o télefono ya está registrado en nuestro programa Socio SYD. Corroborar datos' ]);

            }
            return response()->json(['success'=>'false','other'=> 'false','error'=>'El email y/o télefono ya está registrado en nuestro programa Socio SYD. Corroborar datos' ]);

        }

        //Verify if the email is deactive association with the current owner
        $deactivate = DB::table('associates')
            ->where('mobile_number','=',$request['mobile_number'])
            ->orWhere('email','=',$request['email'])
            ->where('active_association','=',0)
            ->get();
        $deactivate = json_decode($deactivate);
        $deactivate = (array)$deactivate;//convert to array

        if (is_array($query) == true && empty($query) === false && $query[0]->active_association == 0){ //check if response exist
            return response()->json(['success'=>'false','other'=> 'false','error'=>'El email y/o télefono ya está registrado en nuestro programa Socio SYD. Corroborar datos' ]);

        }
        //calculated number in associates table
        $number = $this->getNumberAssociate($request['customer_id'],$request['branch_number']);
        ++$number; //plus one bc 0 don't exists

        //insert data in associates table
        $update_associates ='';
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
            'email'             => $request['email'],
            'branch_number'     => isset($request['branch_number']) ? $request['branch_number'] : null
        ]); //debo buscar el associado de aqui en la DB(pasar en lra url el numero de telefono tambien)
       // return redirect()->route('exito');

        if ($update_associates === 1 || $update_associates === true || $update_associates === 0){
            $this->invitation($request);
            $email = $request['email_auth'];
            //$data = CustomerPlatform::where('email', Auth::user()->email)->first();
            $response = $this->employeeLimit(
                $request['email_auth'],
                $request['customer_id'],
                $request['client_type']);

            if ($response->validated === false){

                $messsage = 'Ya diste de alta exitosamente a todos tus colaboradores en Socio SYD.';

                // TwilioService::send_sms
                C3ntroService::sendSMS($messsage,'+52'.$request['mobile_auth']);
                Mail::send('emails.allEmployees',[], function($m) use ($email){
                    $m->from('sociosyd@syd.com.mx',"Socio SYD");
                    $m->to($email)->subject("Ya diste de alta exitosamente a todos tus colaboradores en Socio SYD");
                });
            }

            $session->session()->flash('success','the email/mobile number its already in db');
            return response()->json(['success'=>'true']);

        }else{
           return response()->json(['success'=>'false', 'update'=>$update_associates]);
        }

    }

//load data from associates AQUI
    public function employeesbranch ($email) {
        $dataSession = DB::table('customers_sessions')->where('email', $email)->first();
        $data = DB:: table ('customer_platforms')-> where('email', $email)->first();
        $branch_number=$dataSession->branch_number;
        $client_number= $dataSession->client_number;
        $client_type=$dataSession->client_type;
        $id=$dataSession->client_number;
       //$branch_number = $data_session->branch_number;
       // $data = CustomerPlatform::where('email', Auth::user()->email)->first();
       // $dataSession = CustomersSession::where('email', Auth::user()->email)->first();
        $associates = DB::table('associates')
                            ->where([
                                ['client_number','=',$data->client_number],
                                ['branch_number','=',$dataSession->branch_number],
                                ['active_association', '=', 1]
                                ])
                            ->get();
        //Calculated the limit of employee
        $data = CustomerPlatform::where('email', $email)->first();
      //  $dataSession = CustomersSession::where('email', $email)->first();
        $now = Carbon::now();
        $id=$data->client_number;
        $branch_number=$dataSession->branch_number;
        $data_customer = $this->getTransCadena($email);
        $limit = 0.0;
        foreach ($data_customer as $d){
            //if( date_format(date_create($d->transaction_date)->modify('+2 day'), 'Y-m-d') < date($now->isoformat("Y-MM-D")) ){
            $amount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $limit -= $amount_customer : $limit += $amount_customer ;
            //}
        }

        $validated = false; //var for button validated

        //get number of employees registrados
        $numberEmployees =  $number = DB::table('associates')
        ->where('client_number','=', $client_number)
        ->where('branch_number','=', $branch_number)
        ->where('active_association','=',1)
        ->count();

        $validated = false;
        $limiteAsociados = false;
        //calculated the limit of employees
        if( $limit > 2500 && $limit <= 4500 && $numberEmployees < 4 ){ //bronce
            $validated = true;
        }else if($limit > 4500 && $limit <= 7000 && $numberEmployees < 4){ //plata
            $validated = true;
        }else if($limit > 7000 && $numberEmployees < 8){ //oro
            $validated = true;
        }

        if( $limit > 2500 && $limit <= 4500 && $numberEmployees == 4 ){ //bronce
            $limiteAsociados = true;
        }else if($limit > 4500 && $limit <= 7000 && $numberEmployees == 4){ //plata
            $limiteAsociados = true;
        }else if($limit > 7000 && $numberEmployees == 8){ //oro
            $limiteAsociados = true;
        }

        $data->validated = $validated;
        $data->limiteAsociados = $limiteAsociados;
        $data->number = $numberEmployees;


      //  return $data;
       // $response = $this->employeeLimit(
       //             Auth::user()->email,
       //             $data->id,
       //             Auth::user()->client_type);
       $total = $this->totalAmountById($client_number,$email);
       // $noti = $this->getNotifications();


        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('client_numbers')
                                ->where('branch','=',$dataSession->branch_number)
                                ->get();
        $query = json_decode($query);
        $query = (array)$query;
        if(empty($query) == false){
            $data->branch_name = $query[0]->branch_name;//get branch name to the view
        }
        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;

        return view('pages.registerBeneficiariebranch', compact('data','associates','total','owner','client_type'));
    }


    //Deactivate employees
    public function deleteEmployee($id,$email){
        $data = CustomerPlatform::where('email', Auth::user()->email)->first();
        //update the employee with client number 00000000 and number = 0
        if($email == Auth::user()->email){
            //creo que es con redirect back y meterle un mensaje queno se puede eliminar su propia cuenta
            session()->flash('notDeletableAccount', 'the email is the same of the owner');
            return redirect()->route('customer.employees');
        }
        $update_associates ='';
        $update_associates = DB::table('associates')
                ->where('id','=',$id)
                ->where('client_number','=',$data['client_number'])
                ->update([
                    'number'            => 0,
                    'active_association'=> 0
                ]);
        $deletePlatform = '';
        $deletePlatform = CustomerPlatform::where('email', $email)->delete();

        $deleteSession = '';
        $deleteSession = CustomersSession::where('email', $email)->delete();

        if ($update_associates === 1 || $update_associates === true || $update_associates === 0 && $deletePlatform == 1 && $deleteSession == 1){
            //return response()->json(['success'=>'true', 'update'=>$update_associates,'client_number'=>$request['client_number']]);
            return redirect()->route('customer.employees');
        }else{
            return response()->json(['success'=>'false', 'update'=>$update_associates]);
        }
    }

    //function to calculated number of associate
    public function getNumberAssociate($customer_id,$branch_number){
        //aqui
        //$dataSession = CustomersSession::where('email','=', Auth::user()->email)->first();
        $number = DB::table('associates')
        ->where('customer_id','=', $customer_id)
        ->where('branch_number','=', $branch_number)
        ->where('active_association','=',1)
        ->count();
        return $number;
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

    public function verify_dns(Request $request){
        $request->validate([
            'email' => 'email:rfc,dns'
        ]);
        /*Validator::make($request,[
            'email' => 'email:rfc,dns',
        ],[
            'education.required' => 'Este campo es obligatorio',
        ])->validate();
        try {
            return redirect()->route('collector.stage.two_thanks');
        }catch(\Exception $e){
            return redirect()->back()->withInput()->with('error','Ocurrio un error verifique sus datos e intentelo de nuevo  '.$e->getMessage());
        }*/

    }

    //Update data in customers table and insert new data en customer_session table
    public function update(Request $request){
        $request          = $request->input();

        //For customer_session table
        $client_number = '00'.$request['client_number'];
        $passwordVerify = $request['password'];
        $passwordConfirm = $request['confirmPassword'];

        $year = Carbon::now()->year;
        $clientYear = explode("-",$request['birthday']);
        $clientYear = (int)$clientYear[0];
        $age = $year - $clientYear;

        if( $age < 14 == true || $age > 120 == true){
            //bday validation
            return response()->json(['success'=>'false', 'bday'=>'false', 'error'=>'La fecha de nacimiento no es válida']);
        }

        $dataClient = DB::table('client_numbers')->where('client_number','=',$client_number)->first();
        if($dataClient == null){
            //no exist clientNumber in clientNumbers table
            return response()->json(['success'=>'false', 'verify_client_number'=>'false']);
        }

        if($request['second_last_name'] == null || $request['last_name'] == null || $request['name'] == null){
            //name, last name or second last name is empty
            return response()->json(['success'=>'false', 'other'=>'false', 'error'=>"Un campo se encuentra vacío. Por favor ingresa tu nombre completo"]);
        }

        //validate mobile number
        //$request['mobile'] = $request['mobileLada'] . $request['mobile'];
        $valid = $this->phoneValidator($request['mobile']);
        if ($valid == false){
            return response()->json(['success'=>'false', 'verify_valid_mobile'=>'false']);
        }

        //validated email
        $apiKeySYD = "04b09b09ab3c6c723da119fddae6e4f5";
        $client = new Client([
            'base_uri' => 'https://api.towerdata.com/v5/ev?timeout=10&email=' . $request['email'] . '&api_key=' . $apiKeySYD,
            'timeout'  => 2.0,
        ]);

        $response = $client->request('GET');
        $response = json_decode($response->getBody()->getContents());

        if( $response->email_validation->status != 'valid' && $response->email_validation->status != 'unverifiable'){
            return response()->json(['success'=>'false','other'=> 'false','error'=>'El email no existe o no es verificable. Corroborar datos' ]);
        }


        //Validate DNS email
        /*$domain = explode('@', $request['email']);
        //$validate_dns = sizeof(dns_get_record($domain[1]));

       // return $validate_dns;
        if ($validate_dns <= 0){
            return response()->json(['success'=>'false', 'verify_valid_dns'=>'false']);
        }*/


        if ($passwordVerify !== $passwordConfirm){
            return response()->json(['success'=>'false', 'verify_password'=>'false']);
        }

        $password      = Hash::make($request['password']);

        //Check if the email already has an account

        $verify_email = CustomersSession::where('email', $request['email'])->first();

        if ($verify_email !== null) {
            return response()->json(['success'=>'false', 'verify_email'=>'false']);
        }

        $verify_mobile_number = CustomersSession::where('mobile', $request['mobile'])->first();

        if ($verify_mobile_number !== null) {
            return response()->json(['success'=>'false', 'verify_mobile_number'=>'false']);
        }

        //Check if the client number is already in the DB
        try {
            if($request['client_type'] !== 3){
                $data = CustomersSession::where('client_number', $client_number)->first();
            }else{
                $data = CustomersSession::where('email', $request['email'])->first();
            }

            $data_branch = DB::table('branches_clients')
                                ->where('client_number','=', $client_number)
                                ->first();
        } catch (\Throwable $th) {
            DB::rollback();
            $update_customer = $th;
            throw $th;
        }

        $update_customer ='';
        if($data !== null) {

            if($data_branch !== null){
                //client number already exist in branches, redirect to sucursal
                return response()->json(['success'=>'false', 'verify_data_branch'=>'false']);
            }

            return response()->json(['success'=>'false', 'verify_client'=>'false']);
        }

        if ($data == null) {

            if($data_branch !== null){
                //client number already exist in branches, redirect to sucursal
                return response()->json(['success'=>'false', 'verify_data_branch'=>'false']);
            }

            $update_customer = DB::table('customer_platforms')
                                    ->where('email', '=', $request['email'])
                                    ->first();

            if($update_customer == null){
                //Insert data in customers table
                $update_customer = DB::table('customer_platforms')->insert([
                    'client_number'    => $client_number,
                    'name'             => $request['name'],
                    'last_name'        => $request['last_name'],
                    'second_last_name' => $request['second_last_name'],
                    'email'            => $request['email'], //This is for customers_session table too
                    'mobile_number'    => $request['mobile'],
                    'company'          => isset($request['company']) ? $request['company'] : null,
                    'birthday'         => $request['birthday'],
                    'created_at'       => date('Y-m-d H:i:s'),
                    'rfc'              => isset($request['rfc']) ? $request['rfc'] : null,
                    'work'             => isset($request['work']) ? $request['work'] : null,
                    'gender'           => isset($request['gender']) ? $request['gender'] : null,
                    'collector_id'     => 6,
                    'RFC_Company'      => isset($request['RFC_Company']) ? $request['RFC_Company'] : null,
                    'branch_id'        => isset($request['branch_id']) ? $request['branch_id'] : '',
                    'channel'          => isset($request['channel']) ? $request['channel'] : ''
                ]);
            }else{
                //u[date]
                $update_customer = DB::table('customer_platforms')->where('email', '=', $request['email'])->update([
                    'client_number'    => $client_number,
                    'name'             => $request['name'],
                    'last_name'        => $request['last_name'],
                    'second_last_name' => $request['second_last_name'],
                    'email'            => $request['email'], //This is for customers_session table too
                    'mobile_number'    => $request['mobile'],
                    'company'          => isset($request['company']) ? $request['company'] : null,
                    'birthday'         => $request['birthday'],
                    'created_at'       => date('Y-m-d H:i:s'),
                    'rfc'              => isset($request['rfc']) ? $request['rfc'] : null,
                    'work'             => isset($request['work']) ? $request['work'] : null,
                    'gender'           => isset($request['gender']) ? $request['gender'] : null,
                    'collector_id'     => 6,
                    'RFC_Company'      => isset($request['RFC_Company']) ? $request['RFC_Company'] : null,
                    'branch_id'        => isset($request['branch_id']) ? $request['branch_id'] : '',
                    'channel'          => isset($request['channel']) ? $request['channel'] : ''
                ]);
            }


            if($request['client_type'] != '1'){
                $save_register = DB::table('customers_sessions')->insert([
                    'client_number' => $client_number,
                    'client_type'   => $request['client_type'], //1 duenio; 2 independiente
                    'email'         => $request['email'],
                    'mobile'        => $request['mobile'],
                    'created_at'    => date('Y-m-d H:i:s'),
                    'active'        => 0,
                    'password'      => $password,
                    'is_branch'     => isset($request['is_branch']) ? $request['is_branch'] : 0,
                    'branch_number' => $client_number
                ]);

                //create data in notifications table
                $update_notifications = DB::table('notifications')->insert([
                    'client_number'     => $client_number,
                    'name_id'           => 'SEGURO ASISTENCIAS',
                    'branch_number'     => $client_number
                ]);
            }

            if($request['client_type'] === '1'){
                $save_register = DB::table('customers_sessions')->insert([
                    'client_number' => $client_number,
                    'client_type'   => $request['client_type'], //1 duenio; 2 independiente
                    'email'         => $request['email'],
                    'mobile'        => $request['mobile'],
                    'created_at'    => date('Y-m-d H:i:s'),
                    'active'        => 0,
                    'password'      => $password,
                    'is_branch'     => isset($request['is_branch']) ? $request['is_branch'] : 0,
                    'branch_number' => $client_number
                ]);

                //create data in notifications table
                $update_notifications = DB::table('notifications')->insert([
                    'client_number'     => $client_number,
                    'name_id'           => 'SEGURO ASISTENCIAS',
                    'branch_number'     => $client_number
                ]);

                $idCustomer = DB::table('customer_platforms')
                    ->select('id')
                    ->where('email', '=', $request['email'])
                    ->first();
                $if_associate_email = DB::table('associates')
                    ->select('email')
                    ->where('email', '=', $request['email'])
                    ->first();
                $if_associate_phone = DB::table('associates')
                    ->select('mobile_number')
                    ->where('mobile_number', '=', $request['mobile'])
                    ->first();

                if($if_associate_email === null && $if_associate_phone === null){
                    try {
                        DB::table('associates')->insert([
                            'customer_id'       => $idCustomer->id,
                            'client_number'     => $client_number,
                            'name'              => $request['name'],
                            'last_name'         => $request['last_name'],
                            'second_last_name'  => $request['second_last_name'],
                            'role'              => isset($request['role']) ? $request['role'] : "",
                            'active_association'=> 1,
                            'created_at'        => date('Y-m-d H:i:s'),
                            'number'            => 1,
                            'birthday'          => $request['birthday'],
                            'email'             => $request['email'],
                            'mobile_number'     => $request['mobile'],
                            'branch_number'     => $client_number
                        ]);
                        //code...
                    } catch (\Throwable $th) {
                        DB::rollback();
                        $update_customer = $th;
                        throw $th;
                    }
                }
            }
        }

        $name = $request['name'].' '.$request['last_name'].' '.$request['second_last_name'];

        if ($update_customer === 1 && $save_register === true){
            $this->send_welcome_email($request['email']);
            return response()->json(['success'=>'true', 'update'=>$update_customer, 'save'=>$save_register, 'name'=>$name, 'client_number'=>$request['client_number']]);
        }elseif ($update_customer === true && $save_register === true){
            $this->send_welcome_email($request['email']);
            return response()->json(['success'=>'true', 'update'=>$update_customer, 'save'=>$save_register, 'name'=>$name, 'client_number'=>$request['client_number']]);
        }elseif ($update_customer === 0 && $save_register === true){
            $this->send_welcome_email($request['email']);
            return response()->json(['success'=>'true', 'update'=>$update_customer, 'save'=>$save_register, 'name'=>$name, 'client_number'=>$request['client_number']]);
        }
        else{
            return response()->json(['success'=>'false', 'update'=>$update_customer, 'save'=>$save_register]);
        }
    }

    //insert data with cadenas Form
    public function updateCadena(Request $request){
        $request          = $request->input();

        //For customer_session table
        $client_number = '00'.$request['client_number'];
        $passwordVerify = $request['password'];
        $passwordConfirm = $request['confirmPassword'];
        $year = Carbon::now()->year;
        $clientYear = explode("-",$request['birthday']);
        $clientYear = (int)$clientYear[0];
        $age = $year - $clientYear;

        $dataClient = DB::table('client_numbers')->where('client_number','=',$client_number)->first();
        if($dataClient == null){
            //no exist clientNumber in clientNumbers table
            return response()->json(['success'=>'false', 'verify_client_number'=>'false']);
        }

        if( $age < 14 == true || $age > 120 == true){
            //bday validation
            return response()->json(['success'=>'false', 'bday'=>'false', 'error'=>'La fecha de nacimiento no es válida']);
        }

        if($request['second_last_name'] == null || $request['last_name'] == null || $request['name'] == null){
            //name, last name or second last name is empty
            return response()->json(['success'=>'false', 'other'=>'false', 'error'=>"Un campo se encuentra vacío. Por favor ingresa tu nombre completo"]);
        }

        //validate mobile number
       // $request['mobile'] = $request['mobileLada'] . $request['mobile'];
        $valid = $this->phoneValidator($request['mobile']);
        if ($valid == false){
            return response()->json(['success'=>'false', 'verify_valid_mobile'=>'false']);
        }

        //validated email
        $apiKeySYD = "04b09b09ab3c6c723da119fddae6e4f5";
        $client = new Client([
            'base_uri' => 'https://api.towerdata.com/v5/ev?timeout=10&email=' . $request['email'] . '&api_key=' . $apiKeySYD,
            'timeout'  => 2.0,
        ]);

        $response = $client->request('GET');
        $response = json_decode($response->getBody()->getContents());

        if( $response->email_validation->status != 'valid' && $response->email_validation->status != 'unverifiable'){
            return response()->json(['success'=>'false','other'=> 'false','error'=>'El email no existe o no es verificable. Corroborar datos' ]);
        }

        //Validate DNS email
       /* $domain = explode('@', $request['email']);
        $validate_dns = sizeof(dns_get_record($domain[1]));

       // return $validate_dns;
        if ($validate_dns <= 0){
            return response()->json(['success'=>'false', 'verify_valid_dns'=>'false']);
        }*/

        if ($passwordVerify !== $passwordConfirm){
            return response()->json(['success'=>'false', 'verify_password'=>'false']);
        }

        $password      = Hash::make($request['password']);
        //Check if the email already has an account
        $verify_email = CustomersSession::where('email', $request['email'])->first();
        if ($verify_email !== null) {
            return response()->json(['success'=>'false', 'verify_email'=>'false']);
        }

        $verify_mobile_number = CustomersSession::where('mobile', $request['mobile'])->first();
        if ($verify_mobile_number !== null) {
            return response()->json(['success'=>'false', 'verify_mobile_number'=>'false']);
        }

        $verify_branch_number = CustomersSession::where('branch_number', $request['branch_number'])
                                                ->first();
        if($verify_branch_number !== null){
            return response()->json(['success'=>'false', 'verify_branch_number'=>'false']);
        }

        $data = DB::table('customers_sessions')
                    ->where('client_number','=', $request['client_number'])
                    ->where('email','=', $request['email'])
                    ->first();
        $update_customer ='';
        if($data !== null) {
            return response()->json(['success'=>'false', 'verify_client'=>'false']);
        }

        if ($data == null) {
            $update_customer = DB::table('customer_platforms')
                                ->where('email', '=', $request['email'])
                                ->first();

            if($update_customer == null){
                //Insert data in customers table
                $update_customer = DB::table('customer_platforms')->insert([
                    'client_number'    => $client_number,
                    'name'             => $request['name'],
                    'last_name'        => $request['last_name'],
                    'second_last_name' => $request['second_last_name'],
                    'email'            => $request['email'], //This is for customers_session table too
                    'mobile_number'    => $request['mobile'],
                    'company'          => isset($request['company']) ? $request['company'] : null,
                    'birthday'         => $request['birthday'],
                    'rfc'              => isset($request['rfc']) ? $request['rfc'] : null,
                    'work'             => isset($request['work']) ? $request['work'] : null,
                    'gender'           => isset($request['gender']) ? $request['gender'] : null,
                    'collector_id'     => 6,
                    'RFC_Company'      => isset($request['RFC_Company']) ? $request['RFC_Company'] : null,
                    'created_at'       => date('Y-m-d H:i:s'),
                    'branch_id'        => isset($request['branch_id']) ? $request['branch_id'] : '',
                    'channel'          => isset($request['channel']) ? $request['channel'] : ''
                ]);
            }else{
                $update_customer = DB::table('customer_platforms')->where('email', '=' ,$request['email'])->update([
                    'client_number'    => $client_number,
                    'name'             => $request['name'],
                    'last_name'        => $request['last_name'],
                    'second_last_name' => $request['second_last_name'],
                    'email'            => $request['email'], //This is for customers_session table too
                    'mobile_number'    => $request['mobile'],
                    'company'          => isset($request['company']) ? $request['company'] : null,
                    'birthday'         => $request['birthday'],
                    'rfc'              => isset($request['rfc']) ? $request['rfc'] : null,
                    'work'             => isset($request['work']) ? $request['work'] : null,
                    'gender'           => isset($request['gender']) ? $request['gender'] : null,
                    'collector_id'     => 6,
                    'RFC_Company'      => isset($request['RFC_Company']) ? $request['RFC_Company'] : null,
                    'created_at'       => date('Y-m-d H:i:s'),
                    'branch_id'        => isset($request['branch_id']) ? $request['branch_id'] : '',
                    'channel'          => isset($request['channel']) ? $request['channel'] : ''
                ]);
            }

            //create data in notifications table
            $update_notifications = DB::table('notifications')->insert([
                'client_number'     => $client_number,
                'name_id'           => 'SEGURO ASISTENCIAS',
                'branch_number'     => $request['branch_number']
            ]);

            $save_register = DB::table('customers_sessions')->insert([
                'client_number' => $client_number,
                'client_type'   => $request['client_type'], //1 duenio; 2 independiente
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'active'        => 0,
                'created_at'    => date('Y-m-d H:i:s'),
                'password'      => $password,
                'signature_id'  => isset($request['signature_id']) ? $request['signature_id'] : null,
                'is_branch'     => isset($request['is_branch']) ? $request['is_branch'] : 0,
                'branch_number' => isset($request['branch_number']) ? $request['branch_number'] : null
            ]);
        }

        $name = $request['name'].' '.$request['last_name'].' '.$request['second_last_name'];

        if ($update_customer === 1 && $save_register === true){
            $this->send_welcome_email($request['email']);
            return response()->json(['success'=>'true', 'update'=>$update_customer, 'save'=>$save_register, 'name'=>$name, 'client_number'=>$request['client_number']]);
        }elseif ($update_customer === true && $save_register === true){
            $this->send_welcome_email($request['email']);
            return response()->json(['success'=>'true', 'update'=>$update_customer, 'save'=>$save_register, 'name'=>$name, 'client_number'=>$request['client_number']]);
        }elseif ($update_customer === 0 && $save_register === true){
            $this->send_welcome_email($request['email']);
            return response()->json(['success'=>'true', 'update'=>$update_customer, 'save'=>$save_register, 'name'=>$name, 'client_number'=>$request['client_number']]);
        }
        else{
            return response()->json(['success'=>'false', 'update'=>$update_customer, 'save'=>$save_register]);
        }

    }

    public function updateData(Request $request){
        $session          = $request;
        $request          = $request->input();

        //For customer_session table
        $client_number = '00'.$request['client_number'];

        $year = Carbon::now()->year;
        $clientYear = explode("-",$request['birthday']);
        $clientYear = (int)$clientYear[0];
        $age = $year - $clientYear;

        if( $age < 14 == true || $age > 120 == true){
            //bday validation
            return response()->json(['success'=>'false', 'bday'=>'false', 'error'=>'La fecha de nacimiento no es válida']);
        }

        if($request['second_last_name'] == null || $request['last_name'] == null || $request['name'] == null){
            //name, last name or second last name is empty
            return response()->json(['success'=>'false', 'other'=>'false', 'error'=>"Un campo se encuentra vacío. Por favor ingresa tu nombre completo"]);
        }

        //validate mobile number
       // $request['mobile'] = $request['mobileLada'] . $request['mobile'];
        $valid = $this->phoneValidator($request['mobile']);
        if ($valid == false){
            return response()->json(['success' =>'false',  'verify_valid_mobile'=>'false']);
        }

        if(!empty($request['password'])) {
            $passwordVerify = $request['password'];
            $passwordConfirm = $request['confirmPassword'];

            if ($passwordVerify !== $passwordConfirm) {
                return response()->json(['success' =>'false',  'verify_password'=>'false']);
            }

            $password = Hash::make($request['password']);
        }

        //Check if the email already has an account

        $verify_email = CustomersSession::where('email', $request['email'])->first();

        if ($verify_email == null) {
            $session->session()->flash('msg', 'El email no existe');
            return response()->json(['success' =>'false']);
        }

        //Check if the client number is already in the DB
        $data = DB::table('customer_platforms')->where('email', '=' ,$request['email'])->first();

        $update_customer ='';
        $save_register = '';
        if($data !== null) {
            //si es invitado
            if($request['client_type'] === '3' || $request['client_type'] === 3){

                //Update data in customers table
                $update_customer = DB::table('customer_platforms')
                ->where('email', '=', $request['email'])
                ->update([
                    'name'             => $request['name'],
                    'last_name'        => $request['last_name'],
                    'second_last_name' => $request['second_last_name'],
                    'email'            => $request['email'], //This is for customers_session table too
                    'mobile_number'    => $request['mobile'],
                    'company'          => isset($request['company']) ? $request['company'] : '',
                    'birthday'         => $request['birthday'],
                    'rfc'              => isset($request['rfc']) ? $request['rfc'] : '',
                    'work'             => isset($request['work']) ? $request['work'] : '',
                    'gender'           => isset($request['gender']) ? $request['gender'] : '',
                    'collector_id'     => 6,
                    'RFC_Company'      => isset($request['RFC_Company']) ? $request['RFC_Company'] : '',
                    'branch_id'        => isset($request['branch_id']) ? $request['branch_id'] : '',
                    'channel'        => isset($request['channel']) ? $request['channel'] : ''
                 ]);

                if(isset($password)) {
                    $save_register = DB::table('customers_sessions')->where('email', '=', $request['email'])->update([
                        'mobile'    => $request['mobile'],
                        'password'  => $password,
                    ]);
                }else{
                    $save_register = DB::table('customers_sessions')->where('email', '=', $request['email'])->update([
                        'mobile' => $request['mobile'],
                    ]);
                }
            }else{
                 //Update data in customers table
                 $update_customer = DB::table('customer_platforms')
                                    ->where('client_number', '=', $client_number)
                                    ->where('email','=',$request['email'])->update([
                    'name'             => $request['name'],
                    'last_name'        => $request['last_name'],
                    'second_last_name' => $request['second_last_name'],
                    'email'            => $request['email'], //This is for customers_session table too
                    'mobile_number'    => $request['mobile'],
                    'company'          => isset($request['company']) ? $request['company'] : '',
                    'birthday'         => $request['birthday'],
                    'rfc'              => isset($request['rfc']) ? $request['rfc'] : '',
                    'work'             => isset($request['work']) ? $request['work'] : '',
                    'gender'           => isset($request['gender']) ? $request['gender'] : '',
                    'collector_id'     => 6,
                    'RFC_Company'      => isset($request['RFC_Company']) ? $request['RFC_Company'] : '',
                    'branch_id'        => isset($request['branch_id']) ? $request['branch_id'] : '',
                    'channel'          => isset($request['channel']) ? $request['channel'] : ''
                ]);

                if(isset($password)) {
                    $save_register = DB::table('customers_sessions')
                        ->where('client_number', '=', $client_number)
                        ->where('email', '=', $request['email'])->update([
                            'mobile' => $request['mobile'],
                            'password' => $password
                        ]);
                }else{
                    $save_register = DB::table('customers_sessions')
                        ->where('client_number', '=', $client_number)
                        ->where('email', '=', $request['email'])->update([
                            'mobile' => $request['mobile'],
                        ]);
                }
            }
        }

        if (($update_customer == 1 || $update_customer == 0) || $save_register == 1 ){
            $session->session()->flash('exito', 'Se actualizaron los datos');
            return response()->json(['success' =>'true']);
        }else{
            $session->session()->flash('msg', 'Algo salió mal');
            return response()->json(['success' =>'false']);
        }
    }

    public function forgotClientNumber(Request $request){
        if(($request['email'] === '' || $request['email'] === null) && ($request['mobile_number'] === '' || $request['mobile_number'] === null)){
            return redirect()->back()->with('msg', 'No se pudo recuperar el número de cliente');
        }

        if($request['email'] == '' || $request['email'] == null){
            //buscamo con el mobile number
            $data = Customer::where('mobile_number', $request['mobile_number'])->first();
            if($data == null){
                return redirect()->back()->with('msg','El número de teléfono no existe en el sistema');
            }
            return redirect()->back()->with('forgot', $data->client_number);

        }
        if($request['mobile_number'] == '' || $request['mobile_number'] == null){
            //buscamos con el email
            $data = Customer::where('email', $request['email'])->first();
            if($data == null){
                return redirect()->back()->with('msg', 'El email no existe en el sistema');
            }
            return redirect()->back()->with('forgot', $data->client_number);
        }

        // if se llenen ambos campos
        if(isset($request['mobile_number']) && isset($request['email'])){
            $dataMobile = Customer::where('mobile_number', $request['mobile_number'])->first();
            $dataEmail = Customer::where('email', $request['email'])->first();

            if($dataMobile == null && $dataEmail == null){
                return redirect()->back()->with('msg','El número de teléfono o email no existe en el sistema');

            }else if($dataMobile != null){
                return redirect()->back()->with('forgot', $dataMobile->client_number);

            }else{
                return redirect()->back()->with('forgot', $dataEmail->client_number);
            }
        }
        return redirect()->back()->with('msg', 'Algo salió mal.');
    }

    //form invitation sign up
    public function signUpInvitation(Request $request){
        $request['client_number'] = '00'.$request['client_number'];
        //For customer_session table
        $passwordVerify = $request['password'];
        $passwordConfirm = $request['confirmPassword'];
        $year = Carbon::now()->year;
        $clientYear = explode("-",$request['birthday']);
        $clientYear = (int)$clientYear[0];
        $age = $year - $clientYear;

        if( $age < 14 == true || $age > 120 == true){
            //bday validation
            return redirect()->back()->with('msg', 'La fecha de nacimiento no es válida');
        }

        if($request['second_last_name'] == null || $request['last_name'] == null || $request['name'] == null){
            //name, last name or second last name is empty
            return redirect()->back()->with('msg', 'Un campo se encuentra vacío. Por favor ingresa tu nombre completo');
        }

        //validate mobile number
        $valid = $this->phoneValidator($request['mobile']);
        if ($valid == false){
            return redirect()->back()->with('msg', 'El número ingresado no es válido');
        }

        //Validate DNS email
        /*$domain = explode('@', $request['email']);
        $validate_dns = sizeof(dns_get_record($domain[1]));

        // return $validate_dns;
        if ($validate_dns <= 0){
            return redirect()->back()->with('msg', 'Correo electrónico no válido');
        }*/

        if ($passwordVerify !== $passwordConfirm){
            return redirect()->back()->with('msg', 'Las contraseñas no coinciden.');
        }

        $password = Hash::make($request['password']);

        //Check if the email already has an account
        $verify_email = CustomersSession::where('email', $request['email'])->first();
        if ($verify_email !== null) {
            return redirect()->back()->with('msg', 'El email ingresado ya existe.');
        }

        //Check if the client number is already in the DB
        $data = DB::table('customer_platforms')->where('client_number', '=', $request['client_number'])->first();

        $update_customer ='';
        if ($data == null) {
            //si no existe redirect hacia atras  mostrar error
            return redirect()->back()->with('msg', 'El número de cliente no existe.');
        }

        //Verify is the email has not a relation with other client number
        $verify_mobile_number = CustomersSession::where('mobile', $request['mobile'])->first();
        if(!empty($verify_mobile_number)){
            if ($verify_mobile_number->client_number !== $request['client_number'] ){
                return redirect()->back()->with('msg', 'El número de telefono ya existe.');
            }
        }

        //Verify is the email has not a relation with other client number
        $verify_email_number = CustomersSession::where('email', $request['email'])->first();
        if (!empty($verify_email_number)){
            if ($verify_email_number->client_number !== $request['client_number'] ){
                return redirect()->back()->with('msg', 'El email ingresado ya existe.');
            }
        }

        $save_register = DB::table('customers_sessions')->insert([
            'client_number' => $request['client_number'],
            'client_type'   => $request['client_type'], //1 duenio; 2 independiente
            'email'         => $request['email'],
            'mobile'        => $request['mobile'],
            'active'        => 0,
            'password'      => $password,
            'signature_id'  => 0,
            'is_associate'  => 1,
            'branch_number' => $request['client_number']
        ]);

        //update Data in associate table
        $update_associates =  DB::table('associates')->where('email','=',$request['email'])->update([
            'name'              => $request['name'],
            'last_name'         => $request['last_name'],
            'second_last_name'  => $request['second_last_name'],
            'birthday'          => $request['birthday'],
            'updated_at'        => date('Y-m-d H:i:s'),
            'mobile_number'     => $request['mobile'],
            'email'             => $request['email']
        ]);

        //Insert data in customers table
        $update_customer = DB::table('customer_platforms')->insert([
            'client_number'    => $request['client_number'],
            'name'             => $request['name'],
            'last_name'        => $request['last_name'],
            'second_last_name' => $request['second_last_name'],
            'email'            => $request['email'], //This is for customers_session table too
            'mobile_number'    => $request['mobile'],
            'company'          => isset($request['company']) ? $request['company'] : null,
            'birthday'         => $request['birthday'],
            'rfc'              => isset($request['rfc']) ? $request['rfc'] : null,
            'work'             => isset($request['work']) ? $request['work'] : null,
            'gender'           => isset($request['gender']) ? $request['gender'] : null,
            'branch_id'     => isset($request['branch_id']) ? $request['branch_id'] : '',
            'channel'       => isset($request['channel']) ? $request['channel'] : ''
        ]);

        if ( $save_register === true){
            $this->welcome_email_is_associate($request);
            return view('pages.activateInvitationPage');
        }
        else{
            return redirect()->back()->with('msg', 'Algo salio mal, no se completó el registro.');
        }
    }


    //Send welcome email
    public function send_welcome_email($email) {
        $data = CustomerPlatform::where('email', $email)->first();
        $dataSession = CustomersSession::where('email', $email)->first();
        $data->branch_number = $dataSession->branch_number;

        $url = url('account/verify/' . $data->branch_number);
        $messsage = 'Bienvenido a Socio SYD, por favor verifica tu cuenta dando clic en el siguiente enlace: '.$url;

        // TwilioService::send_sms
        C3ntroService::sendSMS($messsage,'+52'.$dataSession->mobile);

        try {
            \Mail::send('emails.signUpWelcomeNewVersion',['data'=>$data], function($m) use ($data){
                $m->from('sociosyd@syd.com.mx',"Socio SYD");
                $m->to($data->email, $data->name.' '.$data->last_name)->subject('Da clic en el botón y activa tu cuenta de Socio SYD');
            });

            $update_customer = CustomersSession::where('branch_number', '=', $dataSession->branch_number)->update([
                'active'   => 0
            ]);
            return response()->json(['success'=>'true','status' =>200]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>'false','status' =>401]);
        }
    }

    //Send welcome email
     public function welcome_email_is_associate($data) {
         $information = CustomerPlatform::where('email', $data['email'])->first();
         $dataSession = CustomersSession::where('email', $data['email'])->first();
         $information->branch_number = $dataSession->branch_number;

         $url = url('account/verify/' . $information->branch_number);
         $messsage = 'Bienvenido a Socio SYD, por favor verifica tu cuenta dando clic en el siguiente enlace: '.$url;

        //  TwilioService::send_sms
         C3ntroService::sendSMS($messsage,'+52'.$dataSession->mobile);
        try {
            \Mail::send('emails.signUpWelcomeNewVersion',['data'=>$data], function($m) use ($data){
                $m->from('sociosyd@syd.com.mx',"Socio SYD");
                $m->to($data['email'], $data['name'].' '.$data['last_name'])->subject('Da clic en el botón y activa tu cuenta de Socio SYD');
            });
            return response()->json(['success'=>'true','status' =>200]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>'true','status' =>401]);
        }
    }

    //Verify account
    public function verify_account($branch_number = null) {
        $data = CustomersSession::where('branch_number', $branch_number)->first();
        if ($data->active === 1){
            $activated = true;
            return view('pages.activationPage', compact('activated'));
        }
        $update_customer = DB::table('customers_sessions')->where('branch_number', '=', $branch_number)->update([
            'active'   => 1
            

        ]);

        if ($update_customer){
            $activated = false;
            return view('pages.activationPage', compact('activated'));
        }
    }

    public function verify_invitation($email = null){
        $data = DB::table('customers_sessions')
                    ->where('email','=', $email)
                    ->get();
        $data = json_decode($data);
        $data = (array)$data;//convert to array

        if ( is_array($data) == true && empty($data) == false && $data[0]->active === 1){
            $activated = true;
            return view('pages.activationPage', compact('activated'));
        }
        $update_customer = DB::table('customers_sessions')->where('email', '=', $email)->update([
            'active'   => 1
        ]);

       // $url = url('password/edit/' . $data[0]->branch_number);
        $url= asset('files/Diploma_Socio_SyD.pdf');
        //$messsage = 'Por seguridad, le pedimos que cambie su contraseña registrada inicialmente dando clic en el siguiente enlace: '.$url;

        $messsage = 'Te has registrado exitosamente en el programa Socio SYD. Descarga tu diploma de registro aqui: '.$url;
        $messsage_two = 'Descubre todos los beneficios que tienes en tu cuenta individual por ser Socio SYD. Ingresa aqui para mas informacion: www.sociosyd.com.mx';
        $messsage_three = 'Descubre todos los beneficios que tienes en tu cuenta de negocios por ser Socio SYD. Ingresa aqui para mas informacion: www.sociosyd.com.mx';

        $client_type = $data[0]->client_type;
        $mobile = $data[0]->mobile;


        try {
            // TwilioService::send_sms
            C3ntroService::sendSMS($messsage,'+52'.$data[0]->mobile);

            $data = CustomerPlatform::where('email', $email)->first();
            \Mail::send('emails.registroExitoso',['data'=>$data], function($m) use ($data){
                $m->from('sociosyd@syd.com.mx',"Socio SYD");
                $m->to($data->email, $data->name.' '.$data->last_name)->subject('Bienvenido al programa de lealtad SYD');
            });
            \Mail::send('emails.Diploma',['data'=>$data], function($m) use ($data){
                $m->from('sociosyd@syd.com.mx',"Socio SYD");
                $m->to($data->email, $data->name.' '.$data->last_name)->subject('Felicidades, ya eres parte de Socio SYD');
            });

            if($client_type === '1' || $client_type === '4'){
                // TwilioService::send_sms
                C3ntroService::sendSMS($messsage_three,'+52'.$mobile);
                \Mail::send('emails.companyBenefits',['data'=>$data], function($m) use ($data){
                    $m->from('sociosyd@syd.com.mx',"Socio SYD");
                    $m->to($data->email, $data->name.' '.$data->last_name)->subject('Beneficios de tu cuenta con Colaboradores en Socio SyD');
                });
            }elseif ($client_type === '2' || $client_type === '5'){
                // TwilioService::send_sms
                C3ntroService::sendSMS($messsage_two,'+52'.$mobile);
                \Mail::send('emails.individualBenefits',['data'=>$data], function($m) use ($data){
                    $m->from('sociosyd@syd.com.mx',"Socio SYD");
                    $m->to($data->email, $data->name.' '.$data->last_name)->subject('Beneficios de tu cuenta Individual en Socio SyD');
                });
            }
            if ($update_customer){
                $activated = false;
                return view('pages.activationPage', compact('activated'));
            }
        } catch (\Throwable $th) {
            return response()->json(['success'=>'true','status' =>401, 'error'=>$th]);
        }
    }

    //cerify associate
    public function verify_associate($client_number = null, $mobile_number = null){
        $query = DB::table('associates')
                    ->where('client_number','=', $client_number)
                    ->where('mobile_number','=',$mobile_number)
                        ->update([
                            'active_association' => 1
                        ]);
        $total = $this->totalAmount();
        if($query === 1 || $query === true){
            $activated = true;
            return view('pages.activationPage', compact('activated','total'));
        }
        if($query){
            $activated = false;
            return view('pages.activationPage', compact('activated','total'));
        }
    }

    //Login function
    public function login(Request $request){
        $is_register_by_email = $is_activate = DB::table('customers_sessions')
            ->select('email')
            ->where('email', '=', $request->email)
            ->first();

        if ($is_register_by_email !== null){
            //Login by email
            $is_activate = DB::table('customers_sessions')
                ->select('active')
                ->where('email', '=', $request->email)
                ->first();

            if ($is_activate->active === 0){
                return back()->with('deactivate','');
            }

            //Validando
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ],[
                'password.min' => 'El usuario y/o contraseña son incorrecto(s), por favor verifique sus datos.'
            ]);

            if(Auth::guard('customer')->attempt([
                'email'    => $request->email,
                'password' => $request->password])
            ){
                //update notifications each login
                $notification = $this->updateNotifications($request->email);

                return redirect()->route('customer.benefits');

            }else{
                return back()->withInput($request->only('email', 'remember'))->with('error','El usuario y/o contraseña son incorrecto(s), por favor verifique sus datos.');
            }
        }else{
            $is_register_by_phone = $is_activate = DB::table('customers_sessions')
                ->select('mobile')
                ->where('mobile', '=', $request->email)
                ->first();

            if($is_register_by_phone !== null){
                //Login by mobile
                $is_activate = DB::table('customers_sessions')
                    ->select('active')
                    ->where('mobile', '=', $request->email)
                    ->first();

                if ($is_activate->active === 0){
                    return back()->with('deactivate','');
                }

                //Validando
                $this->validate($request, [
                    'email' => 'required',
                    'password' => 'required'
                ],[
                    'password.min' => 'El usuario y/o contraseña son incorrecto(s), por favor verifique sus datos.'
                ]);

                if(Auth::guard('customer')->attempt([
                    'mobile'    => $request->email,
                    'password' => $request->password])
                ){
                    //update notifications each login
                    $notification = $this->updateNotificationsbyphone($request->email);

                    return redirect()->route('customer.benefits');

                }else{
                    return back()->withInput($request->only('email', 'remember'))->with('error','El usuario y/o contraseña son incorrecto(s), por favor verifique sus datos.');
                }
            }else{
                return back()->with('register','');
            }

        }





    }

    //update table notifications to seen
    public function dismissNotification($client_number){
        $dismiss = DB::table('notifications')
                    ->where('client_number','=',$client_number)
                    ->update([
                        'seen' => 1
                    ]);

        return redirect()->back();
    }

    //Logout function
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/');
    }

    //Send email to restore password
    public function send_restore_password(Request $request) {
        $request = $request->input();
        //$data_session = CustomersSession::where('email', $request['email'])->first();
        $data = CustomerPlatform::where('email', $request['email'])->first();
        $dataSession = CustomersSession::where('email', $data['email'])->first();

        $url = url('password/edit/'.$dataSession['email']);
        $messsage = 'Solicitaste reestablecer tu clave de acceso a Socio SYD, haz clic aqui para hacerlo:  ' .$url;

        // TwilioService::send_sms
        C3ntroService::sendSMS($messsage,'+52'.$dataSession->mobile);
        try {
            \Mail::send('emails.restorePassword',['data'=>$data], function($m) use ($data){
                $m->from('sociosyd@syd.com.mx',"Socio SYD");
                $m->to($data->email, $data->name.' '.$data->last_name)->subject('Reestablecer Contraseña Plataforma SYD');
            });
            return response()->json(['success'=>'true','status' =>200]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>'true','status' =>401]);
        }
    }

    //Show form to update password
    public function edit_password($client_number) {
        return view('pages.restorePassword', compact('client_number'));
    }

    //Update password
    public function update_password(Request $request) {
        $request = $request->input();
        $password      = Hash::make($request['password']);
        $update_customer = DB::table('customers_sessions')->where('email', '=', $request['client_number'])->update([
            'password' => $password,
        ]);

        if ($update_customer === 1){
            //$this->send_signUp_success($data->email);
            return response()->json(['success'=>'true','status' =>200]);
        }
        return response()->json(['success'=>'false','status' =>401]);
    }

    //Send signUp success email
    public function send_signUp_success($email) {
        $data = CustomerPlatform::where('email', $email)->first();
        $messsage = 'Felicidades, te has registrado exitosamente en el programa Socio SYD.';
        try {
            // TwilioService::send_sms
            C3ntroService::sendSMS($messsage,'+52'.$data->mobile_number);
            \Mail::send('emails.registroExitoso',['data'=>$data], function($m) use ($data){
                $m->from('sociosyd@syd.com.mx',"Socio SYD");
                $m->to($data->email, $data->name.' '.$data->last_name)->subject('Bienvenido al programa de lealtad SYD');
            });
            return response()->json(['success'=>'true','status' =>200]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>'true','status' =>401]);
        }
    }

    //Deactivate account
    public function deactivate_account(Request $request){

        $consult = DB::table('unsubscribe_form')
                    ->where('email','=', Auth::user()->email)
                    ->first();

        if ( isset($consult)){
            if (($request['grupo1'] == 1)){

                $updated = DB::table('unsubscribe_form')
                          ->where('email', '=', Auth::user()->email)                    
                          ->update(['message'=> $request['grupo'],
                                  'updated_at'=> date('Y-m-d H:i:s')
            ]); 
    
            }
            else {
                $updated = DB::table('unsubscribe_form')
                         ->where('email', '=', Auth::user()->email)                        
                         ->update(['message'=> $request['grupo1'],
                                 'updated_at'=> date('Y-m-d H:i:s')
            ]);
            } 
        }else{
            if (($request['grupo1'] == 1)){
                $updated = DB::table('unsubscribe_form')
                ->insert(['email' => Auth::user()->email,                    
                          'message'=> $request['grupo'],
                          'created_at'=> date('Y-m-d H:i:s')
            ]); 
    
            }
            else {
                $updated = DB::table('unsubscribe_form')
                ->insert(['email' => Auth::user()->email,                    
                          'message'=> $request['grupo1'],
                          'created_at'=> date('Y-m-d H:i:s')
            ]);
            } 
        }

        $updated = DB::table('customers_sessions')
            ->where('id', '=', Auth::user()->id)
            ->update(['active'=> 0,
                      'unsuscribe' => 1,
                      'date_unsuscribe' => date('Y-m-d H:i:s')
        ]);

        if (!$updated){
            return view('pages.Account.status');
        }

        $data = CustomerPlatform::where('email', Auth::user()->email)->first();
        $messsage = 'Tu cuenta ha sido dada de baja del programa Socio SYD. Si cambias de opinion, puedes reactivar tu cuenta.';

        // TwilioService::send_sms
        C3ntroService::sendSMS($messsage,'+52'.Auth::user()->mobile);
        \Mail::send('emails.deactivatedAccount',['data'=>$data], function($m) use ($data){
            $m->from('sociosyd@syd.com.mx',"Socio SYD");
            $m->to($data->email, $data->name.' '.$data->last_name)->subject('Tu cuenta ha sido dada de baja del programa Socio SYD');
        });

        $this->guard()->logout();
        $request->session()->invalidate();


        return $this->loggedOut($request) ?: redirect('/');
    }

    //Send email to activate account
    public function send_activate_account(Request $request) {
        $request = $request->input();

        $data = CustomerPlatform::where('email', $request['email'])->first();
        try {
            \Mail::send('emails.activateAccount',['data'=>$data], function($m) use ($data){
                $m->from('sociosyd@syd.com.mx',"Socio SYD");
                $m->to($data->email, $data->name.' '.$data->last_name)->subject('Activar cuenta Plataforma SYD');
            });
            return response()->json(['success'=>'true','status' =>200]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>'true','status' =>401]);
        }
    }

    //Show form to change password to activate account
    public function edit_account($client_number) {
        return view('pages.activateAccount', compact('client_number'));
    }

    //Update account to activate
    public function update_account(Request $request) {

        $request = $request->input();
        $password      = Hash::make($request['password']);
        $update_customer = DB::table('customers_sessions')->where('client_number', '=', $request['client_number'])->update([
            'password' => $password,
            'active'   => 1,
            'unsuscribe' => 0,
            'date_reactivate' => date('Y-m-d H:i:s')
        ]);

        if ($update_customer === 1){
            return response()->json(['success'=>'true','status' =>200]);
        }
        return response()->json(['success'=>'false','status' =>401]);
    }

    //Go to My account
    public function account_status(){
        //dd(Auth::user()->client_number);
        $data = CustomerPlatform::where('email', Auth::user()->email)->first();
        $dataSession = CustomersSession::where('email', Auth::user()->email)->first();

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;

        $tr = DB::table('transactions')
            ->where('client_number', $dataSession['client_number'])
            ->where('branch_number', $dataSession['branch_number'])
            ->whereMonth('transaction_date','=',$current_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();

        $total = 0.0;
        //$total = $this->totalAmount();

        foreach ($tr as $transaction){
            $amount_customer = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $total -= $amount_customer : $total += $amount_customer ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        $noti = $this->getNotifications();

        $mes = Carbon::parse()->locale('es');
        $data->mes = $mes;

        //$data->is_branch = $dataSession->is_branch;
        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('client_numbers')
                                ->where('branch','=',$dataSession->branch_number)
                                ->get();
        $query = json_decode($query);
        $query = (array)$query;
        if(empty($query) == false){
            $data->branch_name = $query[0]->branch_name;
        }

        return view('pages.Account.status', compact('data', 'tr', 'total','noti','owner'));
        //return redirect()->route('customer.myAccount');
    }

    //get the full name in customers table
    public function getRealName($data){
        $query = DB::table('customer_platforms')
                ->where('email','=', Auth::user()->email)
                ->get();
        $query = json_decode($query);
        $query = (array)$query;

        $data['name'] = $query[0]->name;
        $data['last_name'] = $query[0]->last_name;
        $data['second_last_name'] = $query[0]->second_last_name;
        return $data;
    }

    public function getAssociateNumber(){
        $query = DB::table('associates')
                ->where('email','=', Auth::user()->email)
                ->get();
        $query = json_decode($query);
        $query = (array)$query;

        if(empty($query) === false){
            return $query[0]->number;
        }
        return '';
    }

    //Get transactions
    public function get_trans($client_number, $branch_number){
        $now = Carbon::now();

        //$current_month = $now->addMonth();
        //$endDate   = $current_month->format('Y-m') . '-28';
        //$last_month = $now->subMonth(2); //2 bc prevously we added a month
        //$startDate = $last_month->format('Y-m'). '-01';

        $trans1 = DB::table('transactions')
           // ->join('material_type', 'transactions.tmat', '=', 'material_type.code')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $client_number)
            ->where('transactions.branch_number','=', $branch_number)
            ->where('amount', 'not like', '%' . '-' . '%')
            ->whereMonth('transaction_date', $now->month)
            ->get();

        $trans2 = DB::table('transactions')
           // ->join('material_type', 'transactions.tmat', '=', 'material_type.code')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $client_number)
            ->where('transactions.branch_number','=', $branch_number)
            ->where('amount', 'like', '%' . '-' . '%')
            ->whereMonth('transaction_date', $now->subMonth(1)->month)
            ->get();

        $customer_trans = $trans1->merge($trans2);

        return $customer_trans;
    }

    //Go to My documments section
    public function my_documents() {
        $data = CustomerPlatform::where('email', Auth::user()->email)->first();
        $dataSession = CustomersSession::where('email', Auth::user()->email)->first();

        //$data->is_branch = $dataSession->is_branch;
        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('client_numbers')
                                ->where('branch','=',$dataSession->branch_number)
                                ->get();
        $query = json_decode($query);
        $query = (array)$query;
        if(empty($query) == false){
            $data->branch_name = $query[0]->branch_name;
        }

        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        //$link = \Storage::cloud()->temporaryUrl('polizas/'.Auth::user()->id.'.pdf', now()->addMinute(2));
        //$exist = \Storage::cloud()->exists('polizas/'.Auth::user()->id.'.pdf');

        $noti = $this->getNotifications();
        $number = '';
        if(Auth::user()->client_type === '3'){
            $data = CustomerPlatform::where('email', Auth::user()->email)->first();
            $number = DB::table('associates')
                ->select('number')
                ->where('email', '=', Auth::user()->email)
                ->first();
        }

        $beneficiaries = DB::table('beneficiaries')
            ->where('customer_id', '=', $data->id)
            ->get();

        if (Auth::user()->client_type === "3"){
            $customer = DB::table('customer_platforms')
                ->where('email', '=', Auth::user()->email)
                ->first();
            $beneficiaries = DB::table('beneficiaries')
                ->where('customer_id', '=', $customer->id)
                ->get();
        }
        $now = Carbon::now()->locale('es');
        $current_year = $now->year;
        $previus_month =$now->month -1;
        $this_month=$now->monthName;
        $name_next_month = new Carbon('next month');
        $next_month=$name_next_month->monthName;
        $name_last_month = new Carbon('last month');
        $last_month=$name_last_month->monthName;
       // $current_month = $now->month;
       if ($previus_month == 0) {
        $current_year = $now->year-1;
        $previus_month =$now->month + 11;
        $data_customer = DB::table('transactions')
        ->where('branch_number', '=', Auth::user()->branch_number)
        ->whereMonth('transaction_date','=',$previus_month)
        ->whereYear('transaction_date', '=', $current_year )
        ->get();
       }
       else {
        $data_customer = DB::table('transactions')
        ->where('branch_number', '=', Auth::user()->branch_number)
        ->whereMonth('transaction_date','=',$previus_month)
        ->whereYear('transaction_date', '=', $current_year )
        ->get();
       }
        $totalAmount = 0.0;
        foreach ($data_customer as $d){
            //if( date_format(date_create($d->transaction_date)->modify('+2 day'), 'Y-m-d') < date($now->isoformat("Y-MM-D")) ){
                $amount_customer = floatval($d->amount);
                strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
            //}
        }
        /* $totalAmount = 0.0;
        foreach ($data_customer as $d){
            $MALOamount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
        } */

        $level = 0;
        if (Auth::user()->client_type != "2" || Auth::user()->client_type != "5"){
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

        if (Auth::user()->client_type === "2" || Auth::user()->client_type === "5"){
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
        $total = $totalAmount;
        //dd($beneficiaries);

        return view('pages.Account.documents', compact('data','level','total','noti', 'number', 'owner', 'beneficiaries','data_customer','last_month','this_month','next_month'));
    }

    //get transactions by branch_number or client_number
    public function getTransCadena($email){
        $dataSession = DB::table('customers_sessions')
                        ->where('email','=', $email)->first();
        $now = Carbon::now();
        //$current_month = $now->month;
        //$last_month = $now->subMonth();

       /*  $data= DB::table('transactions')
                    ->where('client_number','=', $dataSession->client_number)
                    ->where('branch_number','=', $dataSession->branch_number)
                    ->whereMonth('transaction_date', '=' ,$now)
                    //->whereMonth('transaction_date', '=' ,$last_month) TODO
                    ->get(); */

        $trans1 = DB::table('transactions')
           // ->join('material_type', 'transactions.tmat', '=', 'material_type.code')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $dataSession->client_number)
            ->where('transactions.branch_number','=', $dataSession->branch_number)
            ->where('amount', 'not like', '%' . '-' . '%')
            ->whereMonth('transaction_date', $now->month)
            ->get();

        $trans2 = DB::table('transactions')
            //->join('material_type', 'transactions.tmat', '=', 'material_type.code')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $dataSession->client_number)
            ->where('transactions.branch_number','=', $dataSession->branch_number)
            ->where('amount', 'like', '%' . '-' . '%')
            ->whereMonth('transaction_date', $now->subMonth(1)->month)
            ->get();

        $data = $trans1->merge($trans2);

        return $data;
    }

    public function getTransCadenaByPhone($phone){
        $dataSession = DB::table('customers_sessions')
            ->where('mobile','=', $phone)->first();
        $now = Carbon::now();
        //$current_month = $now->month;
        //$last_month = $now->subMonth();

        /*  $data= DB::table('transactions')
                     ->where('client_number','=', $dataSession->client_number)
                     ->where('branch_number','=', $dataSession->branch_number)
                     ->whereMonth('transaction_date', '=' ,$now)
                     //->whereMonth('transaction_date', '=' ,$last_month) TODO
                     ->get(); */

        $trans1 = DB::table('transactions')
            // ->join('material_type', 'transactions.tmat', '=', 'material_type.code')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $dataSession->client_number)
            ->where('transactions.branch_number','=', $dataSession->branch_number)
            ->where('amount', 'not like', '%' . '-' . '%')
            ->whereMonth('transaction_date', $now->month)
            ->get();

        $trans2 = DB::table('transactions')
            //->join('material_type', 'transactions.tmat', '=', 'material_type.code')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $dataSession->client_number)
            ->where('transactions.branch_number','=', $dataSession->branch_number)
            ->where('amount', 'like', '%' . '-' . '%')
            ->whereMonth('transaction_date', $now->subMonth(1)->month)
            ->get();

        $data = $trans1->merge($trans2);

        return $data;
    }

    //Go to register beneficiary
    public function register_beneficiary () {
        $data = CustomerPlatform::where('email', Auth::user()->email)->first();
        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        $number = '';
        $dataSession = CustomersSession::where('email', Auth::user()->email)->first();

        $data->is_branch = $dataSession->is_branch;
        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('client_numbers')
                                ->where('branch','=',$dataSession->branch_number)
                                ->get();
        //$data->branch_name = $branch_name[0]->branch_name;
        $query = json_decode($query);
        $query = (array)$query;
        if(empty($query) == false){
            $data->branch_name = $query[0]->branch_name;
        }


        if(Auth::user()->client_type === '3'){
            $number = DB::table('associates')
                ->select('number')
                ->where('email', Auth::user()->email)
                ->first();
        }

        $signature = DB::table('customers_sessions')
            ->select('signature_id')
            ->where('id', '=', Auth::user()->id)
            ->first();

        $noti = $this->getNotifications();
        $is_cnt = 'true';

        //$data_customer = $this->getTransCadena(Auth::user()->email);
        //$totalAmount = $this->totalAmount();

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $previus_month=$now->month - 1;

        if ($previus_month == 0) {
            $current_year = $now->year-1;
            $previus_month =$now->month + 11;
            $data_customer_before = DB::table('transactions')
            ->where('client_number', $dataSession['client_number'])
            ->where('branch_number', $dataSession['branch_number'])
            ->whereMonth('transaction_date','=',$previus_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();
        }
        else{
            $data_customer_before = DB::table('transactions')
            ->where('client_number', $dataSession['client_number'])
            ->where('branch_number', $dataSession['branch_number'])
            ->whereMonth('transaction_date','=',$previus_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();
        }
        $current_year = $now->year;
        $data_customer = DB::table('transactions')
            ->where('client_number', $dataSession['client_number'])
            ->where('branch_number', $dataSession['branch_number'])
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

        foreach ($data_customer as $transaction){
            $amount_customer = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        $level_before = 0;
        if (Auth::user()->client_type != "2" || Auth::user()->client_type !== "5"){
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

        if (Auth::user()->client_type === "2"|| Auth::user()->client_type === "5"){
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
        if (Auth::user()->client_type !== "2" || Auth::user()->client_type !== "5"){
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

        if (Auth::user()->client_type === "2" || Auth::user()->client_type === "5"){
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

        $beneficiaries = DB::table('beneficiaries')
                        ->where('customer_id','=', $data->id)
                        ->get();
        $beneficiaries = json_decode($beneficiaries);
        $beneficiary = (array)$beneficiaries;//convert to array

        $total = $totalAmount;

        if(empty($beneficiaries) == false){
            return view('pages.Account.beneficiary', compact('data', 'beneficiary', 'noti', 'total', 'level', 'number', 'owner','level_before'));
        }

        $signature = $signature->signature_id;

        return view('pages.Account.beneficiary', compact('data', 'signature', 'level','total','noti', 'is_cnt', 'number', 'owner','level_before'));
    }

    //Go to benefits of Safe
    public function benefits () {
        $data = CustomerPlatform::where('email', Auth::user()->email)->first();
        $dataSession = CustomersSession::where('email', Auth::user()->email)->first();

        //$data->is_branch = $dataSession->is_branch;
        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('client_numbers')
                                ->where('client_number','=',$data->client_number)
                                ->where('branch','=',$dataSession->branch_number)
                                ->get();
        $query = json_decode($query);
        $query = (array)$query;
        if(empty($query) == false){
            $data->branch_name = $query[0]->branch_name;
        }

        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        $number = '';
        if(Auth::user()->client_type === '3'){
            $data = CustomerPlatform::where('email', Auth::user()->email)->first();
            $number = DB::table('associates')
                ->select('number')
                -> where('email', Auth::user()->email)
                ->first();
        }

        $cnt = intval(Auth::user()->client_number);
        $is_cnt = 'false';
        if( ($cnt > 90000000) && ($cnt < 90020000)) {
            $is_cnt = 'true';
        }

        //$now = Carbon::now();
        //$current_month = $now->month;

        //$data_customer = $this->getTransCadena(Auth::user()->email);

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $previus_month=$now->month - 1;

        if ($previus_month == 0) {
            $current_year = $now->year-1;
            $previus_month =$now->month + 11;
            $data_customer_before = DB::table('transactions')
            ->where('client_number', $dataSession['client_number'])
            ->where('branch_number', $dataSession['branch_number'])
            ->whereMonth('transaction_date','=',$previus_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();
        }
        else{
            $data_customer_before = DB::table('transactions')
            ->where('client_number', $dataSession['client_number'])
            ->where('branch_number', $dataSession['branch_number'])
            ->whereMonth('transaction_date','=',$previus_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();
        }
        $current_year = $now->year;
        $data_customer = DB::table('transactions')
            ->where('client_number', $dataSession['client_number'])
            ->where('branch_number', $dataSession['branch_number'])
            ->whereMonth('transaction_date','=',$current_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();

        //$totalAmount = $this->totalAmount();
        /* $totalAmount = 0.0;
        foreach ($data_customer as $d){
            $MALOamount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
        } */
        $totalAmount_before = 0.0;
        $totalAmount = 0.0;

        foreach ($data_customer_before as $transaction){
            $amount_customer_before = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount_before -= $amount_customer_before : $totalAmount_before += $amount_customer_before ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        foreach ($data_customer as $transaction){
            $amount_customer = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        $level_before = 0;
        if (Auth::user()->client_type != "2" || Auth::user()->client_type !== "5"){
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

        if (Auth::user()->client_type === "2"|| Auth::user()->client_type === "5"){
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
        if (Auth::user()->client_type != "2" || Auth::user()->client_type !== "5"){
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

        if (Auth::user()->client_type === "2"|| Auth::user()->client_type === "5"){
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
        $total = $totalAmount;
        $noti = $this->getNotifications();
        return view('pages.Account.benefitSafe', compact('data', 'level','total','noti', 'is_cnt', 'number', 'owner','level_before'));
    }

    //Go to signature section in benefits
    public function benefits_signature () {
        $data = CustomerPlatform::where('email', Auth::user()->email)->first();
        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        $number = '';
        $query = DB::table('signatures')
            ->where('customer_id','=',Auth::user()->id)
            ->get();
        if(Auth::user()->client_type === '3'){
            $data = CustomerPlatform::where('email', Auth::user()->email)->first();
            $number = DB::table('associates')
                ->select('number')
                -> where('email', Auth::user()->email)
                ->first();
            $query = DB::table('signatures')
                ->where('customer_id','=',Auth::user()->id)
                ->get();
        }

        $query = json_decode($query);
        $query = (array)$query;
        $imgData = '';
        if(empty($query) === false){
            $imgData = $query[0];
        }
        //$totalAmount = $this->totalAmount();
        $noti = $this->getNotifications();

        //$now = Carbon::now();
        //$current_month = $now->month;

        //$data_customer = $this->getTransCadena(Auth::user()->email);
        /* $totalAmount = 0.0;
        foreach ($data_customer as $d){
            $MALOamount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
        } */

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $previus_month=$now->month - 1;

        if ($previus_month == 0) {
            $current_year = $now->year-1;
            $previus_month =$now->month + 11;
            $data_customer_before = DB::table('transactions')
            ->where('client_number', Auth::user()->client_number)
            ->where('branch_number', Auth::user()->branch_number)
            ->whereMonth('transaction_date','=',$previus_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();
        }
        else{
            $data_customer_before = DB::table('transactions')
            ->where('client_number', Auth::user()->client_number)
            ->where('branch_number', Auth::user()->branch_number)
            ->whereMonth('transaction_date','=',$previus_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();
        }
        $current_year = $now->year;
        $data_customer = DB::table('transactions')
            ->where('client_number', Auth::user()->client_number)
            ->where('branch_number', Auth::user()->branch_number)
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

        foreach ($data_customer as $transaction){
            $amount_customer = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        $level_before = 0;
        if (Auth::user()->client_type != "2" || Auth::user()->client_type !== "5"){
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

        if (Auth::user()->client_type === "2"|| Auth::user()->client_type === "5"){
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
        if (Auth::user()->client_type != "2" || Auth::user()->client_type !== "5"){
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

        if (Auth::user()->client_type === "2" || Auth::user()->client_type === "5"){
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
        $total = $totalAmount;

        return view('pages.Account.signature', compact('data', 'imgData','total','noti', 'level', 'number', 'owner','level_before'));
    }

    //Create signature
    public function efirm(Request $request){
        //define('SITE_KEY', '6Lcj42QaAAAAACUH7dgidlq-nEKhvz2crDWbUQJ5');
        //$SECRET_KEY ='6Lcj42QaAAAAAMwOwhWsYwaykqN2448EhRYRPXWP';

        //validated with recatpcha
        //if($request['googleResponseToken']){ //if token exist
            //$googleToken = $request['googleResponseToken'];

            /*$response = file_get_contents(
                "https: //www. google.com/recaptcha/api/siteverify?secret=". $SECRET_KEY."&response={$googleToken}"
            );
            $response = json_decode($response);
            $response = (array)$response;
            //return response()->json($response);

            if($response['success']){
                if($response['score'] && $response['score'] > 0.5){*/
        //$now = Carbon::now();
        //$current_month = $now->month;

        //$data_customer = $this->getTransCadena(Auth::user()->email);
        //$totalAmount = $this->totalAmount();
        /* $totalAmount = 0.0;
        foreach ($data_customer as $d){
            $MALOamount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
        }
 */

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;

        $data_customer = DB::table('transactions')
            ->where('client_number', Auth::user()->client_number)
            ->where('branch_number', Auth::user()->branch_number)
            ->whereMonth('transaction_date','=',$current_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();

        $totalAmount = 0.0;

        foreach ($data_customer as $transaction){
            $amount_customer = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        $level = 0;
        if (Auth::user()->client_type != "2"|| Auth::user()->client_type !== "5"){
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

        if (Auth::user()->client_type === "2" || Auth::user()->client_type === "5"){
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
                    //save the efirm into db
                    $user = CustomerPlatform::where('client_number', Auth::user()->client_number)->first();
                    $data = DB::table('signatures')
                                ->where('customer_id','=',Auth::user()->id)
                                ->get();

                    /* if(Auth::user()->client_type === "3") {
                        $data = DB::table('signatures')
                            ->where('customer_id','=',Auth::user()->id)
                            ->get();
                    } */

                    $data = json_decode($data);
                    $data = (array)$data;

                    //if dont exists, insert
                    $updateCustomer= '';
                    $idSign ='';
                    if (is_array($data) == true) { //check if an array
                        if(empty($data) === false){
                            $idSign = DB::table('signatures')
                                        ->where('client_number','=',$user->client_number)
                                        ->update([
                                            'imgData'    => $request['imgData'],
                                            'updated_at' => date('Y-m-d H:i:s')
                                        ]);
                        }

                        if(empty($data) === true){
                            if(Auth::user()->client_type !== "3"){
                                $idSign = DB::table('signatures')->insertGetId([
                                    'client_number'   => $user->client_number,
                                    'created_at'      => date('Y-m-d H:i:s'),
                                    'imgData'         => $request['imgData'],
                                    'customer_id'     => Auth::user()->id
                                ]);
                            }else{
                                $idSign = DB::table('signatures')->insertGetId([
                                    'client_number'   => '',
                                    'customer_id'     => Auth::user()->id,
                                    'created_at'      => date('Y-m-d H:i:s'),
                                    'imgData'         => $request['imgData'],
                                    'customer_id'     => Auth::user()->id
                                ]);
                            }



                            //then update customer table,signature id
                            $updateCustomer = DB::table('customers_sessions')
                                                ->where('client_number', '=', $user->client_number)
                                                ->update([
                                                    'signature_id' => $idSign
                                                ]);
                        }
                    }

                    if ($idSign === 1 ||  $idSign === true || is_null($idSign) == false){ //if everything ok, redirect
                        //aqui
                        return response()->json(['success'=>'true', 'level'=>$level]);
                        //return redirect()->route('customer.benefits', compact('level'));
                    }
                //}
                //else u r a robot
            //}
        //}
    }

    //Go to benefits of assistance
    public function benefits_assistance () {
        $data = CustomerPlatform::where('email', Auth::user()->email)->first();
        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        $number = '';
        $dataSession = CustomersSession::where('email', Auth::user()->email)->first();

        $data->is_branch = $dataSession->is_branch;
        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('client_numbers')
                    ->where('branch','=',$dataSession->branch_number)
                    ->get();
        $query = json_decode($query);
        $query = (array)$query;
        if(empty($query) == false){
            $data->branch_name = $query[0]->branch_name;//get branch name to the view
        }

        if(Auth::user()->client_type === '3'){
            $data = CustomerPlatform::where('email', Auth::user()->email)->first();
            $number = DB::table('associates')
                ->select('number')
                -> where('email', Auth::user()->email)
                ->first();
        }
        //$now = Carbon::now();
        //$current_month = $now->month;

        //$data_customer = $this->getTransCadena(Auth::user()->email);
        //$totalAmount = $this->totalAmount();
        /*$totalAmount =  0.0;
        foreach ($data_customer as $d){
            $MALOamount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
        } */

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $previus_month=$now->month - 1;

        if ($previus_month == 0) {
            $current_year = $now->year-1;
            $previus_month =$now->month + 11;
            $data_customer_before = DB::table('transactions')
            ->where('client_number', Auth::user()->client_number)
            ->where('branch_number', Auth::user()->branch_number)
            ->whereMonth('transaction_date','=',$previus_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();
        }
        else{
            $data_customer_before = DB::table('transactions')
            ->where('client_number', Auth::user()->client_number)
            ->where('branch_number', Auth::user()->branch_number)
            ->whereMonth('transaction_date','=',$previus_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();
        }
        $current_year = $now->year;
        $data_customer = DB::table('transactions')
            ->where('client_number', Auth::user()->client_number)
            ->where('branch_number', Auth::user()->branch_number)
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

        foreach ($data_customer as $transaction){
            $amount_customer = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        $level_before = 0;
        if (Auth::user()->client_type != "2" || Auth::user()->client_type !== "5"){
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

        if (Auth::user()->client_type === "2"|| Auth::user()->client_type === "5"){
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
        if (Auth::user()->client_type != "2" || Auth::user()->client_type !== "5"){
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

        if (Auth::user()->client_type === "2" || Auth::user()->client_type === "5"){
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
        $total = $totalAmount;
        $noti = $this->getNotifications();
        ///
        return view('pages.Account.assistance', compact('data', 'level','total','noti', 'number', 'owner','level_before'));
    }

    //calculated totalAmount
    public function totalAmount(){
        //$now = Carbon::now();
        //$current_month = $now->month;

        $data_customer = $this->getTransCadena(Auth::user()->email);
        $totalAmount = 0.0;
        foreach ($data_customer as $d){
            //if( date_format(date_create($d->transaction_date)->modify('+2 day'), 'Y-m-d') < date($now->isoformat("Y-MM-D")) ){
                $amount_customer = floatval($d->amount);
                strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
            //}
        }

        return $totalAmount;
    }

    //get the total amount by passing client number as a parameter
    public function totalAmountById($client_number,$email){
        //$now = Carbon::now();
        //$current_month = $now->month;

        $dataSession = CustomersSession::where('email', $email)->first();

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;

        $data_customer = DB::table('transactions')
            ->where('client_number', $client_number)
            ->where('branch_number', $dataSession['branch_number'])
            ->whereMonth('transaction_date','=',$current_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();

        $totalAmount = 0.0;

        foreach ($data_customer as $transaction){
            $amount_customer = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        return $totalAmount;
    }

    //get the total amount by passing client number as a parameter
    public function totalAmountByPhone($client_number,$phone){
        $dataSession = CustomersSession::where('mobile', $phone)->first();

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;

        $data_customer = DB::table('transactions')
            ->where('client_number', $client_number)
            ->where('branch_number', $dataSession['branch_number'])
            ->whereMonth('transaction_date','=',$current_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();

        $totalAmount = 0.0;

        foreach ($data_customer as $transaction){
            $amount_customer = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        return $totalAmount;
    }

    //get the data from notifications table
    public function getNotifications(){
        $data = DB::table('notifications')
            ->where('client_number','=',Auth::user()->client_number)
            ->where('branch_number','=', Auth::user()->branch_number)
            ->get();
        $data = json_decode($data);
        $data = (array)$data;

        //check if an array
        if(is_array($data) == true && empty($data) === true){
            return false;
        }
        return $data[0];
    }

    //update notifications table
    //get the data from notifications table
    /* public function getNotificationsById($client_number){
        $data = DB::table('notifications')
            ->where('branch_number','=',$client_number)
            ->get();
        $data = json_decode($data);
        $data = (array)$data;

        //check if an array
        if(is_array($data) == true && empty($data) === true){
            return false;
        }
        return $data[0];
    } */

    //update notifications table
    public function updateNotifications($email){
        //get client number by email
        $data = DB::table('customers_sessions')
                    ->where('email','=',$email)
                    ->get();
        $data = json_decode($data);
        $data = (array)$data;
        //calcular el total amount
        $total = $this->totalAmountById($data[0]->client_number, $email);
        //update en tabla notifications
        $update_notifications = 'No matches';
        if(($data[0]->client_type != 2 || $data[0]->client_type != 5) && $total > 2500.01){
            $update_notifications = DB::table('notifications')
                                    ->where('branch_number','=',$data[0]->branch_number)
                                    ->update([
                                        'available' => 1
                                    ]);
        }

        if(($data[0]->client_type == 2 ||$data[0]->client_type == 5) && $total > 200.02){
            $update_notifications = DB::table('notifications')
                                    ->where('branch_number','=',$data[0]->branch_number)
                                    ->update([
                                        'available' => 1
                                    ]);
        }

        if($data[0]->created_at >= Carbon::createFromFormat('Y-m-d', '2021-08-15') && $data[0]->created_at <= Carbon::createFromFormat('Y-m-d', '2021-08-30')){
            $update_notifications = DB::table('notifications')
                                    ->where('branch_number','=',$data[0]->branch_number)
                                    ->update([
                                        'available' => 1
                                    ]);
        }

        return $update_notifications;

    }

    public function updateNotificationsbyphone($phone){
        //get client number by email
        $data = DB::table('customers_sessions')
            ->where('mobile','=',$phone)
            ->get();
        $data = json_decode($data);
        $data = (array)$data;
        //calcular el total amount
        $total = $this->totalAmountByPhone($data[0]->client_number, $phone);
        //update en tabla notifications
        $update_notifications = 'No matches';
        if(($data[0]->client_type != 2 || $data[0]->client_type != 5) && $total > 2500.01){
            $update_notifications = DB::table('notifications')
                ->where('branch_number','=',$data[0]->branch_number)
                ->update([
                    'available' => 1
                ]);
        }

        if(($data[0]->client_type == 2 || $data[0]->client_type === 5) && $total > 200.02){
            $update_notifications = DB::table('notifications')
                ->where('branch_number','=',$data[0]->branch_number)
                ->update([
                    'available' => 1
                ]);
        }

        if($data[0]->created_at >= Carbon::createFromFormat('Y-m-d', '2021-08-15') && $data[0]->created_at <= Carbon::createFromFormat('Y-m-d', '2021-08-30')){
            $update_notifications = DB::table('notifications')
                ->where('branch_number','=',$data[0]->branch_number)
                ->update([
                    'available' => 1
                ]);
        }

        return $update_notifications;

    }

    //Go to beneficiares section
    public function beneficiaries ()
    {
        $data = CustomerPlatform::where('email', Auth::user()->email)->first();
        $total = $this->totalAmount();
        $noti = $this->getNotifications();
        return view('pages.Account.beneficiaries', compact('data','total','noti'));
    }

    //load data from associates AQUI
    public function employees () {
        $data = CustomerPlatform::where('email', Auth::user()->email)->first();
        $dataSession = CustomersSession::where('email', Auth::user()->email)->first();
        $associates = DB::table('associates')
                            ->where([
                                ['client_number','=',$data->client_number],
                                ['branch_number','=',$dataSession->branch_number],
                                ['active_association', '=', 1]
                                ])
                            ->get();
        //Calculated the limit of employee
        $response = $this->employeeLimit(
                    Auth::user()->email,
                    $data->id,
                    Auth::user()->client_type);
        $total = $this->totalAmount();
        $noti = $this->getNotifications();

        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('client_numbers')
                                ->where('branch','=',$dataSession->branch_number)
                                ->get();
        $query = json_decode($query);
        $query = (array)$query;
        if(empty($query) == false){
            $data->branch_name = $query[0]->branch_name;//get branch name to the view
        }
        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;

        $data->limiteAsociados = $response->limiteAsociados;
        $data->validated = $response->validated;

        return view('pages.Account.employees', compact('data','associates','total','noti','owner'));
    }

    //Function to generate limit for add employees according the rules
    public function employeeLimit($email, $id, $client_type){
        $data = CustomerPlatform::where('email', $email)->first();
        $dataSession = CustomersSession::where('email', $email)->first();
        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;

        /* $query = DB::table('transactions')
                    ->where('client_number','=', $data['client_number'])
                    ->where('branch_number','=', $dataSession['branch_number'])
                    ->whereMonth('transaction_date','=',$now)
                    ->sum('amount');
        */
        //round the number with only 2 decimals
        //$limit = $this->totalAmount();

        $data_customer = DB::table('transactions')
            ->where('client_number', $dataSession['client_number'])
            ->where('branch_number', $dataSession['branch_number'])
            ->whereMonth('transaction_date','=',$current_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();

        $limit = 0.0;
        foreach ($data_customer as $d){
            //if( date_format(date_create($d->transaction_date)->modify('+2 day'), 'Y-m-d') < date($now->isoformat("Y-MM-D")) ){
            $amount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $limit -= $amount_customer : $limit += $amount_customer ;
            //}
        }

        $validated = false; //var for button validated

        //get number of employees registrados
        $numberEmployees = $this->getNumberAssociate($id,$dataSession['branch_number']);

        $validated = false;
        $limiteAsociados = false;
        //calculated the limit of employees
        if( $limit > 2500 && $limit <= 4500 && $numberEmployees < 4 ){ //bronce
            $validated = true;
        }else if($limit > 4500 && $limit <= 7000 && $numberEmployees < 4){ //plata
            $validated = true;
        }else if($limit > 7000 && $numberEmployees < 8){ //oro
            $validated = true;
        }

        if( $limit > 2500 && $limit <= 4500 && $numberEmployees == 4 ){ //bronce
            $limiteAsociados = true;
        }else if($limit > 4500 && $limit <= 7000 && $numberEmployees == 4){ //plata
            $limiteAsociados = true;
        }else if($limit > 7000 && $numberEmployees == 8){ //oro
            $limiteAsociados = true;
        }

        $data->validated = $validated;
        $data->limiteAsociados = $limiteAsociados;
        $data->number = $numberEmployees;

        return $data;
    }

    //Edit Employees
    public function editEmployee($id){
        $data = CustomerPlatform::where('email', Auth::user()->email)->first();
        $query = DB::table('associates')
                    ->where('client_number','=',$data['client_number'])
                    ->where('id','=',$id)
                    ->get();
        $employee = $query[0];
        $total = $this->totalAmount();
        $noti = $this->getNotifications();
        return view('pages.Account.editEmployee', compact('employee','id','total','noti'));
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

    public function sms_verification($mobile){
        $code = rand(111111,999999);
        $messsage = 'Este es el codigo de verificacion que debes ingresar para completar tu registro en Socio SYD: '.$code;

        //$response = TwilioService::send_sms($messsage,'+52'.$mobile);        
        $response = C3ntroService::sendSMS($messsage, '+52'.$mobile);
       
        if($response){
            return response()->json($code);
        }else{
            return response()->json(000000);
        }

    }



    public function send_email($name, $email, $token){
    	\Mail::send('Collectors.email_customer',['name'=>$name,'token'=>$token], function($m) use ($email, $name){
    		$m->from('sociosyd@syd.com.mx',"Socio SYD");
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
    	$register = CustomerPlatform::where('email_validate', $token)->first();
    	$register->email_validate = 'true';
    	$register->save();
    	return view('Collectors.verify_email', ['name'=> $register->name.' '.$register->last_name]);
    }

    public function home(){
        $total = $this->totalAmount();
        $noti  = $this->getNotifications();

        return view('pages.home',compact('total','noti'));
    }

    public function phone_validate(Request $request){
        try{
            $register = CustomerPlatform::where('phone_validate', $request->code)->first();
            if(!$register)
                return ['status' => 0 , 'msg'  => 'El código ingresado es incorrecto'];

            $register->phone_validate = 1;
            $register->save();
            return ['status' => 1 , 'msg'  => 'Process is success'];
        }catch(\Exception $e){
            return ['status' => 0 , 'msg'  => $e->getMessage()];
        }
    }

    //Contact form
    public function contact_us(Request $request){
        $SYD_EMAILS = ["rguerrero@syd.com.mx",
                     "nebratt@syd.com.mx",
                     "ecommerce@syd.com.mx",
                     "equezada@syd.com.mx",
                     "sociosyd@syd.com"];
        //$to = explode(',',$SYD_EMAILS);
        $data = $request->all();
        $captcha = $request->input('g-recaptcha-response');
        //Second secret key
        $secretKey = '6LeH1EkdAAAAADN7v5hr5VOcCbcT0A4X9z1u5Geq';
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
        $atributos = json_decode($response, TRUE);
        if ($atributos['success']) {
            try {
                foreach( $SYD_EMAILS as $emails){
                    Mail::send('emails.messageContact', ['data'=>$data] ,function($m) use ($emails){
                        $m->from('sociosyd@syd.com.mx',"Socio SYD");
                        $m->to("sociosyd@syd.com")->subject('Nuevo Registro de Socio SYD');
                    });
                }
                return redirect()->route('home');
            } catch (\Throwable $th) {
                return response()->json(['error'=>'algo salio mal','status' =>401, 'desc'=>$th->getMessage()]);
            }
        }
    }

    //invitation email associate
    public function invitation($data){
        $email = $data['email'];

        $messsage = 'Te han invitado a ser parte del programa Socio SYD como colaborador de un negocio.';

        // TwilioService::send_sms
        C3ntroService::sendSMS($messsage,'+52'.$data['mobile_number']);
        try {
            Mail::send('emails.invitacionAsociadoNew',['data'=>$data], function($m) use ($email){
                $m->from('sociosyd@syd.com.mx',"Socio SYD");
                $m->to($email)->subject("Te han invitado a ser parte del programa Socio SYD, haz clic en el botón para aceptar la invitación");
            });
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //invitation email associate
    public function inviteMechanicToDependent($data){
        $email = $data['email'];
        //try {
            Mail::send('emails.mechanicToDependent',['data'=>$data], function($m) use ($email){
                $m->from('sociosyd@syd.com.mx',"Socio SYD");
                $m->to($email)->subject("Invitación cuenta dependiente");
            });
        //} catch (\Throwable $th) {
            //throw $th;
        //}
    }

    protected function guard()
    {
        return Auth::guard();
    }

    //form invitation
    public function invitationForm($client_number,$mobile_number){ //clientnumber & mobile number

        $query = DB::table('associates')
                    ->where('client_number','=',$client_number)
                    ->where('mobile_number','=',$mobile_number)
                    ->get();
        $query = json_decode($query);
        $query = (array)$query;

        $employee = null;

        if(empty($query) === false){
            $employee = $query[0];
        }

        $total = 0;
        $noti = 0;

        $branches = DB::table('branches')
        ->orderBy('name','ASC')
        ->get();

        return view('pages.invitationForm', compact('employee','total','noti','branches'));
    }

}
