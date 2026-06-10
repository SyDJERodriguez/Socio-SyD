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
                'API-Token' => '56dc66ec3834a8e4e53fd697e1a1ba3e0a6b72aa2bcd8e2143a3cbd1a2ca8232'
            ],
            'json' => [
                "cliente" => $request->cliente
            ]
        ]);

        $body = $response->getBody();

        return response()->json(json_decode($body, true));
    }
}
