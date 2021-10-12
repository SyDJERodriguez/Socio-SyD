<?php


namespace App\Http\Controllers\Api;


use App\Customer;
use App\Collector;
use App\CustomersSession;
use App\CustomerPlatform;
use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Repositories\ClientNumberRepository;
use App\Repositories\CustomersRepository;
use Carbon\Carbon;
use GuzzleHttp\Client;
use http\Env\Response;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Validator;
use DB;
use Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Exports\SessionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\Twilio\TwilioService;

class CustomerController extends Controller
{
    /** Functionality for send SMS with certificate **/
    public function send_sms_certificate(Request $request) {
        $request = $request->input();

        $result = array('status'=>0, 'message'=>'Procesando registros...', 'certificados_enviados'=>0);

        $from    = Carbon::createFromFormat('Y-m-d',$request['from']);
        $to      = Carbon::createFromFormat('Y-m-d',$request['to']);

        $customers = DB::table('customers_sessions')
            ->whereBetween('created_at', [$from,$to])
            ->select(
                'customers_sessions.client_number AS client_number',
                'customers_sessions.branch_number AS branch_number',
                'customers_sessions.client_type AS client_type',
                'customers_sessions.mobile AS mobile',
                'customers_sessions.email AS email',
                'customers_sessions.created_at AS created_at',
                'customers_sessions.active AS active'
            )
            ->get();

        //return $customers;

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;

        foreach ($customers as $client){
            $client_transaction = DB::table('transactions')
                ->where('client_number', $client->client_number)
                ->where('branch_number', $client->branch_number)
                ->whereMonth('transaction_date','=',$current_month)
                ->whereYear('transaction_date', '=', $current_year )
                ->get();
            $totalAmount = 0.0;

            foreach ($client_transaction as $transaction){
                $amount_customer = floatval($transaction->amount);
                strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
            }
            $client->amount = $totalAmount;

            $url = url('/sms_pdf/'.$client->client_number.'/'.$client->branch_number);
            $messsage = '¡Felicidades! Ya tienes SEGURO DE ACCIDENTES como #SocioSyD. Descarga, llena y firma tu certificado aquí '.$url;

            $client->url = $url;
           /* if($client->client_type === '2'){
                if ($totalAmount>200){*/
                   // try {
                        TwilioService::send_sms($messsage,'+52'.$client->mobile);
                        $result['certificados_enviados']++;

                        \Mail::send("emails.emailPoliza", ['client'=>$client], function($m) use ($client){
                            $m->from('noreply@syd.com.mx','Socio SYD');
                            $m->to($client->email,'Socio')->subject('¡Felicidades! Ya tienes SEGURO DE ACCIDENTES como #SocioSyD. Descarga, llena y firma tu certificado aquí');
                        });

            $result['certificados_enviados']++;
                    //    return response()->json(['success'=>'true','status'=>200]);
                    //} catch (\Throwable $th) {
                        //throw $th;
                     //   return response()->json(['success'=>'false','status' =>401]);
                    //}

           /*     }
            }else if($client->client_type === '1' || $client->client_type === '3' || $client->client_type === '4'){
                if ($totalAmount>2500){
                    TwilioService::send_sms($messsage,'+52'.$client->mobile);
                    $result['certificados_enviados']++;
                }
            }*/
        }

        $result['status'] = 200;
        $result['message'] = 'Registros procesados correctamente';
        $result['registros'] = $customers;
        return response()->json($result);
    }

