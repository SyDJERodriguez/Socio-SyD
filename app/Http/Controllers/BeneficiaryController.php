<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Auth;
use DB;
use PDF;
use Carbon\Carbon;

class BeneficiaryController extends Controller
{
    public function add_beneficiaries (Request $request) {
        $data = Customer::where('client_number', Auth::user()->client_number)->first();
        $beneficiary = 'true';
        //$beneficiares = DB::table('beneficiaries')->where('customer_id', $data['id'])->first();
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

        $data_customer = DB::table('transactions')
            ->where('client_number', Auth::user()->client_number)
            ->whereMonth('transaction_date','=',$current_month)
            ->get();
        $total_amount = 0.0;
        foreach ($data_customer as $d){
            $amount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $total_amount -= $amount_customer : $total_amount += $amount_customer ;
        }

        $level = 0;
        if (Auth::user()->client_type === "1"){
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

        if (Auth::user()->client_type === "2"){
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
            $count++;
            //Sum the all percent
            $total_percent += intval($percent);
        }

        //Verify if is one o two registers
        if ($count == 2){
            if ($total_percent !== 100){
                //Here the response if total percent of beneficiaries is not 100
                $error = 'El porcentaje total debe ser de 100%.';

                return view('pages.Account.beneficiary', compact('error', 'data', 'request', 'level', 'signature'));
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
                                'customer_id'      => $data['id']
                            ]);
                        }
                    }
                }

                //$generatePDF = $this->generatePDF();
                //if ($generatePDF === 'success') {
                    $success = 'Los beneficiarios han sido agregados correctamente.';
                    return view('pages.Account.beneficiary', compact('success', 'data', 'beneficiary', 'level', 'signature'));
                //}

            }catch(\Exception $e){
                $error = $e;
                return view('pages.Account.beneficiary', compact('error', 'data', 'request'));
            }

        }elseif ($count == 1){
            if (intval($request['percent'][0]) !== 100){
                //Here the response if total percent of beneficiaries is not 100
                $error = 'El porcentaje total debe ser de 100%.';
                return view('pages.Account.beneficiary', compact('error', 'data', 'request', 'level', 'signature'));
            }



                    $insertBeneficiary = DB::table('beneficiaries')->insert([
                        'name'             => $request['name'][0],
                        'last_name'        => $request['lastname'][0],
                        'second_last_name' => $request['second_lastname'][0],
                        'relationship'     => $request['parent'][0],
                        'mobile_number'    => $request['phone'][0],
                        'percent'          => $request['percent'][0]   ,
                        'customer_id'      => $data['id']
                    ]);

            //$generatePDF = $this->generatePDF();

            //if ($generatePDF === 'success'){
                $success = 'El beneficiario ha sido agregado correctamente.';
                $beneficiary = 'true';
                return view('pages.Account.beneficiary', compact('success', 'data', 'beneficiary', 'level', 'signature'));
           // }
        }
    }

    //Function to generate PDF and upload AWS's S3
    public function generatePDF() {
        $id = Auth::user()->id;
        $customer = DB::table('customers')
            ->where('client_number', '=', Auth::user()->client_number)
            ->first();
        $beneficiaries = DB::table('beneficiaries')
            ->where('customer_id', '=', $customer->id)
            ->get();

        $signature = DB::table('signatures')
            ->where('client_number', '=', Auth::user()->client_number)
            ->first();
        return PDF::loadView('layouts.Policies.safePolicy', ['beneficiary'=>$beneficiaries, 'signature'=>$signature, 'customer'=>$customer])->stream($customer->id.'.pdf');
        //$upload = \Storage::cloud()->put('polizas/'.$id.'.pdf', $pdf->output(), 'public');
        //if($upload){
        //    return 'success';
        //}

        //return 'failed';
    }
}
