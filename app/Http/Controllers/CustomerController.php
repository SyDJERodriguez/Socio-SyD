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
use App\Mail\contactMail;
use App\VueTables\EloquentVueTables;
use Barryvdh\Reflection\DocBlock\Tag\AuthorTag;
use DB;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\get_message_body_summary;
use Hash;
use http\Env\Response;
use http\Message;
use Illuminate\Http\Request;
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
class CustomerController extends Controller
{
    use AuthenticatesUsers;
    //protected $redirectTo = '/customer/account/';

    //REGISTER CNT THIS IS TEMPORARY

    public function insertCNTNumber() {
        $client_number = 90000000;
        for ($i = 0; $i<20; $i++) {
            $client_number = strval(++$client_number);
            $client_number = '00'.$client_number;
            DB::table('cnt_numbers')->insert([
                'client_number'    => $client_number,
            ]);
        }
    }

    public function cntRegister(Request $request) {
        $request = $request->input();
        //For customer_session table
        $passwordVerify = $request['password'];
        $passwordConfirm = $request['confirmPassword'];

        //Validate DNS email
        $domain = explode('@', $request['email']);
        $validate_dns = sizeof(dns_get_record($domain[1]));

        // return $validate_dns;
        if ($validate_dns <= 0){
            return response()->json(['success'=>'false', 'verify_valid_dns'=>'false']);
        }

        if ($passwordVerify !== $passwordConfirm){
            return response()->json(['success'=>'false', 'verify_password'=>'false']);
        }

        $password      = Hash::make($request['password']);

        $client_number= '';
        if (!empty($request['client_number'])){
            $client_number = '00'.$request['client_number'];
        }else{
            $number = DB::table('cnt_numbers')
                ->where('registered', '=',1)
                ->pluck('client_number')->toArray();
            if (empty($number)){
                $client_number ='0090000001';
            }else{
                $counter = count($number);
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
            if($request['cnt_number'] !== '1000'){
                return response()->json(['success'=>'false', 'cnt_number'=>'false']);
            }
        //}

        //Insert data in customers table
        $update_customer = DB::table('customers')->insert([
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
            'collector_id'     => 6
        ]);

        //create data in notifications table
        $update_notifications = DB::table('notifications')->insert([
            'client_number'     => $client_number,
            'name_id'           => 'SEGURO ASISTENCIAS'
        ]);

        $save_register = DB::table('customers_sessions')->insert([
            'client_number' => $client_number,
            'client_type'   => $request['client_type'], //1 duenio; 2 independiente
            'email'         => $request['email'],
            'mobile'        => $request['mobile'],
            'active'        => 0,
            'password'      => $password
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
                $update_customer = DB::table('customers')->where('email','=', Auth::user()->email)->update([
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
                $update_customer = DB::table('customers')->where('email','=', $request['email'])->update([
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
        $verify_client_number = DB::table('client_numbers')->where('client_number',$client_number)->first();
        if ($verify_client_number == null) {
            return response()->json(['success'=>'false', 'verify_client_number'=>'false']);
        }
        $data = Customer::where('client_number', $client_number)->first();
        return response($data);
    }

    public function verify_client_branch(Request $request){
        $request = $request->input();
        $client_number = '00'.$request['client_number'];
        $verify_client_number = DB::table('branches_clients')
        ->where('client_number','=',$client_number)
        ->first();
        if ($verify_client_number == null) {
            return response()->json(['success'=>'false', 'verify_client_number'=>'false']);
        }
        $data = DB::table('branches_clients')
                ->where('client_number', '=', $client_number)
                ->get();
        return response($data);
    }

    //update data in beneficiaries table
    public function addEmployee(Request $request){
        $session = $request;
        $request       = $request->input();
        $client_number = $request['client_number'];

        //validate mobile number
        $valid = $this->phoneValidator($request['mobile_number']);
        if ($valid == false){
            return response()->json(['success'=>'false', 'verify_valid_mobile'=>'false']);
        }

        //Validate DNS email
        $domain = explode('@', $request['email']);
        $validate_dns = sizeof(dns_get_record($domain[1]));

        // return $validate_dns;
        if ($validate_dns <= 0){
            return response()->json(['success'=>'false', 'verify_valid_dns'=>'false']);
        }

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
                $owner = DB::table('customers')
                    ->where('client_number', '=', $request['client_number'])
                    ->first();
                $ownerName = $owner->name.' '.$owner->last_name.' '.$owner->second_last_name;

                $data = DB::table('customers')
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

    //Deactivate employees
    public function deleteEmployee($employee){
        $data = Customer::where('email', Auth::user()->email)->first();
        //update the employee with client number 00000000 and number = 0
        $update_associates ='';
        $update_associates = DB::table('associates')
                ->where('id','=',$employee)
                ->where('client_number','=',$data['client_number'])
                ->update([
                    'number'            => 0,
                    'active_association'=> 0
                ]);

        if ($update_associates === 1 || $update_associates === true || $update_associates === 0){
            //return response()->json(['success'=>'true', 'update'=>$update_associates,'client_number'=>$request['client_number']]);
            return redirect()->route('customer.employees');
        }else{
            return response()->json(['success'=>'false', 'update'=>$update_associates]);
        }
    }

    //function to calculated number of associate
    public function getNumberAssociate($customer_id,$branch_number){
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

        //validate mobile number
        $valid = $this->phoneValidator($request['mobile']);
        if ($valid == false){
            return response()->json(['success'=>'false', 'verify_valid_mobile'=>'false']);
        }

        //Validate DNS email
        $domain = explode('@', $request['email']);
        $validate_dns = sizeof(dns_get_record($domain[1]));

       // return $validate_dns;
        if ($validate_dns <= 0){
            return response()->json(['success'=>'false', 'verify_valid_dns'=>'false']);
        }


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
            $data = Customer::where('client_number', $client_number)->first();

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

            //Insert data in customers table
            $update_customer = DB::table('customers')->insert([
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
                'RFC_Company'      => isset($request['RFC_Company']) ? isset($request['RFC_Company']) : null
            ]);

            //create data in notifications table
            /* $update_notifications = DB::table('notifications')->insert([
                'client_number'     => $client_number,
                'name_id'           => 'SEGURO ASISTENCIAS'
            ]); */


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

                $idCustomer = DB::table('customers')
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

        //validate mobile number
        $valid = $this->phoneValidator($request['mobile']);
        if ($valid == false){
            return response()->json(['success'=>'false', 'verify_valid_mobile'=>'false']);
        }

        //Validate DNS email
        $domain = explode('@', $request['email']);
        $validate_dns = sizeof(dns_get_record($domain[1]));

       // return $validate_dns;
        if ($validate_dns <= 0){
            return response()->json(['success'=>'false', 'verify_valid_dns'=>'false']);
        }

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
            //Insert data in customers table
            $update_customer = DB::table('customers')->insert([
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
                'RFC_Company'      => isset($request['RFC_Company']) ? isset($request['RFC_Company']) : null,
                'created_at'       => date('Y-m-d H:i:s')
            ]);

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

        //validate mobile number
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
        $data = Customer::where('client_number', $client_number)->first();

        $update_customer ='';
        $save_register = '';
        if($data !== null) {
            //si es invitado
            if($request['client_type'] === '3' || $request['client_type'] === 3){

                //Update data in customers table
                $update_customer = DB::table('customers')->where('email', '=', $request['email'])->update([
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
                    'RFC_Company'      => isset($request['RFC_Company']) ? $request['RFC_Company'] : ''
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
                 $update_customer = DB::table('customers')
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
                    'RFC_Company'      => isset($request['RFC_Company']) ? $request['RFC_Company'] : ''
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
        $data = Customer::where('client_number', $request['client_number'])->first();

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

        //Insert data in customers table
        $update_customer = DB::table('customers')->insert([
            'client_number'    => null,
            'name'             => $request['name'],
            'last_name'        => $request['last_name'],
            'second_last_name' => $request['second_last_name'],
            'email'            => $request['email'], //This is for customers_session table too
            'mobile_number'    => $request['mobile'],
            'company'          => isset($request['company']) ? $request['company'] : null,
            'birthday'         => $request['birthday'],
            'rfc'              => isset($request['rfc']) ? $request['rfc'] : null,
            'work'             => isset($request['work']) ? $request['work'] : null,
            'gender'           => isset($request['gender']) ? $request['gender'] : null
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
        $data = Customer::where('email',$email)->first();
        $dataSession = CustomersSession::where('email', $email)->first();
        $data->branch_number = $dataSession->branch_number;

        try {
            \Mail::send('emails.signUpWelcome',['data'=>$data], function($m) use ($data){
                $m->from('sociosyd@syd.com.mx',"SOCIO SYD");
                $m->to($data->email, $data->name.' '.$data->last_name)->subject('Bienvenido al programa de lealtad SYD');
            });
            return response()->json(['success'=>'true','status' =>200]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>'false','status' =>401]);
        }
    }

    //Send welcome email
     public function welcome_email_is_associate($data) {
        try {
            \Mail::send('emails.signUpInvitationWelcome',['data'=>$data], function($m) use ($data){
                $m->from('sociosyd@syd.com.mx',"SOCIO SYD");
                $m->to($data['email'], $data['name'].' '.$data['last_name'])->subject('Bienvenido al programa de lealtad SYD');
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
        //$total = $this->totalAmount();
        //$noti = $this->getNotifications();

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
        //$total = $this->totalAmount();
        //$noti = $this->getNotifications();

        if ($update_customer){
            $activated = false;
            return view('pages.activationPage', compact('activated'));
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
        $is_register = $is_activate = DB::table('customers_sessions')
            ->select('email')
            ->where('email', '=', $request->email)
            ->first();

        if ($is_register === null){
            return back()->with('register','');
        }

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

        //Login
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
        $data = Customer::where('email', $request['email'])->first();
        try {
            \Mail::send('emails.restorePassword',['data'=>$data], function($m) use ($data){
                $m->from('sociosyd@syd.com.mx',"Socio SyD");
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
        $update_customer = DB::table('customers_sessions')->where('client_number', '=', $request['client_number'])->update([
            'password' => $password,
        ]);

        if ($update_customer === 1){
            $this->send_signUp_success($request['email']);
            return response()->json(['success'=>'true','status' =>200]);
        }
        return response()->json(['success'=>'false','status' =>401]);
    }

    //Send signUp success email
    public function send_signUp_success($email) {
        $data = Customer::where('email', $email)->first();
        try {
            \Mail::send('emails.registroExitoso',['data'=>$data], function($m) use ($data){
                $m->from('sociosyd@syd.com.mx',"SOCIO SYD");
                $m->to($data->email, $data->name.' '.$data->last_name)->subject('Bienvenido al programa de lealtad SYD');
            });
            return response()->json(['success'=>'true','status' =>200]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>'true','status' =>401]);
        }
    }

    //Deactivate account
    public function deactivate_account(Request $request){
        $updated = DB::table('customers_sessions')
            ->where('id', '=', Auth::user()->id)
            ->update(['active'=> 0]);

        if (!$updated){
            return view('pages.Account.status');
        }

        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/');
    }

    //Send email to activate account
    public function send_activate_account(Request $request) {
        $request = $request->input();

        $data = Customer::where('email', $request['email'])->first();
        try {
            \Mail::send('emails.activateAccount',['data'=>$data], function($m) use ($data){
                $m->from('sociosyd@syd.com.mx',"Socio SyD");
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
            'active'   => 1
        ]);

        if ($update_customer === 1){
            return response()->json(['success'=>'true','status' =>200]);
        }
        return response()->json(['success'=>'false','status' =>401]);
    }

    //Go to My account
    public function account_status(){
        //dd(Auth::user()->client_number);
        $data = Customer::where('email', Auth::user()->email)->first();
        $dataSession = CustomersSession::where('email', Auth::user()->email)->first();
        $tr = $this->get_trans(
                    $data['client_number'],
                    $dataSession['branch_number']);
        $total = $this->totalAmount();
        $noti = $this->getNotifications();

        $mes = Carbon::parse()->locale('es');
        $data->mes = $mes;


        //$data->is_branch = $dataSession->is_branch;
        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('branches_clients')
                                ->where('branch_number','=',$dataSession->branch_number)
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
        $query = DB::table('customers')
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

        $customer_trans = DB::table('transactions')
            ->join('material_type', 'transactions.tmat', '=', 'material_type.code')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $client_number)
            ->where('transactions.branch_number','=', $branch_number)
            ->whereMonth('transaction_date','=',$now)
            ->get();

        return $customer_trans;
    }

    //Go to My documments section
    public function my_documents() {
        $data = Customer::where('email', Auth::user()->email)->first();
        $dataSession = CustomersSession::where('email', Auth::user()->email)->first();

        //$data->is_branch = $dataSession->is_branch;
        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('branches_clients')
                                ->where('branch_number','=',$dataSession->branch_number)
                                ->get();
        $query = json_decode($query);
        $query = (array)$query;
        if(empty($query) == false){
            $data->branch_name = $query[0]->branch_name;
        }

        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        //$link = \Storage::cloud()->temporaryUrl('polizas/'.Auth::user()->id.'.pdf', now()->addMinute(2));
        //$exist = \Storage::cloud()->exists('polizas/'.Auth::user()->id.'.pdf');
        $total = $this->totalAmount();
        $noti = $this->getNotifications();
        $number = '';
        if(Auth::user()->client_type === '3'){
            $data = Customer::where('email', Auth::user()->email)->first();
            $number = DB::table('associates')
                ->select('number')
                ->where('email', Auth::user()->email)
                ->first();
        }

        $beneficiaries = DB::table('beneficiaries')
            ->where('customer_id', '=', $data->id)
            ->get();

        if (Auth::user()->client_type === "3"){
            $customer = DB::table('customers')
                ->where('email', '=', Auth::user()->email)
                ->first();
            $beneficiaries = DB::table('beneficiaries')
                ->where('customer_id', '=', $customer->id)
                ->get();
        }
        $now = Carbon::now();
        $current_month = $now->month;
        $data_customer = DB::table('transactions')
        ->where('branch_number', Auth::user()->branch_number)
        ->whereMonth('transaction_date','=',$current_month)
        ->get();
    $totalAmount = 0.0;
    foreach ($data_customer as $d){
        $amount_customer = floatval($d->amount);
        strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
    }

    $level = 0;
    if (Auth::user()->client_type != "2"){
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

    if (Auth::user()->client_type === "2"){
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

        //dd($beneficiaries);

        return view('pages.Account.documents', compact('data','level','total','noti', 'number', 'owner', 'beneficiaries'));
    }

    //get transactions by branch_number or client_number
    public function getTransCadena($email){
        $dataSession = DB::table('customers_sessions')
                        ->where('email','=', $email)->first();
        $now = Carbon::now();
        $current_month = $now->month;

        $data= DB::table('transactions')
                    ->where('client_number','=', $dataSession->client_number)
                    ->where('branch_number','=', $dataSession->branch_number)
                    ->whereMonth('transaction_date','=',$current_month)
                    ->get();
        return $data;

    }

    //Go to register beneficiary
    public function register_beneficiary () {
        $data = Customer::where('email', Auth::user()->email)->first();
        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        $number = '';
        $dataSession = CustomersSession::where('email', Auth::user()->email)->first();

        $data->is_branch = $dataSession->is_branch;
        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('branches_clients')
                                ->where('branch_number','=',$dataSession->branch_number)
                                ->get();
        //$data->branch_name = $branch_name[0]->branch_name;
        $query = json_decode($query);
        $query = (array)$query;
        if(empty($query) == false){
            $data->branch_name = $query[0]->branch_name;
        }


        if(Auth::user()->client_type === '3'){
            $data = Customer::where('email', Auth::user()->email)->first();
            $number = DB::table('associates')
                ->select('number')
                -> where('email', Auth::user()->email)
                ->first();
        }

        $signature = DB::table('customers_sessions')
            ->select('signature_id')
            ->where('id', '=', Auth::user()->id)
            ->first();

        $noti = $this->getNotifications();
        $total = $this->totalAmount();
        $is_cnt = 'true';

        $now = Carbon::now();
        $current_month = $now->month;

        $data_customer = $this->getTransCadena(Auth::user()->email);
        $totalAmount = 0.0;
        foreach ($data_customer as $d){
            $amount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
        }

        $level = 0;
        if (Auth::user()->client_type !== "2"){
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

        if (Auth::user()->client_type === "2"){
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
                        ->where('customer_id','=', $data['id'])
                        ->get();
        $beneficiaries = json_decode($beneficiaries);
        $beneficiary = (array)$beneficiaries;//convert to array

        if(empty($beneficiaries) == false){
            return view('pages.Account.beneficiary', compact('data', 'beneficiary', 'noti', 'total', 'level', 'number', 'owner'));
        }

        $signature = $signature->signature_id;

        return view('pages.Account.beneficiary', compact('data', 'signature', 'level','total','noti', 'is_cnt', 'number', 'owner'));
    }

    //Go to benefits of Safe
    public function benefits () {
        $data = Customer::where('email', Auth::user()->email)->first();
        $dataSession = CustomersSession::where('email', Auth::user()->email)->first();

        //$data->is_branch = $dataSession->is_branch;
        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('branches_clients')
                                ->where('client_number','=',$data->client_number)
                                ->where('branch_number','=',$dataSession->branch_number)
                                ->get();
        $query = json_decode($query);
        $query = (array)$query;
        if(empty($query) == false){
            $data->branch_name = $query[0]->branch_name;
        }

        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        $number = '';
        if(Auth::user()->client_type === '3'){
            $data = Customer::where('email', Auth::user()->email)->first();
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

        $now = Carbon::now();
        $current_month = $now->month;

        $data_customer = $this->getTransCadena(Auth::user()->email);
        $totalAmount = 0.0;
        foreach ($data_customer as $d){
            $amount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
        }

        $level = 0;
        if (Auth::user()->client_type != "2"){
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

        if (Auth::user()->client_type === "2"){
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
        return view('pages.Account.benefitSafe', compact('data', 'level','total','noti', 'is_cnt', 'number', 'owner'));
    }

    //Go to signature section in benefits
    public function benefits_signature () {
        $data = Customer::where('email', Auth::user()->email)->first();
        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        $number = '';
        $query = DB::table('signatures')
            ->where('customer_id','=',Auth::user()->id)
            ->get();
        if(Auth::user()->client_type === '3'){
            $data = Customer::where('email', Auth::user()->email)->first();
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
        $total = $this->totalAmount();
        $noti = $this->getNotifications();

        $now = Carbon::now();
        $current_month = $now->month;

        $data_customer = $this->getTransCadena(Auth::user()->email);
        $totalAmount = 0.0;
        foreach ($data_customer as $d){
            $amount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
        }

        $level = 0;
        if (Auth::user()->client_type != "2"){
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

        if (Auth::user()->client_type === "2"){
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

        return view('pages.Account.signature', compact('data', 'imgData','total','noti', 'level', 'number', 'owner'));
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
        $now = Carbon::now();
        $current_month = $now->month;

        $data_customer = $this->getTransCadena(Auth::user()->email);
        $totalAmount = 0.0;
        foreach ($data_customer as $d){
            $amount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
        }

        $level = 0;
        if (Auth::user()->client_type != "2"){
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

        if (Auth::user()->client_type === "2"){
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
                    $user = Customer::where('client_number', Auth::user()->client_number)->first();
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
                                        ->where('client_number','=',$user['client_number'])
                                        ->update([
                                            'imgData'    => $request['imgData'],
                                            'updated_at' => date('Y-m-d H:i:s')
                                        ]);
                        }

                        if(empty($data) === true){
                            if(Auth::user()->client_type !== "3"){
                                $idSign = DB::table('signatures')->insertGetId([
                                    'client_number'   => $user['client_number'],
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
                                                ->where('client_number', '=', $user['client_number'])
                                                ->update([
                                                    'signature_id' => $idSign
                                                ]);
                        }
                    }

                    if ($idSign === 1 ||  $idSign === true || is_null($idSign) == false){ //if everything ok, redirect
                        return redirect()->route('customer.benefits', compact('level'));
                    }
                //}
                //else u r a robot
            //}
        //}
    }

    //Go to benefits of assistance
    public function benefits_assistance () {
        $data = Customer::where('email', Auth::user()->email)->first();
        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        $number = '';
        $dataSession = CustomersSession::where('email', Auth::user()->email)->first();

        $data->is_branch = $dataSession->is_branch;
        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('branches_clients')
                    ->where('branch_number','=',$dataSession->branch_number)
                    ->get();
        $query = json_decode($query);
        $query = (array)$query;
        if(empty($query) == false){
            $data->branch_name = $query[0]->branch_name;//get branch name to the view
        }

        if(Auth::user()->client_type === '3'){
            $data = Customer::where('email', Auth::user()->email)->first();
            $number = DB::table('associates')
                ->select('number')
                -> where('email', Auth::user()->email)
                ->first();
        }
        $now = Carbon::now();
        $current_month = $now->month;

        $data_customer = $this->getTransCadena(Auth::user()->email);
        $totalAmount = 0.0;
        foreach ($data_customer as $d){
            $amount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
        }

        $level = 0;
        if (Auth::user()->client_type != "2"){
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

        if (Auth::user()->client_type === "2"){
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
        return view('pages.Account.assistance', compact('data', 'level','total','noti', 'number', 'owner'));
    }

    //calculated totalAmount
    public function totalAmount(){
        $now = Carbon::now();
        $current_month = $now->month;

        $data_customer = $this->getTransCadena(Auth::user()->email);
        $totalAmount = 0.0;
        foreach ($data_customer as $d){
            $amount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
        }

        return $totalAmount;
    }

    //get the total amount by passing client number as a parameter
    public function totalAmountById($client_number,$email){
        $now = Carbon::now();
        $current_month = $now->month;

        $data_customer = $this->getTransCadena($email);
        $totalAmount = 0.0;
        foreach ($data_customer as $d){
            $amount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
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
        if($data[0]->client_type != 2 && $total > 2500.01){
            $update_notifications = DB::table('notifications')
                                    ->where('branch_number','=',$data[0]->branch_number)
                                    ->update([
                                        'available' => 1
                                    ]);
        }

        if($data[0]->client_type == 2 && $total > 200.02){
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
        $data = Customer::where('email', Auth::user()->email)->first();
        $total = $this->totalAmount();
        $noti = $this->getNotifications();
        return view('pages.Account.beneficiaries', compact('data','total','noti'));
    }

    //load data from associates AQUI
    public function employees () {
        $data = Customer::where('email', Auth::user()->email)->first();
        $dataSession = CustomersSession::where('email', Auth::user()->email)->first();
        $associates = DB::table('associates')
                            ->where([
                                ['client_number','=',$data->client_number],
                                ['branch_number','=',$dataSession->branch_number],
                                ['active_association', '=', 1]
                                ])
                            ->get();

        $data->branch_number = $dataSession->branch_number;
        $query = DB::table('branches_clients')
                                ->where('branch_number','=',$dataSession->branch_number)
                                ->get();
        $query = json_decode($query);
        $query = (array)$query;
        if(empty($query) == false){
            $data->branch_name = $query[0]->branch_name;//get branch name to the view
        }
        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        //Calculated the limit of employee
        $response = $this->employeeLimit(
                            Auth::user()->email,
                            Auth::user()->id,
                            Auth::user()->client_type);
        $total = $this->totalAmount();
        $noti = $this->getNotifications();

        $data->limiteAsociados = $response->limiteAsociados;
        $data->validated = $response->validated;

        return view('pages.Account.employees', compact('data','associates','total','noti','owner'));
    }

    //Function to generate limit for add employees according the rules
    public function employeeLimit($email, $id, $client_type){
        $data = Customer::where('email', $email)->first();
        $dataSession = CustomersSession::where('email', $email)->first();
        $now = Carbon::now();

        $query = DB::table('transactions')
                    ->where('client_number','=', $data['client_number'])
                    ->where('branch_number','=', $dataSession['branch_number'])
                    ->whereMonth('transaction_date','=',$now)
                    ->sum('amount');

        //round the number with only 2 decimals
        $limit = (float)number_format($query,2,'.','');
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

        return $data;
    }

    //Edit Employees
    public function editEmployee($id){
        $data = Customer::where('email', Auth::user()->email)->first();
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



    public function send_email($name, $email, $token){
    	\Mail::send('Collectors.email_customer',['name'=>$name,'token'=>$token], function($m) use ($email, $name){
    		$m->from('sociosyd@syd.com.mx',"Socio SyD");
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

    public function home(){
        $total = $this->totalAmount();
        $noti  = $this->getNotifications();

        return view('pages.home',compact('total','noti'));
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

    //Contact form
    public function contact_us(Request $request){
        $SYD_EMAILS = ["rguerrero@syd.com.mx",
                     "nebratt@syd.com.mx",
                     "ecommerce@syd.com.mx",
                     "equezada@syd.com.mx",
                     "sociosyd@syd.com"];
        //$to = explode(',',$SYD_EMAILS);
        $data = $request->all();
        try {
            Mail::send('emails.messageContact',['data'=>$data],function($m) use ($SYD_EMAILS){
                $m->to($SYD_EMAILS)->subject('Nuevo Registro de Socio SyD');
            });
            return redirect()->route('home');
        } catch (\Throwable $th) {
            return response()->json(['error'=>'algo salio mal','status' =>401, 'desc'=>$th->getMessage()]);
        }
    }

    //invitation email associate
    public function invitation($data){
        $email = $data['email'];
        try {
            Mail::send('emails.invitacionAsociado',['data'=>$data], function($m) use ($email){
                $m->from('sociosyd@syd.com.mx',"Socio SyD");
                $m->to($email)->subject("Invitación a Socio SYD");
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
                $m->from('sociosyd@syd.com.mx',"Socio SyD");
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

        return view('pages.invitationForm', compact('employee','total','noti'));
    }
}
