<?php

/**
 *  Controlador para crear las distintas vistas de recolección de datos
 */

namespace App\Http\Controllers;

use App\Branch;
use App\City;
use App\Customer;
use App\CustomerStage;
use App\State;
use Illuminate\Http\Request;
use DB;

class CollectorController extends Controller
{

    public function index(){
        return view('Collectors.index');
    } 

    public function stage_one(){
    	$branchs = Branch::all();
    	$branchs = $branchs->sortBy('name');
    	return view('Collectors.Stage_one',['branchs'=>$branchs]);
    }

    public function edit_customer(){
        return view('Collectors.update_customer_data');
    }

    public function update_customer(Request $request){
        $request = $request->input();
        $client_number = '00'.$request['client_number'];
        /*$check_data = DB::table('customers')->where('client_number', '=', $client_number)->select('gender');
        if (!empty($check_data) || $check_data !== null || $check_data !== ''){
            return [
                'status' => 2,
                'msg'    => 'Los datos ya han sido actualizados previamente.'
            ];
        }*/

        $query = DB::table('customers')->where('client_number', '=', $client_number)->update([
            'gender'  => $request['gender'],
            'birthday' => $request['birthday']
        ]);

        if ($query) {
            return [
                'status' => 1,
                'msg'    => 'Datos registrados correctamente.'
            ];
        }else{
            return [
                'status' => 0,
                'msg'    => 'Verifique sus datos e intente de nuevo.'
            ];
        }

    }

    public function branches_page(){
        $branches = Branch::all();
        $branches = $branches->sortBy('name');
        return view('Collectors.branches_page',['branches'=>$branches]);
    }

    public function stage_two(){
        return view('Collectors.Stage_two');
    }

    //DAR's thanks page
    public function thanks_page(){
        $link_nino =\Storage::cloud()->temporaryUrl(
            'COLORING_BOOK_DIGITAL_V2_NInO.pdf',
            now()->addMinute(2)
        );

        $link_nina =\Storage::cloud()->temporaryUrl(
            'COLORING_BOOK_DIGITAL_V2_NInA.pdf',
            now()->addMinute(2)
        );

        $link_mama =\Storage::cloud()->temporaryUrl(
            'COLORING_BOOK_MAMA.pdf',
            now()->addMinute(2)
        );

        $link_papa = \Storage::cloud()->temporaryUrl('COLORING_BOOK_DIA_PADRE_DAR.pdf', now()->addMinute(2));
        $link_papa_classic = \Storage::cloud()->temporaryUrl('COLORING_BOOK_DIA_PADRE_DAR_CLASICOS.pdf', now()->addMinute(2));
        $link_todo_terreno = \Storage::cloud()->temporaryUrl('COLORINGBOOK_CANAM_V2.pdf', now()->addMinute(2));

        return view('Collectors.thanks', compact('link_todo_terreno'));
    }

    public function stage_two_edit(Request $request){

        $request = $request->input();
       $customer = Customer::where('client_number','00'.$request['client_number'])->where('mobile_number',$request['mobile_number'])->first();
        if(!$customer)
            return redirect()->back()->with('error','No existe ningún registro con estos datos');

        //Valida si el usuario ya actualizo sus datos
        if(CustomerStage::where('customer_id', $customer->id)->where('stage',2)->first())
            return redirect()->back()->with('error','Sus datos ya han sido actualizados');

        $states = State::all();
        return view('Collectors.Stage_two_edit', compact('customer','states'));
    }

    public function stage_two_thanks(){
        return view('Collectors.Stage_two_thanks');
    }

    public function register_lead(){
        $branchs = Branch::all();
        $branchs = $branchs->sortBy('name');
        return view('Collectors.register_lead', ['branchs'=>$branchs]);
    }

    public function landing_lineas(){
        return view('Landings.lineas_registers');
    }

    //SYD's thanks page
    public function landing_lineas_gracias(){
        
        $link_nino =\Storage::cloud()->temporaryUrl(
            'COLORING_BOOK_DIGITAL_V2_NInO.pdf',
            now()->addMinute(2)
        );

        $link_nina =\Storage::cloud()->temporaryUrl(
            'COLORING_BOOK_DIGITAL_V2_NInA.pdf',
            now()->addMinute(2)
        );

        $link_mama =\Storage::cloud()->temporaryUrl(
            'COLORING_BOOK_MAMA.pdf',
            now()->addMinute(2)
        );

        $link_papa = \Storage::cloud()->temporaryUrl(
            'COLORING_BOOK_DIA_PADRE_SYD.pdf', now()->addMinute(2)
        );

        $link_papa_classic = \Storage::cloud()->temporaryUrl(
            'COLORING_BOOK_DIA_PADRE_SYD_CLASICOS.pdf', now()->addMinute(2)
        );

        return view('Landings.lineas_thanks');
    }


    public function api_cities_by_state(Request $request){
        $state = $request->input('state_id');
        $cities = City::where('state_id',$state)->get(['name','id']);

        return response()->json($cities);
    }

    public function notice_privacy(){
        return view('Collectors.notice_privacy');
    }

}
//10000578
//9211165413


