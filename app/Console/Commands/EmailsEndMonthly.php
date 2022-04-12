<?php

namespace App\Console\Commands;

use App\Helpers\C3ntroService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use DB;

class EmailsEndMonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:end_monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This job execute end monthly';

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
        $now = Carbon::now();
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
            $message_one   = 'Este mes no alcanzaste las compras minimas para obtener tu seguro de accidentes personales de Socio SYD';
            $message_two   = 'Este mes no alcanzaste las compras minimas para obtener los beneficios de asistencia Nivel Plata de Socio SYD';
            $message_three = 'Este mes no alcanzaste las compras minimas para obtener los beneficios de asistencia Nivel Oro de Socio SYD';
            if($client->type_user === '1'){
                if ($totalAmount<2500) {
                    C3ntroService::sendSMS($message_one,'+52'.$client->phone);
                    Mail::send('emails.sinSeguroInvitacionSeguroDuenio30Mes', [] ,function($m) use ($client) {
                        $m->from('sociosyd@syd.com.mx',"Socio SYD");
                        $m->to($client->email)->subject('Invitacion a Seguro Socio SyD');
                    });
                }
                if ($totalAmount>=2500 && $totalAmount<=4500) {
                    C3ntroService::sendSMS($message_two,'+52'.$client->phone);
                    Mail::send('emails.seguroInvitacionPlataDuenio30Mes', [] ,function($m) use ($client) {
                        $m->from('sociosyd@syd.com.mx',"Socio SYD");
                        $m->to($client->email)->subject('Invitacion a Asistencia Plata Socio SyD');
                    });
                }
                if ($totalAmount>4500 && $totalAmount<=7500) {
                    C3ntroService::sendSMS($message_three,'+52'.$client->phone);
                    Mail::send('emails.plataInvitacionOroDuenio30Mes', [] ,function($m) use ($client) {
                        $m->from('sociosyd@syd.com.mx',"Socio SYD");
                        $m->to($client->email)->subject('Invitacion a Asistencia Plata Socio SyD');
                    });
                }
            }else if($client->type_user === '2'){
                if ($totalAmount<200) {
                    C3ntroService::sendSMS($message_one,'+52'.$client->phone);
                    Mail::send('emails.sinSeguroInvitacionSeguroIndividual30Mes', [] ,function($m) use ($client) {
                        $m->from('sociosyd@syd.com.mx',"Socio SYD");
                        $m->to($client->email)->subject('Invitacion a Seguro Socio SyD');
                    });
                }
            }else if($client->type_user === '4'){
                if ($totalAmount<2500) {
                    C3ntroService::sendSMS($message_one,'+52'.$client->phone);
                    Mail::send('emails.sinSeguroInvitacionSeguroDuenio30Mes', [] ,function($m) use ($client) {
                        $m->from('sociosyd@syd.com.mx',"Socio SYD");
                        $m->to($client->email)->subject('Invitacion a Seguro Socio SyD');
                    });
                }
                if ($totalAmount>=2500 && $totalAmount<=4500) {
                    C3ntroService::sendSMS($message_two,'+52'.$client->phone);
                    Mail::send('emails.seguroInvitacionPlataDuenio30Mes', [] ,function($m) use ($client) {
                        $m->from('sociosyd@syd.com.mx',"Socio SYD");
                        $m->to($client->email)->subject('Invitacion a Asistencia Plata Socio SyD');
                    });
                }
                if ($totalAmount>4500 && $totalAmount<=7500) {
                    C3ntroService::sendSMS($message_three,'+52'.$client->phone);
                    Mail::send('emails.plataInvitacionOroDuenio30Mes', [] ,function($m) use ($client) {
                        $m->from('sociosyd@syd.com.mx',"Socio SYD");
                        $m->to($client->email)->subject('Invitacion a Asistencia Plata Socio SyD');
                    });
                }
            }else if($client->type_user === '5'){
                if ($totalAmount<200) {
                    C3ntroService::sendSMS($message_one,'+52'.$client->phone);
                    Mail::send('emails.sinSeguroInvitacionSeguroIndividual30Mes', [] ,function($m) use ($client) {
                        $m->from('sociosyd@syd.com.mx',"Socio SYD");
                        $m->to($client->email)->subject('Invitacion a Seguro Socio SyD');
                    });
                }
            }

            $client->active === 0 ? $client->active = 'false' : $client->active = 'true';

        }
        return response()->json('success');
    }
}
