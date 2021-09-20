<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\CustomerPlatform;
use Auth;
use DB;
use PDF;
use Carbon\Carbon;

class BeneficiaryController extends Controller
{
    public function add_beneficiaries (Request $request) {
        $data = DB::table('customer_platforms')->where('email', Auth::user()->email)->first();
        $data->branch_number = Auth::user()->branch_number;
        $number = '';
        if (Auth::user()->client_type === "3"){
            $data = DB::table('customer_platforms')->where('email', Auth::user()->email)->first();
            $data->branch_number = Auth::user()->branch_number;
            $number = DB::table('associates')
                ->select('number')
                ->where('email', Auth::user()->email)
                ->first();
        }

        $request = $request->input();
        //dd($request['name'][1]);
        $count = 0;
        $total_percent = 0;

        $signature = DB::table('customers_sessions')
            ->select('signature_id')
            ->where('id', '=', Auth::user()->id)
            ->first();
        $signature = $signature->signature_id;

        //$now = Carbon::now();
        //$current_month = $now->month;

        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        //$data_session = CustomersSession::where('email', Auth::user()->email)->first();
        $data_customer = $this->getTransCadena(Auth::user()->email);
        $total_amount = 0.0;
        foreach ($data_customer as $d){
            //if( date_format(date_create($d->transaction_date)->modify('+2 day'), 'Y-m-d') < date($now->isoformat("Y-MM-D")) ){
                $amount_customer = floatval($d->amount);
                strpos($d->amount, '-') ? $total_amount -= $amount_customer : $total_amount += $amount_customer ;
            //}
        }

        $cnt = intval(Auth::user()->client_number);
        $is_cnt = 'false';
        if( ($cnt > 90000000) && ($cnt < 90020000)) {
            $is_cnt = 'true';
        }

        $noti = $this->getNotifications();
        $total = $total_amount;

        $level = 0;
        if (Auth::user()->client_type === "1" || Auth::user()->client_type === "4"){
            if ($total_amount>2500 && $total_amount<=4500) {
                $level = 1;
            }
            if ($total_amount>4500 && $total_amount<=7000) {
                $level = 2;
            }
            if ($total_amount>7000) {
                $level = 3;
            }
        }

        if (Auth::user()->client_type === "2" || Auth::user()->client_type === "3"){
            if ($total_amount>200 && $total_amount<=500) {
                $level = 1;
            }
            if ($total_amount>500 && $total_amount<=1300) {
                $level = 2;
            }
            if ($total_amount>1300) {
                $level = 3;
            }
        }

        $valid = false;
        foreach ($request['phone'] as $mobile) {
            $valid = $this->phoneValidator($mobile);

            if ($valid === false){
                $error = 'Un número de teléfono ingresado no es válido';
    
                return view('pages.Account.beneficiary', compact(
                    'error', 'data', 'request', 'level','is_cnt', 
                    'signature', 'noti', 'total', 'number','owner'));
            }
        }

        foreach ($request['percent'] as $percent){
            $count++;
            //Sum the all percent
            $total_percent += intval($percent);
        }

        //Verify if is one o two registers
        if ($count == 2){
            if ($total_percent !== 100){
                //Here the response if total percent of beneficiaries is not 100
                $error = 'El porcentaje total debe ser de 100%';

                return view('pages.Account.beneficiary', compact(
                    'error', 'data', 'request', 'level','is_cnt', 
                    'signature', 'noti', 'total', 'number','owner'));
                //dd($total_percent);
            }

            try{
                //Here insert each register of the form
                for ($i = 0; $i<=1; $i++){

                    if (isset($request['name'][$i])){
                        if ($request['name'][$i] !== null){
                            $insert = DB::table('beneficiaries')->insert([
                                'name'             => $request['name'][$i],
                                'last_name'        => $request['lastname'][$i],
                                'second_last_name' => $request['second_lastname'][$i],
                                'relationship'     => $request['parent'][$i],
                                'mobile_number'    => $request['phone'][$i],
                                'percent'          => $request['percent'][$i],
                                'customer_id'      => $data->id,
                                'branch_number'    => $request['branch_number'][$i]
                            ]);
                        }
                    }
                }

                //$generatePDF = $this->generatePDF();
                //if ($generatePDF === 'success') {
                    $success = 'Los beneficiarios han sido agregados correctamente.';
                    $beneficiaries = DB::table('beneficiaries')
                                        ->where('customer_id','=', $data->id)
                                        ->get();
                        $beneficiaries = json_decode($beneficiaries);
                        $beneficiary = (array)$beneficiaries;//convert to array
                     //send email if individual account added a beneficiary
                     if(Auth::user()->client_type === "2"){
                        $this->send_email_alta($data->email);
                    }
                    return view('pages.Account.beneficiary', compact(
                        'success', 'data', 'beneficiary', 'level','is_cnt', 
                        'signature', 'noti', 'total', 'number','owner'));
                //}

            }catch(\Exception $e){
                $error = $e;
                return view('pages.Account.beneficiary', compact(
                    'error', 'data', 'request', 'noti','level', 
                    'total','owner','total','number','is_cnt'));
            }

        }elseif ($count == 1){
            if (intval($request['percent'][0]) !== 100){
                //Here the response if total percent of beneficiaries is not 100
                $error = 'El porcentaje total debe ser de 100%';
                return view('pages.Account.beneficiary', compact(
                    'error', 'data', 'request', 'level', 
                    'signature', 'noti', 'total', 'number',
                    'owner','is_cnt'));
            }
            $insertBeneficiary = DB::table('beneficiaries')->insert([
                'name'             => $request['name'][0],
                'last_name'        => $request['lastname'][0],
                'second_last_name' => $request['second_lastname'][0],
                'relationship'     => $request['parent'][0],
                'mobile_number'    => $request['phone'][0],
                'percent'          => $request['percent'][0],
                'customer_id'      => $data->id,
                'branch_number'    => $request['branch_number'][0]
            ]);

            //$generatePDF = $this->generatePDF();

            //if ($generatePDF === 'success'){
                $success = 'El beneficiario ha sido agregado correctamente.';
                $beneficiaries = DB::table('beneficiaries')
                                ->where('customer_id','=', $data->id)
                                ->get();
                    $beneficiaries = json_decode($beneficiaries);
                    $beneficiary = (array)$beneficiaries;//convert to array
                    //send email if individual account added a beneficiary
                    if(Auth::user()->client_type === "2"){
                        $this->send_email_alta($data->email);
                    }
                return view('pages.Account.beneficiary', compact('success', 'data', 'beneficiary', 'level', 'signature', 'noti', 'total', 'number','owner','is_cnt'));
           // }
        }
    }