    /** Webservices for get registered clients in Pegaso platform **/
    public function get_registered_clients() {
        $registered_clients = DB::table('customers_sessions')
            ->join('customer_platforms', 'customer_platforms.email', '=', 'customers_sessions.email')
            ->select(
                'customers_sessions.client_number AS client_number',
                         'customers_sessions.branch_number AS branch_number',
                         'customer_platforms.name AS name',
                         'customer_platforms.last_name AS last_name',
                         'customer_platforms.second_last_name AS second_last_name',
                         'customer_platforms.email AS email',
                         'customers_sessions.mobile AS phone',
                         'customer_platforms.birthday AS birthday',
                         'customers_sessions.created_at AS fecha_registro',
                         'customers_sessions.client_type AS type_user',
                         'customers_sessions.active'
            )
            ->get();

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;

        foreach ($registered_clients as $client){
            $client->fecha_registro = date_format(date_create($client->fecha_registro), "Y-m-d");

            $client_transaction = DB::table('transactions')
                ->where('client_number', $client->client_number)
                ->where('branch_number', $client->branch_number)
                ->whereMonth('transaction_date','=',$current_month)
                ->whereYear('transaction_date', '=', $current_year )
                ->get();
            $totalAmount = 0.0;

            if($client->type_user === '3'){
                $associate_data = DB::table('associates')
                    ->where('email', '=', $client->email)
                    ->first();

                $client->client_number = $client->client_number.'-'.$associate_data->number;
            }

            foreach ($client_transaction as $transaction){
                $amount_customer = floatval($transaction->amount);
                strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
            }
            $client->amount = $totalAmount;

            if($client->type_user === '1'){
                $client->type_user = 'Dueño de Negocio';
                if ($totalAmount>2500 && $totalAmount<=4500) {
                    $client->level= 'Bronce';
                }
                if ($totalAmount>4500 && $totalAmount<=7000) {
                    $client->level= 'Plata';
                }
                if ($totalAmount>7000) {
                    $client->level= 'Oro';
                }
                if ($totalAmount == 0) {
                    $client->level= 'Sin beneficios';
                }
            }else if($client->type_user === '2'){
                $client->type_user = 'Mecánico Individual';
                if ($totalAmount>200 && $totalAmount<=500) {
                    $client->level= 'Bronce';
                }
                if ($totalAmount>500 && $totalAmount<=1300) {
                    $client->level= 'Plata';
                }
                if ($totalAmount>1300) {
                    $client->level= 'Oro';
                }
                if ($totalAmount == 0) {
                    $client->level= 'Sin beneficios';
                }
            }else if($client->type_user === '3'){
                $client->type_user = 'Empleado Dependiente';
                if ($totalAmount>2500 && $totalAmount<=4500) {
                    $client->level= 'Bronce';
                }
                if ($totalAmount>4500 && $totalAmount<=7000) {
                    $client->level= 'Plata';
                }
                if ($totalAmount>7000) {
                    $client->level= 'Oro';
                }
                if ($totalAmount == 0) {
                    $client->level= 'Sin beneficios';
                }
            }else if($client->type_user === '4'){
                $client->type_user = 'Cadenas';
                if ($totalAmount>2500 && $totalAmount<=4500) {
                    $client->level= 'Bronce';
                }
                if ($totalAmount>4500 && $totalAmount<=7000) {
                    $client->level= 'Plata';
                }
                if ($totalAmount>7000) {
                    $client->level= 'Oro';
                }
                if ($totalAmount == 0) {
                    $client->level= 'Sin beneficios';
                }
            }


            $client->active === 0 ? $client->active = 'false' : $client->active = 'true';

            $xalapa_survey = DB::table('surveys')
                ->where('client_number', '=', $client->client_number)
                ->where('survey', '=', 'xalapa')
                ->first();

            $quality_survey = DB::table('surveys')
                ->where('client_number', '=', $client->client_number)
                ->where('survey', '=', 'calidad')
                ->first();

            $xalapa_survey ? $client->xalapa_survey = self::get_surveys($xalapa_survey) : $client->xalapa_survey = 'No tiene encuesta registrada';
            $quality_survey ? $client->quality_survey = self::get_surveys($quality_survey) : $client->quality_survey = 'No tiene encuesta registrada';
        }

        return response()->json($registered_clients);
    }

    /** Webservices for save survey of typeform **/
    public function save_survey_typeform (Request $request) {
        $request = $request->input();

        $questions = [];
        foreach ($request['questions'] as $question){
            $question = array(
                'label' => $question['label'],
                'id'    => $question['id']
            );

            array_push($questions,$question);
        }

        $client = array(
            'client_number' => $request['client_number'],
            'survey' => $request['survey'],
            'answers' => serialize($request['answer']),
            'questions' => serialize($questions),
        );
        DB::table('surveys')->insert($client);
        return response()->json($request);
    }

