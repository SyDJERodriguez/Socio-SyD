<?php

namespace App\Console\Commands;
use App\Helpers\Twilio\TwilioService;
use Carbon\Carbon;
use DB;

use Illuminate\Console\Command;

class DailyJobForCheckInsurance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:daily_check_insurance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This job is for check if the customer has the minimum amount for get insurance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $registered_clients = DB::table('customers_sessions')
            ->join('customer_platforms', 'customer_platforms.email', '=', 'customers_sessions.email')
            ->select(
                'customers_sessions.client_number AS client_number',
                'customers_sessions.branch_number AS branch_number',
                'customer_platforms.name AS name',
                'customer_platforms.last_name AS last_name',
                'customer_platforms.second_last_name AS second_last_name',
                'customer_platforms.email AS email',
                'customers_sessions.mobile AS phone',
                'customer_platforms.birthday AS birthday',
                'customers_sessions.created_at AS fecha_registro',
                'customers_sessions.client_type AS type_user',
                'customers_sessions.active',
                'customer_platforms.id as customer_platform_id'
            )
            ->get();

        $now = Carbon::now();
        $current_month = $now->month;
        $current_year = $now->year;

        foreach ($registered_clients as $client){
            set_time_limit(60);

            $beneficiaries = DB::table('beneficiaries')
                ->where('customer_id', '=', $client->customer_platform_id)
                ->get();


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
            }else if($client->type_user === '2'){
                $client->type_user = 'Mecánico Individual';
                if ($totalAmount>200 && $totalAmount<=500) {
                    $client->level= 'Bronce';
                }
            }else if($client->type_user === '3'){
                $client->type_user = 'Empleado Dependiente';
                if ($totalAmount>2500 && $totalAmount<=4500) {
                    $client->level= 'Bronce';
                }
            }else if($client->type_user === '4'){
                $client->type_user = 'Cadenas';
                if ($totalAmount>2500 && $totalAmount<=4500) {
                    $client->level= 'Bronce';
                }
            }else if($client->type_user === '5'){
                $client->type_user = 'Publico General';
                if ($totalAmount>200 && $totalAmount<=500) {
                    $client->level= 'Bronce';
                }
            }

            if($client->level === 'Bronce' && count($beneficiaries) > 0){
                $url = url('account/verify/000000001');
                $messsage = 'Descarga el certificado: '.$url.'Desde el jon';
                return TwilioService::send_sms($messsage,'+529211400440');
            }else if($client->level === 'Bronce' && count($beneficiaries) <= 0 ){
                $url = url('account/verify/000000001');
                $messsage = 'Registra beneficiarios: '.$url.'Desde el jon';
                return TwilioService::send_sms($messsage,'+529211400440');
            }

            $client->active === 0 ? $client->active = 'false' : $client->active = 'true';

        }
    }
}
