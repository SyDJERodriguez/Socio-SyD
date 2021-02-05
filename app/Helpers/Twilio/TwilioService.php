<?php


namespace App\Helpers\Twilio;
use Twilio\Rest\Client;
use App\Helpers\Utils;

class TwilioService
{
    private static function client(){
        $sid    = 'ACb49024e3aa94e9ebe208dd541f0b6dca';
        $token  = '0d376fed04e33d06878d01c4e9d75bc0';
        $client = new Client( $sid, $token );
        return $client;
    }
    public static function send_sms($text, $phone){
        try{
            $client = self::client();
            $twl = $client->messages->create(
                $phone,
                ['from' => '+17864813232', 'body' => $text ]
            );
            //Utils::set_log(200,'Se envió el SMS',00000001,$twl);
            return true;
        }catch(\Exception $e){
            //Utils::set_log(400,$e,00000001,$e);
            return false;
        }
    }
}
