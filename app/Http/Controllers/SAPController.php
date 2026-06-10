<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SAPController extends Controller {
    public function GetSAPCustomerToSocioSyd(Request $request) {
        $client = new Client();

        $response = $client->post('https://apim.workato.com/workatoqas/socio-syd-v1/envio-clientes-socio-syd', [
            'headers' => [
                'Accept' => 'application/json',
                'API-Token' => 'dfcec78dee5331c17c68dc4df95583bcb22adc1b884290233fb3b57f72488349'
            ],
            'json' => [
                "cliente" => $request->cliente
            ]
        ]);

        $body = $response->getBody();

        return response()->json(json_decode($body, true));
    }
}
