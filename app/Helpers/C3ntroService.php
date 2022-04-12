<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Http;
// use App\Http\Controllers;

use GuzzleHttp\Client;


class C3ntroService
{
    
    
    public static function sendSMS($text, $phone){

      
    
        $client = new Client();
        $user = 'Socios.Plan';
        $pass = 'Sociosyd2022';
        $res = $client->request('GET', 'https://apisms.c3ntro.com:8282/?username='.$user.'&password='.$pass.'&number='.$phone.'&message='.$text);

        // dd($res);
            // echo $res->getBody();
        // echo $contents = $res->getBody()->getContents();

        return true;
        
    }

}
