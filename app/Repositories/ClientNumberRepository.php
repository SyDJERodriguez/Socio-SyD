<?php


namespace App\Repositories;


use DB;

class ClientNumberRepository
{
    public static function save_client_number(array $client){
        //$client_number_exist = (bool)DB::table('client_numbers_temp')->where('client_number', $client)->first();
        //if (!$client_number_exist) {
            try {
                DB::table('client_numbers')->insert($client);
               return  ['code'=>1, 'msg'=>'Guardado']; //guardado correctamente
                //Moviendo archivo a otra carpeta
            } catch (\Exception $e) {
               return  ['code'=>0, 'msg'=>$e->getMessage()];
            }
        /*} else {
            return  ['code'=>2, 'msg'=>'Ya existe']; //existe
        }*/
    }
}
