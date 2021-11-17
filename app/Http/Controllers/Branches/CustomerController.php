<?php

namespace App\Http\Controllers\Branches;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function  index(){
        return view('Branches.Customers.index');
    }

    public function insurance_policies(){
        return view('Branches.Customers.insurance_policies');
    }

    public function credit(){
        return view('Branches.Customers.credits');
    }

    public function verify_customer(Request $request){
        $request = $request->input();
        $validator = $this->validator($request);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $client_number = '00'.$request['client_number'];
        $branch_id = $request['branch_id'];
        $now = Carbon::now();
        $last_month = $now->month-1;
        //dd($now->month-1);
        $data_customer = DB::table('transactions')
            ->where('client_number', $client_number)
            ->whereMonth('transaction_date','=',$last_month)
            ->get();
        $total_amount_customer = 0.0;
        foreach ($data_customer as $data){
            $amount_customer = floatval($data->amount);
            strpos($data->amount, '-') ? $total_amount_customer -= $amount_customer : $total_amount_customer += $amount_customer ;
        }
        //dd($total_amount_customer);
        if($total_amount_customer >= 200){
            $is_validate = DB::table('validates_customer_branch')->where('client_number', $client_number)->first();
            if ($is_validate){
                $branch = DB::table('users_branches')->where('id', $is_validate->branch_id)->first();
                return back()->with('error', "El cliente con el número: ".$request['client_number']." ya activó su seguro en la sucursal: ".$branch->name);
            }else{
                $link1 = 'https://syd-files.s3.amazonaws.com/FORMULARIO+DE+INGRESO.docx';
                $link2 = 'https://syd-files.s3.amazonaws.com/FORMATO+DE+ESTUDIO+SOCIOECONOMICO+T.S..pdf';
                $link3 = 'https://syd-files.s3.amazonaws.com/CONSENTIMIENTO+AP.pdf';
                return view('Branches.Customers.formats_download', compact('link1', 'link2', 'link3', 'client_number', 'branch_id'));
            }
        }else{
            return back()->with('error', 'El cliente no tiene derecho a la póliza de seguro, ya que no ha hecho el mínimo de compra mensual de $200.00 en este mes');
        }
    }

    public function validate_customer(Request $request){
        $request = $request->input();
        $client_number = $request['client_number'];
        $branch_id     = $request['branch_id'];
        $validate_date = Carbon::now()->format('Y-m-d');
        $validate      = true;

        $query = DB::table('validates_customer_branch')->insert([
            'client_number' => $client_number,
            'branch_id'     => $branch_id,
            'validate_date' => $validate_date,
            'validate'      => $validate
        ]);

        $query_email = DB::table('customers')
            ->select('customers.name', 'customers.last_name', 'customers.second_last_name', 'customers.email')
            ->where('client_number','=',$client_number)
            ->first();
        //dd($query_email);
        if ($query){
            $this->send_email($query_email);
            return view('Branches.Customers.validated_customer', compact('client_number'));
        }else{
            return back()->with('error', 'Algo ha salido mal, intente de nuevo.');
        }
    }

    public function verify_credit(Request $request){
        $request = $request->input();
        $validator = $this->validator($request);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $client_number = '00'.$request['client_number'];
        $data = DB::table('customers_credit')->where('client_number', $client_number)->first();

        //dd($data);
        if ($data){
            return view('Branches.Customers.credit_amount', compact('data'));
        }else{
            return back()->with('error', 'El cliente con número: '.$client_number.' no tiene derecho a crédito.');
        }

    }

    public function send_email($data){
        //$fullname = $data->name.' '.$data->last_name.' '.$data->second_last_name;
        //dd($data->email);
        \Mail::send('Branches.Customers.email',['data'=>$data], function($m) use ($data){
            $m->from('sociosyd@syd.com.mx',"Socio SYD");
            $m->to($data->email, $data->name.' '.$data->last_name.' '.$data->second_last_name)->subject('Tu seguro de accidentes ha sido activado.');
        });
    }

    private function validator(array $data){
        return Validator::make($data,[
            'client_number' => 'required|digits:8'
        ],[
            'client_number.required' => 'El número de cliente es obligatorio',
            'client_number.digits' => 'El número de cliente debe ser de 8 digitos'
        ]);
    }
}
