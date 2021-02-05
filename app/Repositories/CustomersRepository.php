<?php


namespace App\Repositories;
use App\Customer;
use App\Branch;
use App\Collector;
use App\CustomerCollector;
use App\CustomerCollectorDetail;
use GuzzleHttp\Client;
use Carbon\Carbon;
use DB;
use function Matrix\subtract;

class CustomersRepository
{
    public static function get_clients_today(){
        try {
            $data = "";
            $count = 0;
            $query = DB::table('customers')->whereDate('updated_at',Carbon::yesterday())->get();
            //$query = DB::table('customers')->whereDate('updated_at','<=',Carbon::yesterday())->get();
            foreach ($query as $row){
                if($row->client_number != null || $row->client_number != ''){
                    $verify = DB::table('clients_updated_sent')
                        ->where('client_number', '=', $row->client_number)
                        ->first();
                    if($verify === null){
                        $new_register_sent = DB::table('clients_updated_sent')->insert(['client_number'=>$row->client_number, 'updated_date'=>$row->updated_at]);
                    }
                    ++$count;
                    $client_number = substr($row->client_number, 2, 8);
                    $date = substr($row->updated_at, 0, 10);
                    $obj = $client_number."|".$date;
                    $data = $data.$obj.",";
                }
            }

            $registers = [
                'data'=>$data,
                'registers_sent'=>$count
            ];

            return $registers;
        } catch (\Exception $e) {
            return  ['code'=>0, 'msg'=>$e->getMessage()];
        }
    }

    public static function get_specific_clients($date){
        try {
            $data = "";
            $count = 0;
            $query = DB::table('customers')->whereDate('updated_at',$date)
                ->whereNotNull('client_number')
                ->get();
            //$query = DB::table('customers')->whereDate('updated_at','<=',Carbon::yesterday())->get();
            foreach ($query as $row){
                if($row->client_number != null || $row->client_number != ''){
                    $verify = DB::table('clients_updated_sent')
                        ->where('client_number', '=', $row->client_number)
                        ->first();

                    if($verify === null){
                        $new_register_sent = DB::table('clients_updated_sent')->insert(['client_number'=>$row->client_number, 'updated_date'=>$row->updated_at]);
                    }

                    ++$count;
                    $client_number = substr($row->client_number, 2, 8);
                    $date = substr($row->updated_at, 0, 10);
                    $obj = $client_number."|".$date;
                    $data = $data.$obj.",";
                }
            }
            $registers = [
                'data'=>$data,
                'registers_sent'=>$count
            ];
            return $registers;
        } catch (\Exception $e) {
            return  ['code'=>0, 'msg'=>$e->getMessage()];
        }
    }

    public static function get_client_by_email($client_number, $email){
        try{
            $client_number = '00'.$client_number;
            $query = DB::table('customers')
                ->where('client_number', '=', $client_number)
                ->first();

            $benefits = self::get_benefits($client_number);

            if ($query){
                if($query->email === $email){
                    $branch = DB::table('branches')
                        ->select('branches.name')
                        ->where('id','=',$query->branch_id)
                        ->first();
                    $values = [
                        'numero_cliente'   => substr($query->client_number, 2, 8),
                        'nombre'           => $query->name,
                        'apellido_paterno' => $query->last_name,
                        'apellido_materno' => $query->second_last_name,
                        'email'            => $email,
                        'telefono'         => $query ->mobile_number,
                        'sucursal'         => $branch->name,
                        'benefits'         => $benefits
                    ];

                    return ['status'=>'200','message'=>'Los datos proporcionados se encuentran en la base de datos.', 'data'=>$values];
                }else{
                    $branch = DB::table('branches')
                        ->select('branches.name')
                        ->where('id','=',$query->branch_id)
                        ->first();

                    $values = [
                        'numero_cliente'   => substr($query->client_number, 2, 8),
                        'nombre'           => $query->name,
                        'apellido_paterno' => $query->last_name,
                        'apellido_materno' => $query->second_last_name,
                        'email'            => $query->email,
                        'telefono'         => $query ->mobile_number,
                        'sucursal'         => $branch->name,
                        'benefits'         => $benefits
                    ];
                    return ['status'=>'404','message'=>'El email proporcionado no corresponde al número de cliente.', 'data'=>$values];
                }
            }else{
                return ['status'=>'404','message'=>'El número de cliente no se encuentra en la base de datos.'];
            }
        }catch (\Exception $e){
            return ['code' => 0, 'msg'=>$e->getMessage()];
        }
    }

    public static function get_client_by_mobile($client_number, $mobile_number){
        try{
            $client_number = '00'.$client_number;
            $query = DB::table('customers')
                ->where('client_number', '=', $client_number)
                ->first();

            $benefits = self::get_benefits($client_number);
            if ($query){
                if($query->mobile_number === $mobile_number){
                    $branch = DB::table('branches')
                        ->select('branches.name')
                        ->where('id','=',$query->branch_id)
                        ->first();

                    $values = [
                        'numero_cliente'   => substr($query->client_number, 2, 8),
                        'nombre'           => $query->name,
                        'apellido_paterno' => $query->last_name,
                        'apellido_materno' => $query->second_last_name,
                        'email'            => $query->email,
                        'telefono'         => $mobile_number,
                        'sucursal'         => $branch->name,
                        'benefits'         => $benefits
                    ];
                    return ['status'=>'200','message'=>'Los datos proporcionados se encuentran en la base de datos.', 'data'=>$values];
                }else{
                    //$client_number = substr($query->client_number, 2, 8);
                    $branch = DB::table('branches')
                        ->select('branches.name')
                        ->where('id','=',$query->branch_id)
                        ->first();

                    $values = [
                        'numero_cliente'   => substr($query->client_number, 2, 8),
                        'nombre'           => $query->name,
                        'apellido_paterno' => $query->last_name,
                        'apellido_materno' => $query->second_last_name,
                        'email'            => $query->email,
                        'telefono'         => $query->mobile_number,
                        'sucursal'         => $branch->name,
                        'benefits'         => $benefits
                    ];
                    return ['status'=>'404','message'=>'El número telefónico proporcionado no corresponde al número de cliente.', 'data'=>$values];
                }
            }else{
                return ['status'=>'404','message'=>'El número de cliente no se encuentra en la base de datos.'];
            }
        }catch (\Exception $e){
            return ['code' => 0, 'msg'=>$e->getMessage()];
        }
    }

    public static function get_benefits ($client_number){
        $seguro     = false;
        $asistencia = false;
        $cashback   = false;

        $now = Carbon::now();
        $last_month = $now->month-1;
        //dd($now->month-1);
        $data_customer = DB::table('transactions')
            ->where('client_number', $client_number)
            ->whereMonth('transaction_date','=',$last_month)
            ->get();

        $total_amount_customer = 0.0;
        foreach ($data_customer as $data){
            $amount_customer = floatval($data->amount);
            strpos($data->amount, '-') ? $total_amount_customer -= $amount_customer : $total_amount_customer += $amount_customer ;
        }

        if($total_amount_customer >= 200){
            $seguro = true;
        }
        if ($total_amount_customer >= 500){
            $asistencia = true;
        }
        if($total_amount_customer >= 1700){
            $cashback   = true;
        }

        $benefits = [
            'insurance'  => $seguro,
            'assistance' => $asistencia,
            'cashback'   => $cashback
        ];

        return $benefits;
    }
}
