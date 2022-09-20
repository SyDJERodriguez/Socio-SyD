<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Helpers\C3ntroService;

class AdminControllersearch extends Controller
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
        return view('Admin.search');
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
            ->where('client_number', '=', $client_number)
            ->get();

        $customerDatabranch = DB::table('client_numbers')
            ->where('client_number', '=', $client_number)
            ->get();

        if ( $customerDatabranch->isEmpty() ){
           $error = 'El usuario solicitado no se encuentra registrado en el programa Socio SyD';
           return view('Admin.customersearch', compact('error'));
        }

        if( count($customerDatabranch) > 1 ){
            $branches = DB::table('client_numbers')
                            ->where('client_number','=', $branch_number)
                            ->get();
                            //aquí es indexbranch para el select
            return view('Admin.indexbranchtwo', compact('branches'));
        }

        $email = $customerData[0]->email;

        $account = DB::table('customers_sessions')
            ->where('email', '=', $email)
            ->first();

        if (empty($account)){
            $error = 'El usuario solicitado no se encuentra registrado en el programa Socio SyD';
            return view('Admin.customersearch', compact('error'));
        }

        $customerData = DB::table('customer_platforms')
            ->where('email', '=', $email)
            ->first();

        //$transactions = $this->getTransactions($client_number);
        //$totalAmount = $this->totalAmount($client_number);

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;
        $previus_month =$now->month - 1;

        if ($previus_month == 0) {
            $current_year = $now->year-1;
            $previus_month =$now->month + 11;
            $data_customer_before = DB::table('transactions')
            ->where('client_number', $client_number)
            ->where('branch_number', $branch_number)
            ->whereMonth('transaction_date','=',$previus_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();
        }
        else{
           $data_customer_before = DB::table('transactions')
           ->where('client_number', $client_number)
           ->where('branch_number', $branch_number)
           ->whereMonth('transaction_date','=',$previus_month)
           ->whereYear('transaction_date', '=', $current_year )
           ->get();
        }
        $current_year = $now->year;
        $transactions = DB::table('transactions')
            ->where('client_number', $client_number)
            ->where('branch_number', $branch_number)
            ->whereMonth('transaction_date','=',$current_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();

        $totalAmount = 0.0;
        $totalAmount_before = 0.0;

        foreach ($data_customer_before as $transaction){
            $amount_customer_before = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount_before -= $amount_customer_before : $totalAmount_before += $amount_customer_before ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        foreach ($transactions as $transaction){
            $amount_customer = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        $level_before = 0;
        if ($account->client_type != "2" || $account->client_type !== "5"){
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

        if ($account->client_type === "2"|| $account->client_type === "5"){
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

        $level = 0;
        if ($account->client_type === "1" || $account->client_type === "3" || $account->client_type === "4"){
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

        if ($account->client_type === "2" || $account->client_type === "5"){
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

            $numberEmployees =  $number = DB::table('associates')
            ->where('client_number','=', $client_number)
            ->where('branch_number','=', $branch_number)
            ->where('active_association','=',1)
            ->count();

        //TODO: If tiene has($customerData) mas de  un registro, entonces mostrar su nombre y correo
        return view('Admin.customersearch',
                    compact('numberEmployees','client_number', 'account', 'transactions', 'totalAmount',
                            'customerData', 'level', 'associates','level_before'));
    }

        // Function for search by email
        public function search_by_branch(Request $request)
        {
            $request = $request->input();
            $email = $request['email'];

            $account= DB::table('customers_sessions')
            ->where('branch_number', '=', $email)
            ->first();



            if (empty($account)){
                $error = 'El usuario solicitado no se encuentra registrado en el programa Socio SyD';
                return view('Admin.customersearch', compact('error'));
            }

            $client_number = $account->client_number;
            $branch_number = $account->branch_number;
            $email = $account->email;

            $customerData = DB::table('customer_platforms')
                ->where('email', '=', $email)
                ->first();

            //$transactions = $this->getTransactions($client_number);
            //$totalAmount = $this->totalAmount($client_number);



            $now = Carbon::now();
            $current_month = $now->month;
            $current_year = $now->year;
            $previus_month =$now->month - 1;

            if ($previus_month == 0) {
                $current_year = $now->year-1;
                $previus_month =$now->month + 11;
                $data_customer_before = DB::table('transactions')
                ->where('client_number', $client_number)
                ->where('branch_number', $branch_number)
                ->whereMonth('transaction_date','=',$previus_month)
                ->whereYear('transaction_date', '=', $current_year )
                ->get();
            }
            else{
               $data_customer_before = DB::table('transactions')
               ->where('client_number', $client_number)
               ->where('branch_number', $branch_number)
               ->whereMonth('transaction_date','=',$previus_month)
               ->whereYear('transaction_date', '=', $current_year )
               ->get();
            }

            $current_year = $now->year;
            $transactions = DB::table('transactions')
                ->where('client_number', $client_number)
                ->where('branch_number', $branch_number)
                ->whereMonth('transaction_date','=',$current_month)
                ->whereYear('transaction_date', '=', $current_year )
                ->get();

            $totalAmount = 0.0;
            $totalAmount_before = 0.0;

            foreach ($data_customer_before as $transaction){
                $amount_customer_before = floatval($transaction->amount);
                strpos($transaction->amount, '-') ? $totalAmount_before -= $amount_customer_before : $totalAmount_before += $amount_customer_before ;

                $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
                $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
                $transaction->payment_method = $payment_method->payment_method;
                $transaction->sale_office    = $sale_office->sale_office;
            }

            foreach ($transactions as $transaction){
                $amount_customer = floatval($transaction->amount);
                strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;

                $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
                $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
                $transaction->payment_method = $payment_method->payment_method;
                $transaction->sale_office    = $sale_office->sale_office;
            }

            $level_before = 0;
            if ($account->client_type != "2" || $account->client_type !== "5"){
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

            if ($account->client_type === "2"|| $account->client_type === "5"){
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


            $level = 0;
            if ($account->client_type === "1" || $account->client_type === "3" || $account->client_type === "4"){
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

            if ($account->client_type === "2" || $account->client_type === "5"){
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

                $numberEmployees =  $number = DB::table('associates')
                ->where('client_number','=', $client_number)
                ->where('branch_number','=', $branch_number)
                ->where('active_association','=',1)
                ->count();

            return view('Admin.customersearch', compact('numberEmployees','client_number', 'account', 'transactions', 'totalAmount', 'customerData', 'level', 'associates','level_before'));
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
            return view('Admin.customersearch', compact('error'));
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
        $previus_month =$now->month - 1;

        if ($previus_month == 0) {
            $current_year = $now->year-1;
            $previus_month =$now->month + 11;
            $data_customer_before = DB::table('transactions')
            ->where('client_number', $client_number)
            ->where('branch_number', $branch_number)
            ->whereMonth('transaction_date','=',$previus_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();
        }
        else{
           $data_customer_before = DB::table('transactions')
           ->where('client_number', $client_number)
           ->where('branch_number', $branch_number)
           ->whereMonth('transaction_date','=',$previus_month)
           ->whereYear('transaction_date', '=', $current_year )
           ->get();
        }
        $current_year = $now->year;
        $transactions = DB::table('transactions')
            ->where('client_number', $client_number)
            ->where('branch_number', $branch_number)
            ->whereMonth('transaction_date','=',$current_month)
            ->whereYear('transaction_date', '=', $current_year )
            ->get();

        $totalAmount = 0.0;
        $totalAmount_before = 0.0;

        foreach ($data_customer_before as $transaction){
            $amount_customer_before = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount_before -= $amount_customer_before : $totalAmount_before += $amount_customer_before ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        foreach ($transactions as $transaction){
            $amount_customer = floatval($transaction->amount);
            strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;

            $payment_method = DB::table('payment_method')->select('payment_method')->where('code', $transaction->payment_method)->first();
            $sale_office = DB::table('sale_office')->select('sale_office')->where('code', $transaction->sale_office)->first();
            $transaction->payment_method = $payment_method->payment_method;
            $transaction->sale_office    = $sale_office->sale_office;
        }

        $level_before = 0;
        if ($account->client_type!= "2" || $account->client_type !== "5"){
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

        if ($account->client_type === "2"|| $account->client_type === "5"){
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


        $level = 0;
        if ($account->client_type === "1" || $account->client_type === "3" || $account->client_type === "4"){
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

        if ($account->client_type === "2" || $account->client_type === "5"){
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

            $numberEmployees =  $number = DB::table('associates')
            ->where('client_number','=', $client_number)
            ->where('branch_number','=', $branch_number)
            ->where('active_association','=',1)
            ->count();

        return view('Admin.customersearch', compact('client_number', 'account', 'transactions', 'totalAmount', 'customerData', 'level', 'associates','level_before','numberEmployees'));
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

        return view('Admin.customersearch',
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
    public function addEmployesearch(Request $request) {
        $session = $request;
        $request       = $request->input();
        $client_number = $request['client_number'];

        $year = Carbon::now()->year;
        $clientYear = explode("-",$request['bday']);
        $clientYear = (int)$clientYear[0];
        $age = $year - $clientYear;

        if( $age < 14 == true || $age > 120 == true){
            //bday validation
            return response()->json(['success'=>'false', 'bday'=>'false', 'error'=>'La fecha de nacimiento no es válida']);
        }

        if($request['second_last_name'] == null || $request['last_name'] == null || $request['name'] == null){
            //name, last name or second last name is empty
            return response()->json(['success'=>'false', 'other'=>'false', 'error'=>"Un campo se encuentra vacío. Por favor ingresa             tu nombre completo"]);
        }

        //validate mobile number
        $valid = $this->phoneValidator($request['mobile_number']);
        if ($valid == false){
            return response()->json(['success'=>'false', 'verify_valid_mobile'=>'false']);
        }

        //validated email
        $apiKeySYD = "04b09b09ab3c6c723da119fddae6e4f5";
        $client = new Client([
            'base_uri' => 'https://api.towerdata.com/v5/ev?timeout=10&email=' . $request['email'] . '&api_key=' . $apiKeySYD,
            'timeout'  => 3.0,
        ]);

        $response = $client->request('GET');
        $response = json_decode($response->getBody()->getContents());

        if( $response->email_validation->status != 'valid' && $response->email_validation->status != 'unverifiable'){
            return response()->json(['success'=>'false','other'=> 'false','error'=>'El email no existe o no es verificable.             Corroborar datos' ]);
        }

        //Validate DNS email
        //$domain = explode('@', $request['email']);
        //$validate_dns = sizeof(dns_get_record($domain[1]));

        // return $validate_dns;
        //if ($validate_dns <= 0){
         //   return response()->json(['success'=>'false', 'verify_valid_dns'=>'false']);
        //}

        //Verify is the email has not a relation with other client number
        //$verify_mobile_number = CustomersSession::where('mobile_number', $request['mobile_number'])->first();

        //Verify if the guest has an account
        $verify_mobile_email = DB::table('customers_sessions')
            ->where('mobile', '=', $request['mobile_number'])
            ->orWhere('email', '=', $request['email'])
            ->get();

        $verify_mobile_email = json_decode($verify_mobile_email);
        $verify_mobile_email = (array)$verify_mobile_email;

        //dd(!empty($verify_mobile_email));
        //Check if the account is a mechanic account
        if(!empty($verify_mobile_email)){
            if($verify_mobile_email[0]->client_type == '2'){
                $owner = DB::table('customer_platforms')
                    ->where('client_number', '=', $request['client_number'])
                    ->first();
                $ownerName = $owner->name.' '.$owner->last_name.' '.$owner->second_last_name;

                $data = DB::table('customer_platforms')
                    ->where('email', '=', $request['email'])
                    ->first();
                $information = [
                    'test'=> 'Datos',
                    'customer_id'=> $request['customer_id'],
                    'client_number'=> $request['client_number'],
                    'name' => $data->name,
                    'last_name' => $data->last_name,
                    'second_last_name' => $data->second_last_name,
                    'birthday' => $data->birthday,
                    'mobile' => $data->mobile_number,
                    'email' => $request['email'],
                    'owner' => $ownerName
                ];
                //dd($information);
                $this->inviteMechanicToDependent($information);
                return response()->json(['success'=>'false','other'=> 'false','error'=>'El email y/o télefono ya está registrado en nuestro programa Socio SYD. Corroborar datos' ]);

            }
        }

        //Check if th account is an owner account
        if(!empty($verify_mobile_email)){
            if ($verify_mobile_email[0]->client_type == '1' || $verify_mobile_email[0]->client_type == '4'){
                return response()->json(['success'=>'false','other'=> 'false','error'=>'El email y/o télefono ya está registrado en nuestro programa Socio SYD. Corroborar datos' ]);
            }
        }

        //Check if th account is an owner account
        if(!empty($verify_mobile_email)){
            if ($verify_mobile_email[0]->client_type == '3'){
                return response()->json(['success'=>'false','other'=> 'false','error'=>'El email y/o télefono ya está registrado en nuestro programa Socio SYD. Corroborar datos' ]);

            }
        }

        //Verify if the email is associates with other owner
        $query = DB::table('associates')
                    ->where('mobile_number','=',$request['mobile_number'])
                    ->orWhere('email','=',$request['email'])
                    ->where('active_association','=',1)
                    ->get();
        $query = json_decode($query);
        $query = (array)$query;//convert to array

        if (is_array($query) == true && empty($query) === false && $query[0]->active_association == 1){ //check if response exist
            if($query[0]->mobile_number === $request['mobile_number'] || $query[0]->email === $request['email']){
                return response()->json(['success'=>'false','other'=> 'false','error'=>'El email y/o télefono ya está registrado en nuestro programa Socio SYD. Corroborar datos' ]);

            }
            return response()->json(['success'=>'false','other'=> 'false','error'=>'El email y/o télefono ya está registrado en nuestro programa Socio SYD. Corroborar datos' ]);

        }

        //Verify if the email is deactive association with the current owner
        $deactivate = DB::table('associates')
            ->where('mobile_number','=',$request['mobile_number'])
            ->orWhere('email','=',$request['email'])
            ->where('active_association','=',0)
            ->get();
        $deactivate = json_decode($deactivate);
        $deactivate = (array)$deactivate;//convert to array

        if (is_array($query) == true && empty($query) === false && $query[0]->active_association == 0){ //check if response exist
            return response()->json(['success'=>'false','other'=> 'false','error'=>'El email y/o télefono ya está registrado en nuestro programa Socio SYD. Corroborar datos' ]);

        }
        //calculated number in associates table
        $number = $this->getNumberAssociate($request['customer_id'],$request['branch_number']);
        ++$number; //plus one bc 0 don't exists

        //insert data in associates table
        $update_associates ='';
        //insert data in associates table
        $update_associates = DB::table('associates')->insert([
            'customer_id'       => $request['customer_id'],
            'client_number'     => $client_number,
            'name'              => $request['name'],
            'last_name'         => $request['last_name'],
            'second_last_name'  => $request['second_last_name'],
            'role'              => isset($request['role']) ? $request['role'] : "",
            'active_association'=> 1,
            'number'            => $number,
            'birthday'          => $request['bday'],
            'created_at'        => date('Y-m-d H:i:s'),
            'mobile_number'     => $request['mobile_number'],
            'email'             => $request['email'],
            'branch_number'     => isset($request['branch_number']) ? $request['branch_number'] : null
        ]); //debo buscar el associado de aqui en la DB(pasar en lra url el numero de telefono tambien)
       // return redirect()->route('exito');

        if ($update_associates === 1 || $update_associates === true || $update_associates === 0){
            $this->invitation($request);
            $email = $request['email_auth'];
            //$data = CustomerPlatform::where('email', Auth::user()->email)->first();
            $response = $this->employeeLimit(
                $request['email_auth'],
                $request['customer_id'],
                $request['client_type']);

            if ($response->validated === false){

                //$messsage = 'Ya diste de alta exitosamente a todos tus colaboradores en Socio SYD.';

               // C3ntroService::sendSMS($messsage,'+52'.$request['mobile_auth']);
                Mail::send('emails.allEmployees',[], function($m) use ($email){
                    $m->from('sociosyd@syd.com.mx',"Socio SYD");
                    $m->to($email)->subject("Ya diste de alta exitosamente a todos tus colaboradores en Socio SYD");
                });
            }

            $session->session()->flash('success','the email/mobile number its already in db');
            return response()->json(['success'=>'true']);

        }else{
           return response()->json(['success'=>'false', 'update'=>$update_associates]);
        }

    }

    // Get all customers register in Pegaso
    public function total_registers() {
        //Get the clients with benefits in current month of the current year
        $registered_clients = DB::table('customers_sessions')
            ->join('customer_platforms', 'customer_platforms.email', '=', 'customers_sessions.email')
            ->join('transactions', function($join){
                $now = Carbon::now();
                $current_month = $now->month;
                $current_year = $now->year;
                $join->on('customers_sessions.branch_number', '=', 'transactions.branch_number')
                    ->whereMonth( 'transaction_date', '=', $current_month )
                    ->whereYear( 'transaction_date', '=', $current_year );
            })
            ->select(
                'customers_sessions.id AS id',
                DB::raw('SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) ) AS amount'),
                DB::raw('IF((customers_sessions.client_type=1 OR customers_sessions.client_type=3 OR customers_sessions.client_type=4) AND (SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) )>=2500 AND SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) )<=4500), "Bronce",
                                            IF((customers_sessions.client_type=1 OR customers_sessions.client_type=3 OR customers_sessions.client_type=4) AND (SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) )>4500 AND SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) )<=7000), "Plata",
                                                IF((customers_sessions.client_type=1 OR customers_sessions.client_type=3 OR customers_sessions.client_type=4) AND (SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) )>7000), "Oro",
                                                    IF((customers_sessions.client_type=2 OR customers_sessions.client_type=5) AND (SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) )>=200 AND SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) )<=500), "Bronce",
                                                        IF((customers_sessions.client_type=2 OR customers_sessions.client_type=5) AND (SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) )>500 AND SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) )<=1300), "Plata",
                                                            IF((customers_sessions.client_type=2 OR customers_sessions.client_type=5) AND (SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) )>1300), "Plata", "Sin beneficios")))))) AS level')

            )
            ->groupBy(['customers_sessions.branch_number','customers_sessions.client_type'])
            ->get()->toArray();

        $data =  DB::table ('customers_sessions')
            ->join('customer_platforms', 'customers_sessions.email','=','customer_platforms.email')
            ->select(
                'customers_sessions.id AS id',
                        'customers_sessions.client_number',
                        'customers_sessions.branch_number',
                        'customer_platforms.name',
                        'customer_platforms.last_name',
                        'customer_platforms.second_last_name',
                        'customer_platforms.gender',
                        'customer_platforms.birthday',
                        'customers_sessions.email',
                        'customers_sessions.mobile AS phone',
                        DB::raw('DATE_FORMAT(customers_sessions.created_at, "%Y-%m-%d") AS fecha_registro'),
                        DB::raw('IF(customers_sessions.client_type = 1, "Dueño de Negocio",
                                                            IF(customers_sessions.client_type = 2,"Mecánico Individual",
                                                                IF(customers_sessions.client_type = 3, "Empleado Dependiente",
                                                                    IF(customers_sessions.client_type = 4, "Cadenas",
                                                                        IF(customers_sessions.client_type = 5, "Publico en general", null))))) AS type_user'),
                        DB::raw('IF(customers_sessions.active = 0, "No Activado", "Activado") AS active')
            )
            ->get()->toArray();

        /*$now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;*/

        //Get all the client´s id with benefits in the current month
        $ids = array_column($registered_clients, 'id');
        foreach ($data as $client){
           /* $client->fecha_registro = date_format(date_create($client->fecha_registro), "Y-m-d");

            $client_transaction = DB::table('transactions')
                ->where('client_number', $client->client_number)
                ->where('branch_number', $client->branch_number)
                ->whereMonth('transaction_date','=',$current_month)
                ->whereYear('transaction_date', '=', $current_year )
                ->get();
            $totalAmount = 0.0;*/

            //Set amount and benefits level
            $client->amount = 0;
            $client->level  = 'Sin beneficios';

            //Search if the client has benefits in the current month
            $in_clients = array_search($client->id, $ids);

            //If the client has benefits, set the amount and the level of the current month
            if($in_clients !== false){
                $client->amount = $registered_clients[$in_clients]->amount;
                $client->level  = $registered_clients[$in_clients]->level;
            }

            //Check if the client is an employee of a company account

            if($client->type_user === 'Empleado Dependiente'){
                $associate_data = DB::table('associates')
                    ->where('email', '=', $client->email)
                    ->first();

                $client->client_number = $client->client_number.'-'.$associate_data->number;
            }

            /*foreach ($client_transaction as $transaction){
                $amount_customer = floatval($transaction->amount);
                strpos($transaction->amount, '-') ? $totalAmount -= $amount_customer : $totalAmount += $amount_customer ;
            }
            $client->amount = $totalAmount;

            if($client->type_user === '1'){
                $client->type_user = 'Cuenta con Colaboradores';
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
                $client->type_user = 'Cuenta Individual';
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


            $client->active === 0 ? $client->active = 'No Activado' : $client->active = 'Activado';*/
            //Remove the key id of the json
            unset($client->id);
        }

        //return response()->json($data);
        return view('Admin.registers', compact('data'));
    }
}
