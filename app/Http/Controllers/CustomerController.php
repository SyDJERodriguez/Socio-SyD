<?php

namespace App\Http\Controllers;

use App\Customer;
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
use function GuzzleHttp\Psr7\get_message_body_summary;
use Hash;
use http\Message;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Str;
use Validator;
use Yajra\DataTables\DataTables;
use GuzzleHttp\Client;

class CustomerController extends Controller
{
    public function stage_update(Request $request)
	{
		$return = [];
		$request = $request->input();
		try{
			$request['client_number'] = '00'.$request['client_number'];
			$code = $request['client_number'];
			$client_number = DB::table('client_numbers')->where('client_number',$code)->first();
            $collector = Collector::find($request['collector_id']);

			if($client_number === null)
                return Utils::set_log(0,'El código ingresado no existe',null,$request);

            //validamos que se pase el parametro email y que  exista en la tabla
            /*if($request['email'])
                if(Customer::where('email',$request['email'])->first())
                    return Utils::set_log(0,'El email ya ha sido registrado',$code,$request);

            if( Customer::Where('mobile_number',$request['mobile_number'])->first())
                return  Utils::set_log(0,'El número de celular ya ha sido registrado',$code,$request);*/

            if(Customer::where('client_number',$request['client_number'])->first())
                return Utils::set_log(0,'El número de cliente ya ha sido registrado previamente.',$code,$request);

            /**** Nueva lógica de registro ****/

            //Verificando flags
            if($client_number->flags != null){
                $flags__ = explode(',',$client_number->flags);
                if(in_array('new_client', $flags__))
                    $request['is_new'] = 1;
            }

            $request['customer_level'] = 2;
            $request['phone_validate'] = CustomersService::get_mobile_code();

            if($request['email']){
                if ($request['mobile_number']){
                    if( Customer::where([['client_number',$request['client_number'] ], ['mobile_number', $request['mobile_number']]])->first()){
                        return  Utils::set_log(0,'El número de celular ya ha sido registrado.',$code,$request);
                    }else{
                        $query = Customer::where([['email', $request['email']], ['mobile_number', $request['mobile_number']]])->first();
                        if($query === null ){
                            $query = Customer::Where('mobile_number',$request['mobile_number'])->first();
                            if ($query){
                                if($query->mobile_number && $query->client_number){
                                    return  Utils::set_log(0,'El número de celular ya ha sido registrado.',$code,$request);
                                }elseif ($query->mobile_number && (empty($query->client_number) || $query->client_number === null) ){
                                    //return  Utils::set_log(0,'El número de celular.',$code,$request);
                                    return self::storage_customer( $request, $collector, $query->id);
                                }elseif (empty($query->mobile_number) && empty($query->client_number)){
                                    return self::new_client( $request, $collector);
                                }
                            }else{
                                return self::new_client( $request, $collector);
                            }
                        }else{
                            if(empty($query->phone_validate) || $query->phone_validate === null || $query->phone_validate === 0){
                                if(empty($query->client_number) || $query->client_number == null){
                                    return self::storage_customer( $request, $collector, $query->id);
                                }else if($query->client_number === $request['client_number']){
                                    return Utils::set_log(0,'El número de cliente ya ha sido registrado previamente.',$code,$request);
                                }else{
                                    return Utils::set_log(0,'Correo o número móvil ya han sido registrados previamente.',$code,$request);
                                }
                            }else if($query->phone_validate == 1){
                                return Utils::set_log(0,'Correo o número móvil ya han sido registrados previamente.',$code,$request);
                            }else{
                                return Utils::set_log(0,'Correo o número móvil ya han sido registrados previamente.',$code,$request);
                            }
                        }
                    }

                }
            }else{
                if ($request['mobile_number'])
                    $query = Customer::where([['mobile_number', $request['mobile_number']]])->first();
                if($query === null ){
                    return self::new_client( $request, $collector);
                }else{
                    if(empty($query->phone_validate) || $query->phone_validate === null){
                        if(empty($query->client_number) || $query->client_number == null){
                            return self::storage_customer( $request, $collector, $query->id);
                        }else if($query->client_number === $request['client_number']){
                            return Utils::set_log(0,'El número de cliente ya ha sido registrado previamente.',$code,$request);
                        }else{
                            return Utils::set_log(0,'Correo o número móvil ya han sido registrados previamente.',$code,$request);
                        }
                    }elseif ($query->phone_validate == 1){
                        return Utils::set_log(0,'El número de celular ya ha sido registrado',$code,$request);
                    }else{
                        return Utils::set_log(0,'El número de celular ya ha sido registrado',$code,$request);
                    }
                }
            }



            //return [
              //  'status' => 1 ,
                //'msg'  => 'Tus datos han sido actualizados satisfactoriamente',
                //'customer'=>$registro
            //];
		}catch(\Exception $e){
			Utils::set_log(0,'Error de sistema: '.$e->getCode().' '.$e->getMessage(),null,$request);
			return ['status'=>0 , 'msg'=> 'Ocurrio un error verifique sus datos e intentelo de nuevo'];
		}

	}

