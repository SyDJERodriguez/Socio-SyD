<?php


namespace App\Http\Controllers\Api;


use App\Collector;
use App\Customer;
use App\CustomerCollector;
use App\CustomerCollectorDetail;
use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CollectorCustomerController extends Controller
{
    public function store(Request $request){
        try {
            $code = NULL;
            $collector = Collector::find($request->collector_id);

            if($request['email']) {
                $customer = Customer::where('email',$request['email'])->first();
                if($customer){
                    return Utils::set_log(0,'El email ya ha sido registrado ',$code,$request);
                    //return $this->update_customer($customer, $request->input(), $collector);
                }
            }
            if($request['mobile_number']){
                $customer = Customer::Where('mobile_number',$request['mobile_number'])->first();
                if($customer){
                     return Utils::set_log(0,'El número de celular ya ha sido registrado',$code,$request);
                    // return $this->update_customer($customer, $request->input(), $collector);
                }
            }
            return self::storage_customer( $request->input(), $collector);
        }catch(\Exception $e){
            Utils::set_log(0,'Error de sistema: '.$e->getCode().' '.$e->getMessage(),null,$request);
            return [
                'status'=>0 ,
                'msg'=> 'Ocurrio un error verifique sus datos e intentelo de nuevo',
                'error' => $e->getFile().' -> '.$e->getMessage()
            ];
        }

    }

    private function update_customer(Customer $customer, $input_data, Collector $collector){
        $update_data = [];
        //Iteramos los parametros y los comparamos con los valores actuales del registro
        foreach ($input_data as $key => $value){
            $valor_actual = (isset($customer[$key]))?$customer[$key]:null;
            //echo '<br> KEY: '.$key.' Actual: '.$valor_actual.'  ->  Nuevo: '.$value;
            if($value){
                if($valor_actual != $value){
                    $update_data[$key] = $value;
                    //echo '<br> Se actualiza <br>';
                }
            }
            //echo '<hr>';
        }
        $customer->fill($update_data);
        $customer->update();
        return self::save_visit($customer, $collector, $input_data);
    }

    private function storage_customer ($input_data, Collector $collector){
        $input_data['collector_id'] = $collector->id;
        if($input_data['interest']){
            $input_data['interest'] = serialize($input_data['interest']);
        }

        $customer = Customer::create($input_data);
        $name   = $input_data['name'].' '.$input_data['last_name'].' '.$input_data['second_last_name'];
        $input_data['email'] ? $email = $input_data['email'] : $email = 'generic@hangar.com';
         self::save_visit($customer, $collector, $input_data);
         if ($input_data['collector_id'] === 3){
             self::send_to_hangar($name, $email, $input_data['mobile_number'], $input_data['str_branch']);
         }elseif ($input_data['collector_id'] === 2){
             self::send_hangar_lines($name, $email, $input_data['mobile_number']);
         }
        return [
            'status' => 1 ,
            'msg'  => 'Datos Actualizados correctamente'
        ];
    }

    private  function save_visit($customer, $collector, $input_data){
        //Se guarda la visita

        $customer_collector = CustomerCollector::create([
            'customer_id'=>$customer->id,
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

    private  function send_to_hangar($name, $email, $phone, $branch){
        $client = new Client();
        $client->request('POST', 'http://system.quaxarcustomerhangar.com/campaigns/api/insertData', [
            'header' => [
                'Content-Type' => 'application/vnd.org.jfrog.artifactory.security.Group+json; charset=utf-8'
            ],
            'json' => [
                "values" =>[
                    'fullName'      => $name,
                    'phone'         => $phone,
                    'sucursal'      => $branch,
                    'email'         => $email
                ],
                "eventID"           => 141,
                "APIClient"         => 'web form'
            ]
        ]);
        return [
            'status' => 1 ,
            'msg'  => 'Datos enviados correctamente al Hangar'
        ];
    }

    private  function send_hangar_lines($name, $email, $phone){
        $client = new Client();
        $client->request('POST', 'http://system.quaxarcustomerhangar.com/campaigns/api/insertData', [
            'header' => [
                'Content-Type' => 'application/vnd.org.jfrog.artifactory.security.Group+json; charset=utf-8'
            ],
            'json' => [
                "values" =>[
                    'fullName'      => $name,
                    'phone'         => $phone,
                    'email'         => $email
                ],
                "eventID"           => 231,
                "APIClient"         => 'web form'
            ]
        ]);
        return [
            'status' => 1 ,
            'msg'  => 'Datos enviados correctamente al Hangar'
        ];
    }
}
