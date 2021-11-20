<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = 'admin/customers/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }

    // Function for search by client number
    public function search_by_number(Request $request)
    {
        $request = $request->input();
        $client_number = '00'.$request['client_number'];
        $branch_number = '00'.$request['client_number'];

        $customerData = DB::table('customers_sessions')
            ->where('branch_number', '=', $client_number)
            ->get();

        if ( $customerData->isEmpty() ){
            return view('Admin.indexbranch');
           // $error = 'El usuario solicitado no se encuentra registrado en el programa Socio SyD';
           // return view('Admin.customer', compact('error'));
        }

        elseif( count($customerData) > 1 ){
            $dependents = DB::table('customer_platforms')
                            ->where('client_number','=', $client_number)
                            ->get();
            return view('Admin.dependents', compact('dependents'));
        }

        $email = $customerData[0]->email;

        $account = DB::table('customers_sessions')
            ->where('email', '=', $email)
            ->first();

        if (empty($account)){
            $error = 'El usuario solicitado no se encuentra registrado en el programa Socio SyD';
            return view('Admin.customer', compact('error'));
        }

        $customerData = DB::table('customer_platforms')
            ->where('email', '=', $email)
            ->first();

        //$transactions = $this->getTransactions($client_number);
        //$totalAmount = $this->totalAmount($client_number);

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;

        $transactions = DB::table('transactions')
            ->where('client_number', $client_number)
            ->where('branch_number', $branch_number)
            ->whereMonth('transaction_date','=',$current_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();

        $totalAmount = 0.0;

        foreach ($transactions as $transaction){
            $amount_customer = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        $level = 0;
        if ($account->client_type === "1" || $account->client_type === "3"){
            if ($totalAmount<2500) {
                $level = 0;
            }
            if ($totalAmount>2500 && $totalAmount<=4500) {
                $level = 1;
            }
            if ($totalAmount>4500 && $totalAmount<=7000) {
                $level = 2;
            }
            if ($totalAmount>7000) {
                $level = 3;
            }
        }

        if ($account->client_type === "2"){
            if ($totalAmount<200) {
                $level = 0;
            }
            if ($totalAmount>200 && $totalAmount<=500) {
                $level = 1;
            }
            if ($totalAmount>500 && $totalAmount<=1300) {
                $level = 2;
            }
            if ($totalAmount>1300) {
                $level = 3;
            }
        }
        $now = Carbon::now();
        $user = Auth::user();
        $nowDate = $now->toDateString();
        $nowTime = $now->toTimeString();
        $insert_log = DB::table('log_admin_searches')->insert([
            'user' => $user->email,
            'name' => $user->name,
            'wanted_client' => $client_number,
            'date' => $nowDate,
            'time' => $nowTime

        ]);

        $associates = DB::table('associates')
            ->where([['client_number','=',$client_number], ['active_association', '=', 1]])
            ->get();

        //TODO: If tiene has($customerData) mas de  un registro, entonces mostrar su nombre y correo
        return view('Admin.customer',
                    compact('client_number', 'account', 'transactions', 'totalAmount',
                            'customerData', 'level', 'associates'));
    }

    // Function for search by email
    public function search_by_email(Request $request)
    {
        $request = $request->input();
        $email = $request['email'];
        $account = DB::table('customers_sessions')
            ->where('email', '=', $email)
            ->first();

        if (empty($account)){
            $error = 'El usuario solicitado no se encuentra registrado en el programa Socio SyD';
            return view('Admin.customer', compact('error'));
        }

        $client_number = $account->client_number;
        $branch_number = $account->branch_number;

        $customerData = DB::table('customer_platforms')
            ->where('email', '=', $email)
            ->first();

        //$transactions = $this->getTransactions($client_number);
        //$totalAmount = $this->totalAmount($client_number);



        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;

        $transactions = DB::table('transactions')
            ->where('client_number', $client_number)
            ->where('branch_number', $branch_number)
            ->whereMonth('transaction_date','=',$current_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();

        $totalAmount = 0.0;

        foreach ($transactions as $transaction){
            $amount_customer = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        $level = 0;
        if ($account->client_type === "1" || $account->client_type === "3"){
            if ($totalAmount>2500 && $totalAmount<=4500) {
                $level = 1;
            }
            if ($totalAmount>4500 && $totalAmount<=7000) {
                $level = 2;
            }
            if ($totalAmount>7000) {
                $level = 3;
            }
        }

        if ($account->client_type === "2"){
            if ($totalAmount>200 && $totalAmount<=500) {
                $level = 1;
            }
            if ($totalAmount>500 && $totalAmount<=1300) {
                $level = 2;
            }
            if ($totalAmount>1300) {
                $level = 3;
            }
        }
        $now = Carbon::now();
        $user = Auth::user();
        $nowDate = $now->toDateString();
        $nowTime = $now->toTimeString();
        $insert_log = DB::table('log_admin_searches')->insert([
            'user' => $user->email,
            'name' => $user->name,
            'wanted_client' => $email,
            'date' => $nowDate,
            'time' => $nowTime

        ]);

        $associates = DB::table('associates')
            ->where([['client_number','=',$client_number], ['active_association', '=', 1]])
            ->get();

        return view('Admin.customer', compact('client_number', 'account', 'transactions', 'totalAmount', 'customerData', 'level', 'associates'));
    }

    //function search by dependent
    public function search_dependent($id){
        $customerData = DB::table('customer_platforms')
            ->where('id', '=', $id)
            ->first();
        $client_number = $customerData->client_number;
        $email = $customerData->email;

        $account = DB::table('customers_sessions')
        ->where('email', '=', $email)
        ->first();

        $transactions = $this->getTransactions($client_number);
        $totalAmount = $this->totalAmount($client_number);

        $level = 0;
        if ($account->client_type === "1" || $account->client_type === "3"){
            if ($totalAmount<2500) {
                $level = 0;
            }
            if ($totalAmount>2500 && $totalAmount<=4500) {
                $level = 1;
            }
            if ($totalAmount>4500 && $totalAmount<=7000) {
                $level = 2;
            }
            if ($totalAmount>7000) {
                $level = 3;
            }
        }

        if ($account->client_type === "2"){
            if ($totalAmount<200) {
                $level = 0;
            }
            if ($totalAmount>200 && $totalAmount<=500) {
                $level = 1;
            }
            if ($totalAmount>500 && $totalAmount<=1300) {
                $level = 2;
            }
            if ($totalAmount>1300) {
                $level = 3;
            }
        }
        $now = Carbon::now();
        $user = Auth::user();
        $nowDate = $now->toDateString();
        $nowTime = $now->toTimeString();
        $insert_log = DB::table('log_admin_searches')->insert([
            'user' => $user->email,
            'name' => $user->name,
            'wanted_client' => $client_number,
            'date' => $nowDate,
            'time' => $nowTime

        ]);

        $associates = DB::table('associates')
            ->where([['client_number','=',$client_number], ['active_association', '=', 1]])
            ->get();

        return view('Admin.customer',
        compact('client_number', 'account', 'transactions', 'totalAmount',
                'customerData', 'level', 'associates'));
    }

    //calculated totalAmount
    public function totalAmount($client_number){
        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;

        $data_customer = $this->getTransactions($client_number);
        $totalAmount = 0.0;
        foreach ($data_customer as $d){
            $amount_customer = floatval($d->amount);
            strpos($d->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
        }

        return $totalAmount;
    }

    //Get transactions
    public function getTransactions($client_number){
        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;

        $trans1 = DB::table('transactions')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $client_number)
            ->where('transactions.branch_number','=', $client_number)
            ->where('amount', 'not like', '%' . '-' . '%')
            ->whereMonth('transaction_date', $current_month)
            ->get();

        $trans2 = DB::table('transactions')
            ->join('sale_office', 'transactions.sale_office', '=', 'sale_office.code')
            ->join('payment_method', 'transactions.payment_method', '=', 'payment_method.code')
            ->where('transactions.client_number','=', $client_number)
            ->where('transactions.branch_number','=', $client_number)
            ->where('amount', 'like', '%' . '-' . '%')
            ->whereMonth('transaction_date', $now->subMonth(1)->month)
            ->get();

        $customer_trans = $trans1->merge($trans2);
        return $customer_trans;
    }

    // Get all customers register in Pegaso
    public function total_registers() {
        $data =  DB::table ('customers_sessions')
            ->join('customer_platforms', 'customers_sessions.email','=','customer_platforms.email')
            ->select(
                'customers_sessions.client_number',
                        'customers_sessions.branch_number',
                        'customer_platforms.name',
                        'customer_platforms.last_name',
                        'customer_platforms.second_last_name',
                        'customer_platforms.gender',
                        'customer_platforms.birthday',
                        'customers_sessions.email',
                        'customers_sessions.mobile AS phone',
                        'customers_sessions.created_at AS fecha_registro',
                        'customers_sessions.client_type AS type_user',
                        'customers_sessions.active'
            )
            ->get();

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        foreach ($data as $client){
            $client->fecha_registro = date_format(date_create($client->fecha_registro), "Y-m-d");

            $client_transaction = DB::table('transactions')
                ->where('client_number', $client->client_number)
                ->where('branch_number', $client->branch_number)
                ->whereMonth('transaction_date','=',$current_month)
                ->whereYear('transaction_date', '=', $current_year )
                ->get();
            $totalAmount = 0.0;

            if($client->type_user === '3'){
                $associate_data = DB::table('associates')
                    ->where('email', '=', $client->email)
                    ->first();

                $client->client_number = $client->client_number.'-'.$associate_data->number;
            }

            foreach ($client_transaction as $transaction){
                $amount_customer = floatval($transaction->amount);
                strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
            }
            $client->amount = $totalAmount;

            if($client->type_user === '1'){
                $client->type_user = 'Dueño de Negocio';
                if ($totalAmount>2500 && $totalAmount<=4500) {
                    $client->level= 'Bronce';
                }
                if ($totalAmount>4500 && $totalAmount<=7000) {
                    $client->level= 'Plata';
                }
                if ($totalAmount>7000) {
                    $client->level= 'Oro';
                }
                if ($totalAmount<2500) {
                    $client->level= 'Sin beneficios';
                }
            }else if($client->type_user === '2'){
                $client->type_user = 'Mecánico Individual';
                if ($totalAmount>200 && $totalAmount<=500) {
                    $client->level= 'Bronce';
                }
                if ($totalAmount>500 && $totalAmount<=1300) {
                    $client->level= 'Plata';
                }
                if ($totalAmount>1300) {
                    $client->level= 'Oro';
                }
                if ($totalAmount<200) {
                    $client->level= 'Sin beneficios';
                }
            }else if($client->type_user === '3'){
                $client->type_user = 'Empleado Dependiente';
                if ($totalAmount>2500 && $totalAmount<=4500) {
                    $client->level= 'Bronce';
                }
                if ($totalAmount>4500 && $totalAmount<=7000) {
                    $client->level= 'Plata';
                }
                if ($totalAmount>7000) {
                    $client->level= 'Oro';
                }
                if ($totalAmount<2500) {
                    $client->level= 'Sin beneficios';
                }
            }else if($client->type_user === '4'){
                $client->type_user = 'Cadenas';
                if ($totalAmount>2500 && $totalAmount<=4500) {
                    $client->level= 'Bronce';
                }
                if ($totalAmount>4500 && $totalAmount<=7000) {
                    $client->level= 'Plata';
                }
                if ($totalAmount>7000) {
                    $client->level= 'Oro';
                }
                if ($totalAmount<2500) {
                    $client->level= 'Sin beneficios';
                }
            }


            $client->active === 0 ? $client->active = 'No Activado' : $client->active = 'Activado';
        }

        //return response()->json($data);
        return view('Admin.registers', compact('data'));
    }
}
