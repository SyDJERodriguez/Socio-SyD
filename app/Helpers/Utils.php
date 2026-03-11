<?php


namespace App\Helpers;


use App\LogRegisters;
use DB;
use Jenssegers\Agent\Agent;

class Utils
{
    public static function random_id($prev) {
        return 100000 + (($prev-100000)*97 + 356563) % 896723;
    }

    public static function getUserIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public static function set_log($status,$msg,$client_number,$request){
        $agent = new Agent();
        $log = array(
            'client_number'=>$client_number,
            'ip'=>Utils::getUserIpAddr(),
            'device'=>$agent->platform().' - '.$agent->browser(),
            'form_data'=>json_encode($request),
            'status'=>$status,
            'msg'=>$msg
        );

        LogRegisters::create($log);

        return [
            'status' => $status ,
            'msg'  => $msg
        ];


    }

    public static function set_transaction_log($status, $error_msg, $request){
       $agent = new Agent();
       $log = array(
           'client_number'    => '00'.$request['client_number'],
           'tmat'             => $request['tmat'],
           'quantity'         => $request['quantity'],
           'amount'           => $request['amount'],
           'sale_office'      => $request['sale_office'],
           'transaction_date' => $request['transaction_date'],
           'payment_method'   => $request['pay_method'],
           'error_Message'    => $error_msg,
           'ip'               => Utils::getUserIpAddr(),
           'device'           => $agent->platform().' - '.$agent->browser(),
           'status'           => $status
       );

       DB::table('transactions_log')->insert($log);
    }
}
