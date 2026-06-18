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
                'API-Token' => '8ad58e3a35650e7292c82f4ec1072e51ebecbfe724847f875fe8df3395d57210'
            ],
            'query' => [
                'I_KUNNR' => $request->client_number
            ]
        ]);

        $body = $response->getBody()->getContents();
        dd($body);
        return response()->json(json_decode($body, true));
    }
}