    private function storage_customer ($input_data, Collector $collector, $customer_id){
        $customer = Customer::find($customer_id)
            ->update([
                'client_number'=>$input_data['client_number'],
                'name'=>$input_data['name'],
                'last_name'=>$input_data['last_name'],
                'second_last_name'=>$input_data['second_last_name'],
                'email'=>$input_data['email'],
                'mobile_number'=>$input_data['mobile_number'],
                'branch_id'=>$input_data['branch_id'],
                'phone_validate'=>$input_data['phone_validate'],
                'collector_id'=>$input_data['collector_id'],
                'source'=>$input_data['source'],
                'customer_level'=>$input_data['customer_level']
            ]);
        //if(env('APP_ENV') != 'local'){
            TwilioService::send_sms("Tu codigo de activación es: ".$input_data['phone_validate'],"+52".$input_data['mobile_number']);
            $this->send_email_erick($customer);
        //}

        $name   = $input_data['name'].' '.$input_data['last_name'].' '.$input_data['second_last_name'];

        $input_data['email'] ? $email = $input_data['email'] : $email = 'generic@hangar.com';
        $client_number = substr($input_data['client_number'], 2);
        self::save_visit($collector, $input_data, $customer_id);
        self::send_to_hangar($client_number, $name, $email, $input_data['mobile_number'], $input_data['branch_id']);
        return [
            'status' => 1 ,
            'msg'  => 'Datos Actualizados correctamente'
        ];
    }

    private function new_client ($input_data, Collector $collector){
        $customer = Customer::create($input_data);
        //if(env('APP_ENV') != 'local'){
            TwilioService::send_sms("Tu codigo de activación es: ".$input_data['phone_validate'],"+52".$input_data['mobile_number']);
            $this->send_email_erick($customer);
        //}
        $name   = $input_data['name'].' '.$input_data['last_name'].' '.$input_data['second_last_name'];
        $input_data['email'] ? $email = $input_data['email'] : $email = 'generic@hangar.com';
        $client_number = substr($input_data['client_number'], 2);
        self::save_visit($collector, $input_data, $customer->id);
        self::send_to_hangar($client_number, $name, $email, $input_data['mobile_number'], $input_data['branch_id']);
        return [
            'status' => 1 ,
            'msg'  => 'Datos Actualizados correctamente'
        ];
    }

    private  function save_visit($collector, $input_data, $customer_id){
        //Se guarda la visita

        $customer_collector = CustomerCollector::create([
            'customer_id'=>$customer_id,
            'collector_id'=>$collector->id,
            'source'=>$collector->source
        ]);
        //Se guardan las respuestas del formulario en caso de existir formulario
        $custom_inputs = $collector->custom_inputs;

        foreach($custom_inputs as $custom_input){
            if(key_exists($custom_input->id_field, $input_data)){
                $value = $input_data[$custom_input->id_field];
                //Formateando respuesta según el tipo de pregunta
                if($custom_input->type === 'checkbox'){
                    $value = implode(',',$input_data[$custom_input->id_field]);
                }
                //Generando array con datos para insertar
                $values_inputs = [
                    'customer_collector_id' => $customer_collector->id, //id de la visita
                    'custom_input_id'       => $custom_input->id, //id del input,
                    'value'                 => $value //valor de la pregunta
                ];
                CustomerCollectorDetail::create($values_inputs);
            }

        }
        return [
            'status' => 1 ,
            'msg'  => 'Tus datos han sido actualizados satisfactoriamente',
            //'customer'=>$registro
        ];
    }