    /** Save customer in Socio SyD **/
    public function store(Request $request){
        $request = $request->input();

        //For customer_session table
        $client_number = '00'.$request['client_number'];
        $password      = Hash::make($request['password']);
        $rfc           = '';

        //Verify if the client number if in our database
        $dataClient = DB::table('client_numbers')->where('client_number','=',$client_number)->first();
        if($dataClient == null){
            return response()->json(['status'=>'400', 'message'=>'El número de cliente no se encuentra en la base de datos']);
        }

        //Verify if the client number is registered in the platform
        $verify_email = CustomersSession::where('client_number', $client_number)
            ->where('branch_number', $client_number)
            ->first();
        if ($verify_email !== null) {
            return response()->json(['status'=>'400', 'message'=>'El número de cliente ya ha sido registrado previamente']);
        }

        //Verify if the email is registered in the platform
        $verify_email = CustomersSession::where('email', $request['email'])->first();
        if ($verify_email !== null) {
            return response()->json(['status'=>'400', 'message'=>'El email ya ha sido registrado previamente']);
        }

        //Verify if the mobile is registered in the platform
        $verify_mobile_number = CustomersSession::where('mobile', $request['mobile_number'])->first();
        if ($verify_mobile_number !== null) {
            return response()->json(['status'=>'400', 'message'=>'El número de celular ya ha sido registrado previamente']);
        }

        $update_customer = DB::table('customer_platforms')
            ->where('email', '=', $request['email'])
            ->first();

        $birthday = explode("-",$request['birthday']);

        $year = substr($birthday[0],2,2);


        $birthday = $birthday[2]."/".$birthday[1]."/".$year;

        $rfc = self::generate_rfc($request['name'],$request['last_name'],$request['second_last_name'],$birthday);

        if($update_customer == null){
            //Insert data in customers table
            $save_customer = DB::table('customer_platforms')->insert([
                'client_number'    => $client_number,
                'name'             => $request['name'],
                'last_name'        => $request['last_name'],
                'second_last_name' => $request['second_last_name'],
                'email'            => $request['email'], //This is for customers_session table too
                'mobile_number'    => $request['mobile_number'],
                'company'          => isset($request['business_name']) ? $request['business_name'] : null,
                'birthday'         => $request['birthday'],
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
                'rfc'              => $rfc,
                'work'             => isset($request['business_type']) ? $request['business_type'] : null,
                'gender'           => isset($request['gender']) ? $request['gender'] : null,
                'collector_id'     => 6,
                'RFC_Company'      => isset($request['RFC_Company']) ? $request['RFC_Company'] : null
            ]);
        }else{
            return response()->json(['status'=>'400', 'message'=>'El email ya ha sido registrado previamente']);
        }

        $save_register = DB::table('customers_sessions')->insert([
            'client_number' => $client_number,
            'client_type'   => $request['client_type'], //1 duenio; 2 independiente
            'email'         => $request['email'],
            'mobile'        => $request['mobile_number'],
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
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

        if ($save_customer === 1 && $save_register === true){
            $this->send_welcome_email($request['email']);
            return response()->json(['status'=>'200', 'message'=>'Los datos se han registrado correctamente']);
        }elseif ($save_customer === true && $save_register === true){
            $this->send_welcome_email($request['email']);
            return response()->json(['status'=>'200', 'message'=>'Los datos se han registrado correctamente']);
        }

        return response()->json($request);
    }

    public function apiList(){
        $customers = Customer::with('branch','origin')->get();
        return response()->json($customers);
    }

    /** Webservices for save client numbers of SAP **/
    public function insert_client_number(Request $request){
        \Log::channel('api')->info('===========================START PROCESS==================================================================================');
        $agent = new Agent();
        \Log::channel('api')->info('Solicitud a insert in log: ip->'.Utils::getUserIpAddr().' device->'.$agent->platform().' - '.$agent->browser());

        $return = array('status'=>0, 'msg'=>'Error desconocido');
        $request = $request->input();
        \Log::channel('api')->info('Procesando datos:  '.json_encode($request));

        $validator = $this->validator($request);
        if($validator->fails()){
            return response()->json(array(
                'code'   => 0,
                'msg'    => 'Verifica los datos ingresados',
                'errors' => $validator->errors()
            ), 400);
        }
       try{
           $client = array(
               'client_number' => '00'.$request['client_number'],
               'flags' => 'new_client',
               'creacion_sap' =>$request['created_at'] ,
               'plazo' => $request['pay_cond'],
               'source' => 'api'
           );
           $res = ClientNumberRepository::save_client_number($client);
           $return['status'] = 1;
           $return['msg'] = 'Registro almacenado correctamente';
           \Log::channel('api')->info('Procesado correctamente :  '.json_encode($res));
           \Log::channel('api')->info('=====================================END PROCESS========================================================================');
           return response()->json($return,200);
       }catch (\Exception $e){
           \Log::channel('api')->info(' Ocurrio un error al procesar la petición '.$e->getMessage().' File '.$e->getFile().' Line '.$e->getLine());
           $return['status'] = 0;
           $return['msg'] = 'Ocurrio un error al guardar el registro: '.$e->getMessage();
           \Log::channel('api')->info('=====================================END PROCESS========================================================================');
           return response()->json($return,400);
       }


    }

    /** Webservices for sent clients numbers updated **/
    public function get_clients_updated(Request $request){
        \Log::channel('api')->info('=========================== START PROCESS TO GET REGISTERS ==================================');
        $agent = new Agent();
        \Log::channel('api')->info('Solicitud a insert in log: ip->'.Utils::getUserIpAddr().' device->'.$agent->platform().' - '.$agent->browser());

        $return = array('status'=>0, 'msg'=>'Error desconocido');
        $request = $request->input();
        \Log::channel('api')->info('Procesando datos:  '.json_encode($request));
        if($request['date'] === null || $request['date'] === '""' || $request['date'] === ''){
            try{
                $res = CustomersRepository::get_clients_today();
                $return['status'] = 1;
                $return['msg'] = 'Datos procesados correctamente';
                \Log::channel('api')->info('Petición de datos día anterior');
                \Log::channel('api')->info('Procesado correctamente');
                \Log::channel('api')->info('Número de registros enviados:'.$res['registers_sent']);
                \Log::channel('api')->info('========================== END PROCESS TO GET REGISTERS ===================================');
                return response($res['data'], 200);
            }catch (\Exception $e){
                \Log::channel('api')->info(' Ocurrio un error al procesar la petición '.$e->getMessage().' File '.$e->getFile().' Line '.$e->getLine());
                $return['status'] = 400;
                $return['msg'] = 'Ocurrio un error al solicitar los datos';
                \Log::channel('api')->info('========================== END PROCESS TO GET REGISTERS ===================================');
                return response()->json($return,400);
            }
        }else{
            try{
                $format = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';
                if (!preg_match($format, $request['date'])){
                    return response()->json(array(
                        'status'   => 200,
                        'msg'    => 'Formato de fecha no válido',
                    ), 400);
                }
                $res = CustomersRepository::get_specific_clients($request['date']);
                $return['status'] = 1;
                $return['msg'] = 'Datos procesados correctamente';
                \Log::channel('api')->info('Petición de fecha específica');
                \Log::channel('api')->info('Procesado correctamente');
                \Log::channel('api')->info('Número de registros enviados:'.$res['registers_sent']);
                \Log::channel('api')->info('========================== END PROCESS TO GET REGISTERS ===================================');
                return response($res['data'], 200);
            }catch (\Exception $e){
                \Log::channel('api')->info(' Ocurrio un error al procesar la petición '.$e->getMessage().' File '.$e->getFile().' Line '.$e->getLine());
                $return['status'] = 400;
                $return['msg'] = 'Ocurrio un error al solicitar los datos';
                \Log::channel('api')->info('========================== END PROCESS TO GET REGISTERS ===================================');
                return response()->json($return,400);
            }
        }

    }

    /** Webservices for save survey of typeform **/
    public function get_client(Request $request){
        $return = array('status'=>0, 'msg'=>'Error desconocido');
        $request = $request->input();
        if (isset($request['client_number'])){
            if(isset($request['email'])){
                $response = CustomersRepository::get_client_by_email($request['client_number'], $request['email']);
                return response()->json($response);
            }elseif (isset($request['mobile_number'])){
                $response = CustomersRepository::get_client_by_mobile($request['client_number'], $request['mobile_number']);
                return response()->json($response);
            }else{
                return ['status'=>'400','message'=>'Por favor ingresa el email o el número teléfono.'];
            }
        }else{
            return ['status'=>'400','message'=>'Por favor ingresa un número de cliente.'];
        }

    }
    public function ws_update_client(Request $request){
        $return = array('status'=>0, 'msg'=>'Error desconocido');
        $request = $request->input();
        if($request['email']) {
            $customer = Customer::where('email',$request['email'])->first();
            $branch = DB::table('branches')
                ->select('branches.name')
                ->where('id','=',$request['branch_id'])
                ->first();
            $valuesnew = [
                'numero_cliente'   => $request['client_number'],
                'nombre'           => $request['name'],
                'apellido_paterno' => $request['last_name'],
                'apellido_materno' => $request['second_last_name'],
                'email'            => $request['email'],
                'telefono'         => $request['mobile_number'],
                'sucursal'         => $branch->name
            ];
            if($customer){
                return response()->json(['status'=>400, 'msg'=>'El email ya ha sido registrado.', 'data' => $valuesnew]);
                //return $this->update_customer($customer, $request->input(), $collector);
            }
        }
        if (isset($request['client_number'])){
            $request['client_number'] = '00'.$request['client_number'];
            $collector = Collector::find($request['collector_id']);
            if(2 ==CustomersRepository::ws_verifacte_number_client($request['client_number'])){
                if(isset($request['email'])){
                    if(isset($request['mobile_number'])){
                         if((CustomersRepository::ws_verifacte_mobile_number_with_clientnumber($request['client_number'],$request['mobile_number'])!=false)){
                        $response =CustomersRepository::ws_verifacte_mobile_number_with_clientnumber($request['client_number'],$request['mobile_number']);
                        return response()->json($response);
                         }else{
                        $query = Customer::where([['email', $request['email']], ['mobile_number', $request['mobile_number']]])->first();
                      if($query===null){
                        $query = Customer::Where('mobile_number',$request['mobile_number'])->first();
                           if($query){
                                 if($query->mobile_number && $query->client_number){
                                 $response =CustomersRepository::ws_verifacte_mobile_number_with_clientnumber(($query->client_number),($query->mobile_number));
                                   return response()->json($response);
                                  }elseif ($query->mobile_number && (empty($query->client_number) || $query->client_number === null) ){
                                       $response =CustomersRepository::ws_storage_customer($request,$collector,$query->id);
                                       return response()->json($response);
                                  }elseif (empty($query->mobile_number) && empty($query->client_number)){
                                       $response =CustomersRepository::ws_new_client($request, $collector);
                                        return response()->json($response);
                                   }

                                  }else{
                                  $response =CustomersRepository::ws_new_client($request,$collector);
                                  return response()->json($response);
                                         }

                        }else{
                            if(empty($query->phone_validate) || $query->phone_validate === null || $query->phone_validate === 0){
                                if(empty($query->client_number) || $query->client_number == null){
                                    $response =CustomersRepository::ws_storage_customer($request,$collector,$query->id);
                                       return response()->json($response);
                                }else if($query->client_number === $request['client_number']){
                                    $response =CustomersRepository::ws_verifacte_number_client($request['client_number']);
                                    return [response()->json($response)];
                                }else{
                                      $response = CustomersRepository::ws_verifacte_email_and_numberm($request['email'],$request['mobile_number']);
                                      return response()->json($response);
                                    }
                            }else if($query->phone_validate == 1){
                                $response = CustomersRepository::ws_verifacte_email_and_numberm($request['email'],$request['mobile_number']);
                                      return response()->json($response);
                            }else{
                                $response = CustomersRepository::ws_verifacte_email_and_numberm($request['email'],$request['mobile_number']);
                                      return response()->json($response);
                            }

                             }

                          }
                    }else{
                        return response()->json(['status'=>400, 'msg'=>'El número de teléfono es obligatorio.']);
                    }
                }else{
                    if (isset($request['mobile_number'])){
                        $query = Customer::where([['mobile_number', $request['mobile_number']]])->first();
                    }else{
                        return response()->json(['status'=>400, 'msg'=>'El número de teléfono es obligatorio.']);
                    }

                    if($query === null ){
                        $response =CustomersRepository::ws_new_client($request, $collector);
                                        return response()->json($response);
                    }else{
                        if(empty($query->phone_validate) || $query->phone_validate === null){
                            if(empty($query->client_number) || $query->client_number == null){
                                $response =CustomersRepository::ws_storage_customer($request,$collector, $query->id);
                                       return response()->json($response);
                            }else if($query->client_number === $request['client_number']){
                                $response =CustomersRepository::ws_verifacte_number_client($query->client_number);
                                return response()->json($response);
                            }else{
                                $response =CustomersRepository::ws_verifacte_email_and_numberm($request['email'],$request['mobile_number']);
                                return response()->json($response);
                            }
                        }elseif ($query->phone_validate == 1){
                            $response =CustomersRepository::ws_verifacte_mobile_number($query->mobile_number);
                            return response()->json($response);
                        }else{
                            $response =CustomersRepository::ws_verifacte_mobile_number($request['mobile_number']);
                            return response()->json($response);
                        }
                    }
                }


            }else {
                $response = CustomersRepository::ws_verifacte_number_client($request['client_number']);
                return response()->json($response);

            }

        }else{
            return ['status'=>'400','message'=>'Por favor ingresa un número de cliente.'];
        }

    }

    //Report for Telasist
    public function report_telasist(Request $request){
        $response = "For telasis";

        $now = Carbon::now();
        $current_month = $now->month;
        $transactions = DB::table('transactions')
            //->select('transactions.client_number','transactions.amount', 'transactions.branch_number')
            ->selectRaw('transactions.client_number as client_number')
            ->selectRaw('SUM(transactions.amount) as total')
            ->whereMonth('transaction_date','=',$current_month)
            //->whereNull('transactions.branch_number')
            ->groupBy('transactions.client_number')
            ->get();

        //return response()->json($transactions);

        $data = [];
        foreach ($transactions as $transaction){
           $customer_type = CustomersSession::where('client_number', $transaction->client_number)
                ->select('client_type', 'email')
                ->get();
            //dd($customer_type);
            foreach ($customer_type as $customer){
                $customer_info = CustomerPlatform::where('email', $customer->email)
                    ->select('id', 'name', 'last_name', 'second_last_name', 'birthday', 'mobile_number', 'gender')
                    ->first();


                $level = '';
                if ($customer->client_type != "2"){
                    if ($transaction->total>4500 && $transaction->total<=7000) {
                        $level = 'plata';
                    }
                    if ($transaction->total>7000) {
                        $level = 'oro';
                    }
                }

                if ($customer->client_type === "2"){
                    if ($transaction->total>500 && $transaction->total<=1300) {
                        $level = 'plata';
                    }
                    if ($transaction->total>1300) {
                        $level = 'oro';
                    }
                }

                $customer_data = $transaction->client_number.'-'.
                    $customer_info->id.'|'.
                    $customer_info->name.'|'.
                    $customer_info->last_name.'|'.
                    $customer_info->second_last_name.'|'.
                    $customer->email.'|'.
                    $customer_info->birthday.'|'.
                    $customer_info->mobile_number.'|'.
                    $customer_info->gender.'|'.$level;


                if ($level === 'plata' || $level === 'oro'){
                    array_push($data,$customer_data);
                }
            }
        }
        $array_num = count($data);
        $content = '';
        for ($i = 0; $i < $array_num; $i++){
            $content .= $data[$i];
            $content .= "\n";
        }

        $current_date = Carbon::now()->format('Y-m-d');

        $fileName = 'altas_syd_'.$current_date.'.txt';
        $fileName = str_replace('','-',$fileName);
        $headers = [
            'Content-type' => 'text/plain',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),

        ];
        return \Response::make($content, 200, $headers);
        //return response()->json($data);
    }

    //Report for Chubb
    public function chubb_report(){
        //$response = "For chubb";
        $now = Carbon::now();
        $current_month = $now->month;
        $data = DB::table('customer_platforms')
                ->join('customers_sessions', 'customers_sessions.email', '=', 'customer_platforms.email')
                ->join('transactions', 'customers_sessions.branch_number', '=', 'transactions.branch_number')
                //->join('associates', 'associates.email', '=', 'customer_platforms.email')
                ->whereMonth('transaction_date','=',$current_month)
                ->selectRaw('customer_platforms.client_number as client_number')
                ->selectRaw('customer_platforms.name as name')
                ->selectRaw('customer_platforms.last_name as lastname')
                ->selectRaw('customer_platforms.second_last_name as secondLastName')
                ->selectRaw('customer_platforms.rfc as rfc')
                ->selectRaw('customer_platforms.birthday as bday')
                ->selectRaw('customer_platforms.gender as gender')
                ->selectRaw('customers_sessions.client_type as level')
                ->selectRaw('SUM(transactions.amount) as total')
                ->selectRaw('customers_sessions.is_associate as associateId')
                ->selectRaw('customers_sessions.email as email')
                ->groupBy('customer_platforms.email')
                ->get();

        foreach ($data as $key => $value) {

            if( $this->seguroAsistencia( $value->level, $value->total ) == false ){
                //true = ok; false borrar registro
                $data->forget($key);

            }else{
                $associateId = DB::table('associates')
                            ->select('number')
                            ->where('email','=',$value->email)
                            ->first();

                if( $associateId != null){
                    $value->client_number = $value->client_number . '-' . ($associateId->number);
                }
            }

            unset($value->level); //remove object property
            unset($value->total);
            unset($value->associateId);
            unset($value->email);
        }

        return Excel::download( new SessionExport( $data ), 'reporteChubb.xlsx' );
    }

    public function seguroAsistencia($level,$total){
        if( (int)$level != 2){
           return ($total > 2500);
        }

        if( (int)$level == 2 ){
            return ($total > 200);
        }
    }

    public function ws_verifacte_mobile_number(Request $request){
        $return = array('status'=>0, 'msg'=>'Error desconocido');
        $request = $request->input();
        $response = CustomersRepository::ws_verifacte_mobile_number($request['mobile_number']);
        return response()->json($response);

    }
    public function ws_verifacte_email(Request $request){
        $return = array('status'=>0, 'msg'=>'Error desconocido');
        $request = $request->input();
        $response = CustomersRepository::ws_verifacte_email($request['email']);
        return response()->json($response);

    }

    //Send welcome email
    public function send_welcome_email($email) {
        $data = CustomerPlatform::where('email', $email)->first();
        $dataSession = CustomersSession::where('email', $email)->first();
        $data->branch_number = $dataSession->branch_number;

        $url = url('account/verify/' . $data->branch_number);
        $messsage = 'Bienvenido a Socio SYD, por favor verifica tu cuenta dando clic en el siguiente enlace: '.$url;

        TwilioService::send_sms($messsage,'+52'.$dataSession->mobile);

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

    private function validator(array $data){
        return Validator::make($data,[
            'client_number' => 'required|digits:8',
            'created_at'  => 'required',
            'pay_cond'    => 'required',
        ],[
            'client_number.required' => 'El número de cliente es obligatorio',
            'client_number.unique' => 'El número de cliente ya existe',
            'client_number.digits' => 'El número de cliente debe ser de 8 digitos',
            'created_at.required'  => 'La fecha de creación SAP es obligatoria',
            'pay_cond.required'         => 'El plazo de pago es obligatorio',
        ]);
    }

    private function get_surveys($query_response){
        $questions = unserialize($query_response->questions);
        $answers = unserialize($query_response->answers);

        $final_answers = [];
        foreach ($questions as $question){
            if(isset($answers[$question['id']])){
                array_push($final_answers, array($question['label']=>$answers[$question['id']]['value']));
            }
        }
        return $final_answers;
    }

    private function remove_article($word){
        $correct_word = str_replace("DEL","", $word);
        $correct_word = str_replace("LAS","", $word);
        $correct_word = str_replace("DE","", $word);
        $correct_word = str_replace("LA","", $word);
        $correct_word = str_replace("Y","", $word);
        $correct_word = str_replace("A","", $word);
        $correct_word = str_replace("MC","", $word);
        $correct_word = str_replace("LOS","", $word);
        $correct_word = str_replace("VON","", $word);
        $correct_word = str_replace("VAN","", $word);

        return $correct_word;
    }

    private function is_vowel($letter){
        if($letter === "A" || $letter === "E" || $letter === "I" || $letter === "O" || $letter === "U" || $letter === "a" || $letter === "e" || $letter === "i" || $letter === "o" || $letter === "u"){
             return 1;
         }else{
            return 0;
        }
    }

    private function generate_rfc($name, $last_name, $second_last_name, $birthday){
        $name             = strtoupper((trim($name)));
        $last_name        = strtoupper((trim($last_name)));
        $second_last_name = strtoupper((trim($second_last_name)));

        $rfc = '';

        $last_name        = self::remove_article($last_name);
        $second_last_name = self::remove_article($second_last_name);

        $rfc = substr($last_name,0,1);

        $first_vowel = strlen($last_name);
        for ($i = 1; $i<$first_vowel; $i++){
            $v = substr($last_name,$i,1);
            if(self::is_vowel($v) === 1){
                $rfc .= $v;
                break;
            }
        }
        $rfc .= substr($second_last_name, 0, 1);
        $rfc .= substr($name, 0, 1);
        $rfc .= substr($birthday, 6, 2).substr($birthday,3,2).substr($birthday,0,2);

        return $rfc;
    }
}
