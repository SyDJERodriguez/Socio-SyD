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
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Validator;
use DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Exports\SessionExport;
use Maatwebsite\Excel\Facades\Excel;
class CustomerController extends Controller
{
    public function store(){

    }

    public function apiList(){
        $customers = Customer::with('branch','origin')->get();
        return response()->json($customers);
    }

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
            ->whereNull('transactions.branch_number')
            ->groupBy('transactions.client_number')
            ->get();

        return response()->json($transactions);

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
                        $level = 'plata';
                    }
                }

                $customer_data = $transaction->client_number.'-'.$customer_info->id.'|'.$customer_info->name.'|'.$customer_info->last_name.'|'.
                    $customer_info->second_last_name.'|'.$customer->email.'|'.$customer_info->birthday.'|'.$customer_info->mobile_number.'|'.
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

        $fileName = 'Telasist-'.$current_date.'.txt';
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
                ->whereMonth('transaction_date','=',$current_month)
                ->selectRaw('customer_platforms.client_number as client_number')
                ->selectRaw('customer_platforms.name as name')
                ->selectRaw('customer_platforms.last_name as lastname')
                ->selectRaw('customer_platforms.second_last_name as secondLastName')
                ->selectRaw('customer_platforms.rfc as rfc')
                ->selectRaw('customer_platforms.birthday as bday')
                ->selectRaw('customer_platforms.gender as gender')
                ->groupBy('customer_platforms.email')
                ->get();
        
        foreach( $data as $d ){

            if( $this->seguroAsistencia( $d->level, $d->total ) ){
                //true = ok; false borrar registro
            }
            //TODO: terminar el reporte CHUB, corregir el de telasist y cambiar el nombre del archivo.txt
            
        }
        
        return Excel::download( new SessionExport( $data ), 'reporteChubb.xlsx' );
    }

    public function seguroAsistencia($level,$total){
        if($level != '2'){
           return $total > 2500;
        }

        if( $level == '2' ){
            return $total > 200;
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
}