    private  function send_to_hangar($client_number, $name, $email, $phone, $branch_id){
        $client = new Client();
        $branch = Branch::find($branch_id);
        $client->request('POST', 'http://system.quaxarcustomerhangar.com/campaigns/api/insertData', [
            'header' => [
                'Content-Type' => 'application/vnd.org.jfrog.artifactory.security.Group+json; charset=utf-8'
            ],
            'json' => [
                "values" =>[
                    'client_number' => $client_number,
                    'fullName'      => $name,
                    'phone'         => $phone,
                    'branch'        => $branch['name'],
                    'email'         => $email
                ],
                "eventID"           => 127,
                "APIClient"         => 'web form'
            ]
        ]);
        return [
            'status' => 1 ,
            'msg'  => 'Datos enviados correctamente al Hangar'
        ];
    }

    /*public function insert_lead(Request $request)
    {
        $return = [];
        $request = $request->input();
        try{
            $code = NULL;
           /* $request['client_number'] = '00'.$request['client_number'];
            $code = $request['client_number'];
            $client_number = DB::table('client_numbers')->where('client_number',$code)->first();

            if($client_number === null)
                return Utils::set_log(0,'El código ingresado no existe',null,$request);

            //validamos que se pase el parametro email y que  exista en la tabla
            if($request['email'])
                if(Customer::where('email',$request['email'])->first())
                    return Utils::set_log(0,'El email ya ha sido registrado',$code,$request);

            if( Customer::Where('mobile_number',$request['mobile_number'])->first())
                return  Utils::set_log(0,'El número de celular ya ha sido registrado',$code,$request);

            /*if(Customer::where('client_number',$request['client_number'])->first())
                return Utils::set_log(0,'Este código ya ha sido registrado',$code,$request);*/

            //Verificando flags
            /*if($client_number->flags != null){
                $flags__ = explode(',',$client_number->flags);
                if(in_array('new_client', $flags__))
                    $request['is_new'] = 1;
            }

            $request['customer_level'] = 1;
            //$request['phone_validate'] = CustomersService::get_mobile_code();
            $registro = Customer::create($request);
            /*if(env('APP_ENV') != 'local'){
                TwilioService::send_sms("Tu codigo de activación es: ".$registro->phone_validate,$registro->mobile_number);
                $this->send_email_erick($registro);
            }

            return [
                'status' => 1 ,
                'msg'  => 'Tus datos han sido actualizados satisfactoriamente',
                //'customer'=>$registro
            ];
        }catch(\Exception $e){
            Utils::set_log(0,'Error de sistema: '.$e->getCode().' '.$e->getMessage().' '.$e->getFile().' '.$e->getLine(),null,$request);
            return ['status'=>0 , 'msg'=> 'Ocurrio un error verifique sus datos e intentelo de nuevo'];
        }

    }*/

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

    public function ShowDatabase($type){
        //****Validar los totales de las bases de datos, para verificar que coincidad
        switch ($type){
            case 'historic':
                $title ='Base de datos inicial';
                $description = 'Estos registros corresponden a la base de datos inicial de su empresa.';
                break;
            case 'club-dar':
                $title ='Clubdar';
                $description = 'Estos son los clientes que se encuentrán registrados y aprobados para formar parte de clubdar';

                break;
            case 'leads':
                $title ='Leads';
                $description = 'Estos registros corresponden a personas que se han interesado en tus productos pero que aún no forman parte de clubdar';

                break;
            case 'clients':
                $title ='Base de clientes';
                $description = 'Se muestran los clientes que aún no están registrados en el programa clubdar';

                break;
            default:
                $title ='Base de datos General';
                $description = 'Aquí encontrarás la báse de datos completa de tus clientes, leads, etc.';
                break;
        }

        $data = [
            'title'=>$title,
            'description' =>$description,
            'type' => $type
        ];
        return view('ClientArea.Customer.ShowDatabase', compact('data'));
    }


}
