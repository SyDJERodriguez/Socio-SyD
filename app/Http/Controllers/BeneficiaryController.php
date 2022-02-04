<?php

namespace App\Http\Controllers;

use App\CustomersSession;
use App\Helpers\C3ntroService;
use Illuminate\Http\Request;
use App\Customer;
use App\CustomerPlatform;
use Auth;
use DB;
use PDF;
use Carbon\Carbon;

class BeneficiaryController extends Controller
{
    //Function to generate PDF by SMS
    public function generatePDFSMS($client_number, $branch_number) {

        $customer_session = DB::table('customers_sessions')
            ->where('client_number','=', $client_number)
            ->where('branch_number','=', $branch_number)
            ->first();

        $id = $customer_session->id;

        $customer = DB::table('customer_platforms')
            ->where('email', '=', $customer_session->email)
            ->first();

        $beneficiaries = DB::table('beneficiaries')
            ->where('customer_id', '=', $customer->id)
            ->get();

        $signature = DB::table('signatures')
            ->where('customer_id', '=', $id)
            ->first();

        if ($customer_session->client_type === "3"){
            $customer = DB::table('customer_platforms')
                ->where('email', '=', $customer_session->email)
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
    }

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

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $previus_month=$now->month - 1;

        if ($previus_month == 0) {
            $current_year = $now->year-1;
            $previus_month =$now->month + 11;
            $data_customer_before = DB::table('transactions')
            ->where('client_number', Auth::user()->client_number)
            ->where('branch_number', Auth::user()->branch_number)
            ->whereMonth('transaction_date','=',$previus_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();
        }
        else{
            $data_customer_before = DB::table('transactions')
            ->where('client_number', Auth::user()->client_number)
            ->where('branch_number', Auth::user()->branch_number)
            ->whereMonth('transaction_date','=',$previus_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();
        }
        $current_year = $now->year;
        $totalAmount_before = 0.0;
        foreach ($data_customer_before as $transaction){
            $amount_customer_before = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount_before -= $amount_customer_before : $totalAmount_before += $amount_customer_before ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }
        $level_before = 0;
        if (Auth::user()->client_type != "2" || Auth::user()->client_type !== "5"){
            if ($totalAmount_before>2500 && $totalAmount_before<=4500) {
                $level_before = 1;
            }
            if ($totalAmount_before>4500 && $totalAmount_before<=7000) {
                $level_before = 2;
            }
            if ($totalAmount_before>7000) {
                $level_before = 3;
            }
        }

        if (Auth::user()->client_type === "2"|| Auth::user()->client_type === "5"){
            if ($totalAmount_before>200 && $totalAmount_before<=500) {
                $level_before = 1;
            }
            if ($totalAmount_before>500 && $totalAmount_before<=1300) {
                $level_before = 2;
            }
            if ($totalAmount_before>1300) {
                $level_before = 3;
            }
        }

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


        foreach ($request['percent'] as $percent){
            if($percent != ""){
                $count++;
                //Sum the all percent
                $total_percent += intval($percent);
            }
        }

        //Verify if is one o two registers
        if ($count == 2){
            if ($total_percent !== 100){
                //Here the response if total percent of beneficiaries is not 100
                $error = 'El porcentaje total debe ser de 100%';

                return view('pages.Account.beneficiary', compact(
                    'error', 'data', 'request', 'level','is_cnt',
                    'signature', 'noti', 'total', 'number','owner','level_before'));
                //dd($total_percent);
            }

            $valid = false;
            foreach ($request['phone'] as $mobile) {
                $valid = $this->phoneValidator($mobile);

                if ($valid === false){
                $error = 'Un número de teléfono ingresado no es válido';

                return view('pages.Account.beneficiary', compact(
                    'error', 'data', 'request', 'level','is_cnt',
                    'signature', 'noti', 'total', 'number','owner','level_before'));
                }
            }

            try{
                //Here insert each register of the form
                for ($i = 0; $i<=1; $i++){
                    //valid name,last,secondLast
                    if($request['second_lastname'][$i] == null || $request['lastname'][$i] == null
                        || $request['name'][$i] == null || $request['parent'][$i] == null){
                    $error = 'Un campo se encuentra vacío. Por favor de corroborar datos';

                    return view('pages.Account.beneficiary', compact(
                        'error', 'data', 'request', 'level','is_cnt',
                        'signature', 'noti', 'total', 'number','owner','level_before'));
                    }

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
                                'branch_number'    => $request['branch_number'][0]
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
                     //if(Auth::user()->client_type === "2"){
                        $this->send_email_alta($data->email);
                    //}
                    return view('pages.Account.beneficiary', compact(
                        'success', 'data', 'beneficiary', 'level','is_cnt',
                        'signature', 'noti', 'total', 'number','owner','level_before'));
                //}

            }catch(\Exception $e){
                $error = $e;
                return view('pages.Account.beneficiary', compact(
                    'error', 'data', 'request', 'noti','level',
                    'total','owner','total','number','is_cnt','level_before'));
            }

        }elseif ($count == 1){
            if (intval($request['percent'][0]) !== 100){
                //Here the response if total percent of beneficiaries is not 100
                $error = 'El porcentaje total debe ser de 100%';
                return view('pages.Account.beneficiary', compact(
                    'error', 'data', 'request', 'level',
                    'signature', 'noti', 'total', 'number',
                    'owner','is_cnt','level_before'));
            }

             //valid name,last,secondLast
             if($request['second_lastname'][0] == null || $request['lastname'][0] == null
                || $request['name'][0] == null || $request['parent'][0] == null){
                $error = 'Un campo se encuentra vacío. Por favor de corroborar datos';

                return view('pages.Account.beneficiary', compact(
                    'error', 'data', 'request', 'level','is_cnt',
                    'signature', 'noti', 'total', 'number','owner','level_before'));
            }

            $valid = false;
            $valid = $this->phoneValidator($request['phone'][0]);
            if ($valid === false){
                $error = 'Un número de teléfono ingresado no es válido';

                return view('pages.Account.beneficiary', compact(
                    'error', 'data', 'request', 'level','is_cnt',
                    'signature', 'noti', 'total', 'number','owner','level_before'));
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
                   //if(Auth::user()->client_type === "2"){
                        $this->send_email_alta($data->email);
                    //}
                return view('pages.Account.beneficiary', compact('success', 'data', 'beneficiary', 'level', 'signature', 'noti', 'total', 'number','owner','is_cnt','level_before'));
           // }
        }
    }

    //get transactions by branch_number or client_number
    public function getTransCadena($email){
        $dataSession = DB::table('customers_sessions')
                        ->where('email','=', $email)->first();
        $now = Carbon::now();

        $trans1 = DB::table('transactions')
           // ->join('material_type', 'transactions.tmat', '=', 'material_type.code')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $dataSession->client_number)
            ->where('transactions.branch_number','=', $dataSession->branch_number)
            ->where('amount', 'not like', '%' . '-' . '%')
            ->whereMonth('transaction_date', $now->month)
            ->get();

        $trans2 = DB::table('transactions')
            //->join('material_type', 'transactions.tmat', '=', 'material_type.code')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $dataSession->client_number)
            ->where('transactions.branch_number','=', $dataSession->branch_number)
            ->where('amount', 'like', '%' . '-' . '%')
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

    //Register beneficiaries without Auth
    public function addBeneficiaries (Request $request) {
        $request = $request->input();

        $data = DB::table('customer_platforms')->where('email', $request['email'])->first();
        $data_session = DB::table('customers_sessions')->where('email', $request['email'])->first();
        $data->branch_number = $data_session->branch_number;

        $number = '';
        if ($data_session->client_type === "3"){
            $data = DB::table('customer_platforms')->where('email', $request['email'])->first();
            $data->branch_number =  $data_session->branch_number;
            $number = DB::table('associates')
                ->select('number')
                ->where('email', $request['email'])
                ->first();
        }

        $email = $request['email'];


        //dd($request['name'][1]);
        $count = 0;
        $total_percent = 0;

        /*$signature = DB::table('customers_sessions')
            ->select('signature_id')
            ->where('id', '=', $data_session->id)
            ->first();
        $signature = $signature->signature_id;*/

        //$now = Carbon::now();
        //$current_month = $now->month;

        $owner = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        //$data_session = CustomersSession::where('email', Auth::user()->email)->first();
        /*$data_customer = $this->getTransCadena($request['email']);
        $total_amount = 0.0;
        foreach ($data_customer as $d){
            //if( date_format(date_create($d->transaction_date)->modify('+2 day'), 'Y-m-d') < date($now->isoformat("Y-MM-D")) ){
            $amount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $total_amount -= $amount_customer : $total_amount += $amount_customer ;
            //}
        }

        $cnt = intval($data_session->client_number);
        $is_cnt = 'false';
        if( ($cnt > 90000000) && ($cnt < 90020000)) {
            $is_cnt = 'true';
        }

        //$noti = $this->getNotifications();
        $total = $total_amount;

        $level = 0;
        if ($data_session->client_type === "1" || $data_session->client_type === "4"){
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

        if ($data_session->client_type === "2" || $data_session->client_type === "3"){
            if ($total_amount>200 && $total_amount<=500) {
                $level = 1;
            }
            if ($total_amount>500 && $total_amount<=1300) {
                $level = 2;
            }
            if ($total_amount>1300) {
                $level = 3;
            }
        }*/


        foreach ($request['percent'] as $percent){
            if($percent != ""){
                $count++;
                //Sum the all percent
                $total_percent += intval($percent);
            }
        }

        //Verify if is one o two registers
        $client_number = $data_session->client_number;
        $branch_number = $data_session->branch_number;
        if ($count == 2){
            if ($total_percent !== 100){
                //Here the response if total percent of beneficiaries is not 100
                $error = 'El porcentaje total debe ser de 100%';

                return view('pages.registerBeneficiaries', compact(
                    'error', 'data', 'request', 'number','owner', 'email', 'branch_number'));
                //dd($total_percent);
            }

            $valid = false;
            foreach ($request['phone'] as $mobile) {
                $valid = $this->phoneValidator($mobile);

                if ($valid === false){
                    $error = 'Un número de teléfono ingresado no es válido';

                    return view('pages.registerBeneficiaries', compact(
                        'error', 'data', 'request', 'number','owner', 'email', 'branch_number'));
                }
            }

            try{
                //Here insert each register of the form
                for ($i = 0; $i<=1; $i++){
                    //valid name,last,secondLast
                    if($request['second_lastname'][$i] == null || $request['lastname'][$i] == null
                        || $request['name'][$i] == null || $request['parent'][$i] == null){
                        $error = 'Un campo se encuentra vacío. Por favor de corroborar datos';

                        return view('pages.registerBeneficiaries', compact(
                            'error', 'data', 'request', 'number','owner', 'email', 'branch_number'));
                    }

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
                                'branch_number'    => $request['branch_number']
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
                //if($data_session->client_type === "2"){
                    $this->send_email_alta($data->email);
                //}
                return view('pages.registerBeneficiaries', compact(
                    'success', 'data', 'beneficiary', 'number','owner', 'email', 'client_number', 'branch_number'));
                //}

            }catch(\Exception $e){
                $error = $e;
                return view('pages.registerBeneficiaries', compact(
                    'error', 'data', 'request', 'owner','number', 'email', 'branch_number'));
            }

        }elseif ($count == 1){
            if (intval($request['percent'][0]) !== 100){
                //Here the response if total percent of beneficiaries is not 100
                $error = 'El porcentaje total debe ser de 100%';
                return view('pages.registerBeneficiaries', compact(
                    'error', 'data', 'request','number',
                    'owner', 'email', 'branch_number'));
            }

            //valid name,last,secondLast
            if($request['second_lastname'][0] == null || $request['lastname'][0] == null
                || $request['name'][0] == null || $request['parent'][0] == null){
                $error = 'Un campo se encuentra vacío. Por favor de corroborar datos';

                return view('pages.registerBeneficiaries', compact(
                    'error', 'data', 'request', 'number','owner', 'email', 'branch_number'));
            }

            $valid = false;
            $valid = $this->phoneValidator($request['phone'][0]);
            if ($valid === false){
                $error = 'Un número de teléfono ingresado no es válido';

                return view('pages.registerBeneficiaries', compact(
                    'error', 'data', 'request', 'number','owner', 'email', 'branch_number'));
            }

            $insertBeneficiary = DB::table('beneficiaries')->insert([
                'name'             => $request['name'][0],
                'last_name'        => $request['lastname'][0],
                'second_last_name' => $request['second_lastname'][0],
                'relationship'     => $request['parent'][0],
                'mobile_number'    => $request['phone'][0],
                'percent'          => $request['percent'][0],
                'customer_id'      => $data->id,
                'branch_number'    => $request['branch_number']
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
            //if($data_session->client_type === "2"){
                $this->send_email_alta($data->email);
            //}

            return view('pages.registerBeneficiaries', compact('success', 'data', 'beneficiary', 'number','owner', 'email', 'client_number', 'branch_number'));
            // }
        }
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
        $dataSession = CustomersSession::where('email', $email)->first();

        $route = "/sms_pdf/{$dataSession->client_number}/{$dataSession->branch_number}";
        $url = url($route);
        $messsage = 'Ya estas asegurado con el programa Socio SYD. Descarga tu poliza de Seguro de Accidentes Personales aqui: '.$url;

        try {
            // TwilioService::send_sms
            C3ntroService::sendSMS($messsage,'+52'.$dataSession->mobile);
            \Mail::send('emails.beneficiariesAdded',['data'=>$data], function($m) use ($data){
                $m->from('noreply@syd.com.mx',"Socio SYD");
                $m->to($data->email, $data->name.' '.$data->last_name)->subject('Haz registrado exitosamente a tus beneficiarios en el programa de lealtad SYD');
            });
            return response()->json(['success'=>'true','status' =>200]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>'false','status' =>401]);
        }
    }
}
