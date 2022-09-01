<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Helpers\Utils;
use Validator;
use App\Repositories\TransactionRepository;

class TransactionsController extends Controller
{
    public function insert_transaction(Request $request){
        \Log::channel('api')->info('============ START PROCESS INSERT TRANSACTION ============');
        $agent = new Agent();
        \Log::channel('api')->info('Solicitud a insert in log: ip->'.Utils::getUserIpAddr().' device->'.$agent->platform().' - '.$agent->browser());
        $return = array('status'=>0, 'msg'=>'Error desconocido');
        $request = $request->input();
        \Log::channel('api')->info('Procesando datos: '.json_encode($request));
        $registers_received = 0;
        $registers_saved = 0;
        $registers_unsaved = 0;

        try{
            foreach ($request['data'] as $transaction){
                ++$registers_received;
                // $client_number = explode("-",$transaction['client_number']);
                //$transaction->branch = $client_number[1];
                $validator = $this->validator($transaction);
                if($validator->fails()){
                    ++$registers_unsaved;
                    Utils::set_transaction_log(400, $validator->errors(), $transaction);
                }else{
                    $query = TransactionRepository::save_transaction($transaction);
                    if($query['code'] === 1) ++$registers_saved;
                    if($query['code'] === 0) ++$registers_unsaved;
                }
            }


            //if($query['code'] === 1){
            $return['status'] = 200;
            $return['msg'] = 'Las transacciones han sido procesadas';
            \Log::channel('api')->info('Prcesamiento de datos finalizado');
            \Log::channel('api')->info('Registros recibidos: '.$registers_received);
            \Log::channel('api')->info('Registros guardados: '.$registers_saved);
            \Log::channel('api')->info('Registros no guardados: '.$registers_unsaved);
            \Log::channel('api')->info('============ END PROCESS INSERT TRANSACTION ============');
            return response()->json($return, 200);
            /*}elseif ($query['code'] === 0){
                \Log::channel('api')->info("Ocurrio un error al procesar la petición".$query['msg']);
                $return['status'] = 400;
                $return['msg']    = 'Ocurrió un erro al guardar el registro: '.$query['msg'];
                \Log::channel('api')->info('============ END PROCESS INSERT TRANSACTION ============');
                Utils::set_transaction_log($return['status'], $return['msg'], $request['data']);
                return response()->json($return, 400);
            }*/
        }catch (\Exception $e){
            \Log::channel('api')->info("Ocurrio un error al procesar la petición: ".$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine());
            $return['status'] = 400;
            $return['msg']    = 'Ocurrió un erro al guardar el registro';
            \Log::channel('api')->info('============ END PROCESS INSERT TRANSACTION ============');
            return response()->json($return, 400);
        }
    }

    private function validator(array $data){
        return Validator::make($data, [
            'client_number'     => 'required|digits:8',
            'invoce'            => 'required',
            'amount'            => 'required',
            'branch'            => 'required',
            'transaction_date'  => 'required',
            'pay_method'        => 'required'
        ],[
            'client_number.required'    => 'El número de cliente es obligatorio',
            'client_number.digits'      => 'El número de cliente debe ser de 8 digitos',
            'invoce.required'           => 'La factura es obligatorio',
            'amount.required'           => 'El importe total es obligatorio',
            'branch.required'           => 'La sucursal es obligatorio',
            'transaction_date.required' => 'La fecha de transacción es requerida',
            'pay_method.required'       => 'El tipo de vía de pago es requerido'
        ]);
    }
}
