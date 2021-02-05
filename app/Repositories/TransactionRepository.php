<?php


namespace App\Repositories;


use DB;
use App\Helpers\Utils;

class TransactionRepository
{
    //Function for insert transaction in "Transactions" table of Database
    public static function save_transaction(array $transaction){
        try {
            $data = array(
                'client_number'    => '00'.$transaction['client_number'],
                'tmat'             => $transaction['tmat'],
                'quantity'         => $transaction['quantity'],
                'amount'           => $transaction['amount'],
                'sale_office'      => $transaction['sale_office'],
                'transaction_date' => $transaction['transaction_date'],
                'payment_method'   => $transaction['pay_method']
            );

            if (DB::table('client_numbers')->where('client_number','00'.$transaction['client_number'])->first()){
                //Query for insert data in Database
                DB::table('transactions')->insert($data);
            }else{
                Utils::set_transaction_log(400, 'El número de cliente no se encuentra en la base de datos', $transaction);
                return  ['code'=>0, 'msg'=>'El número de cliente no se encuentra en la base de datos'];
            }

            return  ['code'=>1, 'msg'=>'Guardado']; //guardado correctamente
        } catch (\Exception $e) {
            return  ['code'=>0, 'msg'=>$e->getMessage()];
        }
    }
}
