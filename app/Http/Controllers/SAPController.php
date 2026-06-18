<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SAPController extends Controller {
    public function GetSAPCustomerToSocioSyd(Request $request) {
        $client = new Client();

        $response = $client->post('https://apim.workato.com/produccion/socio-syd-v1/nuevo_cliente_test', [
            'headers' => [
                'Accept' => 'application/json',
                'API-Token' => '3175cdb77109deb85e221ed60ac5eb721af14d4657d287d294c790433157de38'
            ],
            'json' => [
                "cliente" => $request->cliente
            ]
        ]);

        $body = $response->getBody();

        return response()->json(json_decode($body, true));
    }

    public function SearchCustomerDataFromSAP(Request $request) {
        $client = new Client();

        $response = $client->get('https://apim.workato.com/produccion/wordpressb2b/sap_hana/v1/get_customer', [
            'headers' => [
                'Accept' => 'application/json',
                'API-Token' => '56dc66ec3834a8e4e53fd697e1a1ba3e0a6b72aa2bcd8e2143a3cbd1a2ca8232'
            ],
            'query' => [
                'I_KUNNR' => $request->client_number
            ]
        ]);

        $body = $response->getBody();

        return response()->json(json_decode($body, true));
    }
}
