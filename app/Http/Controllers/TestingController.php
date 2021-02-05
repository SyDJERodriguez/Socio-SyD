<?php

namespace App\Http\Controllers;

use App\Collector;
use Illuminate\Http\Request;


class TestingController extends Controller
{
    public function test(Request $request){
       /* $input_values = $request->input();

        $collector = Collector::find($input_values['collector_id']);
        $custom_inputs = $collector->custom_inputs;
        foreach ($custom_inputs as $custom_input){
            echo 'Custom input: '.$custom_input->id_field;
            //Buscando campo en los input fields
            if(key_exists($custom_input->id_field, $input_values)){

                $value = $input_values[$custom_input->id_field];
                //Formateando respuesta según el tipo de pregunta
                if($custom_input->type === 'checkbox'){
                    $value = implode(',',$input_values[$custom_input->id_field]);
                }
                //Generando array con datos para insertar
                $values_inputs = [
                    'customer_collector_id' => '', //id de la visita
                    'custom_input_id'       => $custom_input->id, //id del input,
                    'value'                 => $value //valor de la pregunta
                ];

                echo '<br>'.json_encode($values_inputs);
            }
            echo '<hr>';
        }
        echo json_encode($input_values);*/
       /* if(count($custom_inputs) > 0){
            return $custom_inputs;
        }else{
            echo 'Noi hay';
        }*/

        $link_nino =\Storage::cloud()->temporaryUrl(
            'COLORING_BOOK_DIGITAL_V2_NInA.pdf',
            now()->addMinute(2)
        );

        $link_nina =\Storage::cloud()->temporaryUrl(
            'COLORING_BOOK_DIGITAL_V2_NInA.pdf',
            now()->addMinute(2)
        );

        echo $link_nina.'<hr>';
        echo $link_nino. '<hr>';

    }
}