    //get transactions by branch_number or client_number
    public function getTransCadena($email){
        $dataSession = DB::table('customers_sessions')
                        ->where('email','=', $email)->first(); 
        $now = Carbon::now();
        $current_month = $now->month;

        $trans1 = DB::table('transactions')
            ->join('material_type', 'transactions.tmat', '=', 'material_type.code')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $dataSession->client_number)
            ->where('transactions.branch_number','=', $dataSession->branch_number)
            ->where('amount', '>', 0)
            ->whereMonth('transaction_date', $now->month)
            ->get();

        $trans2 = DB::table('transactions')
            ->join('material_type', 'transactions.tmat', '=', 'material_type.code')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $dataSession->client_number)
            ->where('transactions.branch_number','=', $dataSession->branch_number)
            ->where('amount', '<', 0)
            ->whereMonth('transaction_date', $now->subMonth(1)->month)
            ->get();

        $data = $trans1->merge($trans2);
        return $data;
        
    }

    //validated a valid phone number
    public function phoneValidator($mobile){
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $numberProtocol = $phoneUtil->parse($mobile,"MX");

            $isValidRegion= $phoneUtil->isValidNumberForRegion($numberProtocol,"MX");
            $isValidNum = $phoneUtil->isValidNumber($numberProtocol);
            $isPossibleNum = $phoneUtil->isPossibleNumber($numberProtocol);

            if(substr($mobile,0,3) === "888"){ //validate number china
                return false;
            }

            if($isValidNum === true && $isValidRegion === true && $isPossibleNum === true){
                return true;
            }else{
                return false;
            }
        } catch (\libphonenumber\NumberParseException $e) {
            throw $e;
        }
        return false;
    }

    //Function to generate PDF and upload AWS's S3
    public function generatePDF() {
        $id = Auth::user()->id;
        $customer = DB::table('customer_platforms')
            ->where('email', '=', Auth::user()->email)
            ->first();
        $beneficiaries = DB::table('beneficiaries')
            ->where('customer_id', '=', $customer->id)
            ->get();

        $signature = DB::table('signatures')
            ->where('customer_id', '=', Auth::user()->id)
            ->first();

        if (Auth::user()->client_type === "3"){
            $customer = DB::table('customer_platforms')
                ->where('email', '=', Auth::user()->email)
                ->first();
            $beneficiaries = DB::table('beneficiaries')
                ->where('customer_id', '=', $customer->id)
                ->get();

            $signature = DB::table('signatures')
                ->where('customer_id', '=', $id)
                ->first();
        }

        $initDate = new Carbon('first day of next month');

        $finDate = new Carbon('last day of next month');

        $currentDate = Carbon::parse()->locale('es');
       // $currentDate->diffForHumans();

        return PDF::loadView('layouts.Policies.safePolicy', [
            'beneficiary'=>$beneficiaries,
            'signature'=>$signature,
            'customer'=>$customer,
            'initDate'=>$initDate,
            'finDate'=>$finDate,
            'currentDate' => $currentDate
        ])->stream($customer->id.'.pdf');
        //$upload = \Storage::cloud()->put('polizas/'.$id.'.pdf', $pdf->output(), 'public');
        //if($upload){
        //    return 'success';
        //}

        //return 'failed';
    }

    //get the data from notifications table
    public function getNotifications(){
        $data = DB::table('notifications')
            ->where('client_number','=',Auth::user()->client_number)
            ->where('branch_number','=', Auth::user()->branch_number)
            ->get();
        $data = json_decode($data);
        $data = (array)$data;

        //check if an array
        if(is_array($data) == true && empty($data) === true){
            return false;
        }
        return $data[0];
    }

    public function send_email_alta($email){
        $data = CustomerPlatform::where('email', $email)->first();
        try {
            \Mail::send('emails.altaBeneficiarioIndividual',['data'=>$data], function($m) use ($data){
                $m->from('noreply@syd.com.mx',"Socio SyD");
                $m->to($data['email'], $data['name'].' '.$data['last_name'])->subject('Bienvenido al programa de lealtad SYD');
            });
            return response()->json(['success'=>'true','status' =>200]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>'false','status' =>401]);
        }
    }
}
