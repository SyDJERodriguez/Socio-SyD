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
                'customer_platforms.id as customer_platform_id',
                'customers_sessions.sms_insurance'
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
            $level = '';
            if($client->type_user === '1'){
                $client->type_user = 'Dueño de Negocio';
                if ($totalAmount>2500) {
                    $level= 'Bronce';
                }
            }else if($client->type_user === '2'){
                $client->type_user = 'Mecánico Individual';
                if ($totalAmount>200) {
                    $level= 'Bronce';
                }
            }else if($client->type_user === '3'){
                $client->type_user = 'Empleado Dependiente';
                if ($totalAmount>2500) {
                    $level= 'Bronce';
                }
            }else if($client->type_user === '4'){
                $client->type_user = 'Cadenas';
                if ($totalAmount>2500) {
                    $level= 'Bronce';
                }
            }else if($client->type_user === '5'){
                $client->type_user = 'Publico General';
                if ($totalAmount>200) {
                    $level= 'Bronce';
                }
            }

            if(!$client->sms_insurance){
                if($level === 'Bronce'){
                    if(count($beneficiaries) > 0){
                        $url = url('/sms_pdf/'.$client->client_number.'/'.$client->branch_number);
                        $messsage = '¡Felicidades! Ya tienes Seguro de Accidentes con Socio SyD. Descarga, llena y firma tu certificado aquí  '.$url;
                        $send_sms = TwilioService::send_sms($messsage,'+52'.$client->phone);
                        if($send_sms){
                            DB::table('customers_sessions')
                                ->where('client_number','=',$client->client_number)
                                ->update(['sms_insurance' => true]);
                        }
                    }else{
                        $url = url('account/verify/000000001');
                        $messsage = 'Ya tienes derecho a tu seguro de accidentes de Socio SyD, registra a tus beneficiarios y descarga tu certificado aquí '.$url;
                        $send_sms = TwilioService::send_sms($messsage,'+52'.$client->phone);
                        if($send_sms){
                            DB::table('customers_sessions')
                                ->where('client_number','=',$client->client_number)
                                ->update(['sms_insurance' => true]);
                        }
                    }

                }
            }
            $client->active === 0 ? $client->active = 'false' : $client->active = 'true';
        }
        return response()->json('success');
    }
}
