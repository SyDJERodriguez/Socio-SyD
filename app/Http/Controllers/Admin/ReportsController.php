<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = DB::table('benefits_reports')->get();
        return view('Admin.Reports.index', compact('reports'));
    }

    public function create_telasist_report()
    {
        $today = Carbon::now()->format('d-m-Y');
        $last_register =  DB::table('benefits_reports')->orderBy('id', 'desc')->first();
        $last_id = $last_register ? $last_register->id+1 : 1;
        $report_id = 'TELASIST_'.Carbon::now()->format('dmY').'_'.$last_id;

        $start_date = new Carbon('first day of next month');
        $start_date = $start_date->format('d/m/Y');

        $end_date = new Carbon('last day of next month');
        $end_date = $end_date->format('d/m/Y');

        $new_report = DB::table('benefits_reports')->insert([
            'created_date'   => $today,
            'status'        => '1',
            'created_by'    => Auth::user()->name,
            'approved_by'   => '',
            'approved_date' => '',
            'report_id'     => $report_id,
            'type_report'   => 'TELASIST'
        ]);

        if ($new_report) {
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
                                                            IF((customers_sessions.client_type=2 OR customers_sessions.client_type=5) AND (SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) )>1300), "Oro", "Ninguno")))))) AS level')

                )
                ->where('customers_sessions.client_type','!=','3')
                ->groupBy(DB::raw("DATE_FORMAT(transactions.transaction_date, '%m-%Y')"), 'customers_sessions.email')
                ->orderBy('customers_sessions.created_at', 'ASC')
                ->get();

            $associates = DB::table('customers_sessions')
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
                                                            IF((customers_sessions.client_type=2 OR customers_sessions.client_type=5) AND (SUM(IF(locate("-",amount)>0, CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*-1,CAST(SUBSTRING_INDEX(amount,"-",1) AS DECIMAL(11,2))*1) )>1300), "Oro", "Ninguno")))))) AS level')

                )
                ->where('customers_sessions.client_type','=','3')
                ->orderBy('transactions.transaction_date', 'ASC')
                ->groupBy(DB::raw("DATE_FORMAT(transactions.transaction_date, '%m-%Y')"), 'customers_sessions.email')
                ->get();


            //Get all the clients registered in Socio Syd
            $all_clients = DB::table('customers_sessions')
                ->join('customer_platforms', 'customer_platforms.email', '=', 'customers_sessions.email')
                ->select(
                    'customers_sessions.id AS id',
                    'customers_sessions.client_number AS client_number',
                    'customer_platforms.name AS nombre',
                    'customer_platforms.last_name AS apellido_paterno',
                    'customer_platforms.second_last_name AS apellido_materno',
                    'customer_platforms.gender AS gender',
                    'customer_platforms.birthday AS fecha_nacimiento',
                    'customers_sessions.email AS email',
                    'customers_sessions.mobile AS telefono',
                )
                ->orderBy('customers_sessions.created_at', 'ASC')
                ->get();

            $merged = $registered_clients->merge($associates);
            $mergedd = $merged->merge($registered_clients);
            $registers = $mergedd->toArray();

            //return $registers;


            //Get all the client´s id with benefits in the current month
            $ids = array_column($registers, 'id');

            //Loop for all clients registered in Socio SyD
            foreach ($all_clients as $client) {

                //Set benefits level
                $client->level = 'Ninguno';

                //Search if the client has benefits in the current month
                $in_clients = array_search($client->id, $ids);

                //If the client has benefits, set the amount and the level of the current month
                if ($in_clients !== false) {
                    $client->level = $registers[$in_clients]->level;
                }

                $flag_birthday = Carbon::parse( $client->fecha_nacimiento )->age;

                $birthday = explode("-", $client->fecha_nacimiento);
                $client->fecha_nacimiento = $birthday[2] . "/" . $birthday[1] . "/" . $birthday[0];

                //Remove the key id of the json
                unset($client->id);

                if( 'Ninguno' !== $client->level && 'Bronce' !== $client->level && $flag_birthday >= 18 ) {
                    $new_register = DB::table('telasist_beneficiaries')->insert([
                        'client_number'    => $client->client_number,
                        'name'             => $client->nombre,
                        'last_name'        => $client->apellido_paterno,
                        'second_last_name' => $client->apellido_materno,
                        'email'            => $client->email,
                        'birthday'         => $client->fecha_nacimiento,
                        'phone'            => $client->telefono,
                        'gender'           => $client->gender,
                        'benefit'          => $client->level,
                        'start_date'       => $start_date,
                        'end_date'         => $end_date,
                        'report_id'        => $report_id
                    ]);
                }
            }
        }

        $reports = DB::table('benefits_reports')->get();
        return view('Admin.Reports.index', compact('reports'));
    }

    public function report_detail ($report_id) {
        DB::table('benefits_reports')->where('report_id','=',$report_id)->update([
            'status' => '2'
        ]);
        $beneficiaries  = DB::table('telasist_beneficiaries')->where('report_id','=',$report_id)->get();
        return view('Admin.Reports.report_detail', compact('beneficiaries'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function remove_article($word){
        $correct_word = str_replace("DEL","", $word);
        $correct_word = str_replace("LAS","", $word);
        $correct_word = str_replace("DE","", $word);
        $correct_word = str_replace("LA","", $word);
        $correct_word = str_replace("Y","", $word);
        $correct_word = str_replace("A","", $word);
        $correct_word = str_replace("MC","", $word);
        $correct_word = str_replace("LOS","", $word);
        $correct_word = str_replace("VON","", $word);
        $correct_word = str_replace("VAN","", $word);

        return $correct_word;
    }

    private function is_vowel($letter){
        if($letter === "A" || $letter === "E" || $letter === "I" || $letter === "O" || $letter === "U" || $letter === "a" || $letter === "e" || $letter === "i" || $letter === "o" || $letter === "u"){
            return 1;
        }else{
            return 0;
        }
    }

    private function generate_rfc($name, $last_name, $second_last_name, $birthday){
        $name             = strtoupper((trim($name)));
        $last_name        = strtoupper((trim($last_name)));
        $second_last_name = strtoupper((trim($second_last_name)));

        $rfc = '';

        $last_name        = self::remove_article($last_name);
        $second_last_name = self::remove_article($second_last_name);

        $rfc = substr($last_name,0,1);

        $first_vowel = strlen($last_name);
        for ($i = 1; $i<$first_vowel; $i++){
            $v = substr($last_name,$i,1);
            if(self::is_vowel($v) === 1){
                $rfc .= $v;
                break;
            }
        }
        $rfc .= substr($second_last_name, 0, 1);
        $rfc .= substr($name, 0, 1);
        $rfc .= substr($birthday, 6, 2).substr($birthday,3,2).substr($birthday,0,2);

        return $rfc;
    }
}
