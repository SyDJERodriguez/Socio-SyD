<?php

namespace App\Console\Commands;
use App\Helpers\C3ntroService;
use Carbon\Carbon;
use DB;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
                'customers_sessions.sms_insurance',
                'customers_sessions.silver_sms',
                'customers_sessions.gold_sms'
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

            $numberEmployees =  $number = DB::table('associates')
            ->where('client_number','=', $client->client_number)
            ->where('branch_number','=', $client->branch_number)
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
            $silver_messsage = 'Felicidades, ya cuentas con las asistencias de nivel Plata dentro de Socio SYD. Descubre los beneficios que tienes aqui: www.sociosyd.com.mx';
            $gold_messsage = 'Felicidades, ya cuentas con las asistencias de nivel Oro dentro de Socio SYD. Descubre los beneficios que tienes aqui: www.sociosyd.com.mx';
            if($client->type_user === '1'){
                $client->type_user = 'Dueño de Negocio';
                if ($totalAmount>=2500 && $totalAmount<=4500) {
                    if(!$client->sms_insurance){
                        if(count($numberEmployees) <= 1){
                            $url = 'https://sociosyd.com.mx/register/beneficiariebranch/'.$client->email;
                            $messsage = 'Estimado Socio SyD, ahora que has alcanzado beneficios en tu cuenta, puedes dar de alta a tus colaboradores. Hazlo aqui  '.$url;
                            $send_sms = C3ntroService::sendSMS($messsage,'+52'.$client->phone);
                        }
                        if(count($beneficiaries) > 0){
                            $url = 'https://sociosyd.com.mx/sms_pdf/'.$client->client_number.'/'.$client->branch_number;
                            $messsage = 'Felicidades, ya tienes Seguro de Accidentes con Socio SyD. Descarga, llena y firma tu certificado aqui  '.$url;
                            $send_sms = C3ntroService::sendSMS($messsage,'+52'.$client->phone);
                            if($send_sms){
                                DB::table('customers_sessions')
                                    ->where('client_number','=',$client->client_number)
                                    ->update(['sms_insurance' => true]);
                            }
                        }else{
                            $url = 'https://sociosyd.com.mx/register/beneficiaries/'.$client->email;
                            $messsage = 'Ya tienes derecho a tu seguro de accidentes de Socio SyD, registra a tus beneficiarios y descarga tu certificado aqui '.$url;
                            $send_sms = C3ntroService::sendSMS($messsage,'+52'.$client->phone);
                            if($send_sms){
                                DB::table('customers_sessions')
                                    ->where('client_number','=',$client->client_number)
                                    ->update(['sms_insurance' => true]);
                            }
                        }
                        Mail::send('emails.companyLevelBronce', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('¡Felicidades! Ya tienes Seguro de Accidentes con Socio SyD');
                        });
                    }
                }
                if ($totalAmount>4500 && $totalAmount<=7500) {
                    if (!$client->silver_sms){
                        $send_sms = C3ntroService::sendSMS($silver_messsage,'+52'.$client->phone);
                        Mail::send('emails.companyLevelPlata', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('Ya cuentas con las asistencias de nivel Plata dentro de Socio SYD');
                        });
                        if($send_sms){
                            DB::table('customers_sessions')
                                ->where('client_number','=',$client->client_number)
                                ->update(['silver_sms' => true]);
                        }
                    }
                }
                if ($totalAmount>7500) {
                    if (!$client->gold_sms){
                        $send_sms = C3ntroService::sendSMS($gold_messsage,'+52'.$client->phone);
                        Mail::send('emails.companyLevelGold', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('Ya cuentas con las asistencias de nivel Oro dentro de Socio SYD');
                        });
                        if($send_sms){
                            DB::table('customers_sessions')
                                ->where('client_number','=',$client->client_number)
                                ->update(['gold_sms' => true]);
                        }
                    }
                }
            }else if($client->type_user === '2'){
                $client->type_user = 'Mecánico Individual';
                if ($totalAmount>=200 && $totalAmount<=500) {
                    if(!$client->sms_insurance){
                        if(count($beneficiaries) > 0){
                            $url = 'https://sociosyd.com.mx/sms_pdf/'.$client->client_number.'/'.$client->branch_number;
                            $messsage = 'Felicidades, ya tienes Seguro de Accidentes con Socio SyD. Descarga, llena y firma tu certificado aqui  '.$url;
                            $send_sms = C3ntroService::sendSMS($messsage,'+52'.$client->phone);
                            if($send_sms){
                                DB::table('customers_sessions')
                                    ->where('client_number','=',$client->client_number)
                                    ->update(['sms_insurance' => true]);
                            }
                        }else{
                            $url = 'https://sociosyd.com.mx/register/beneficiaries/'.$client->email;
                            $messsage = 'Ya tienes derecho a tu seguro de accidentes de Socio SyD, registra a tus beneficiarios y descarga tu certificado aqui '.$url;
                            $send_sms = C3ntroService::sendSMS($messsage,'+52'.$client->phone);
                            if($send_sms){
                                DB::table('customers_sessions')
                                    ->where('client_number','=',$client->client_number)
                                    ->update(['sms_insurance' => true]);
                            }
                        }
                        Mail::send('emails.individualLevelBronce', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('¡Felicidades! Ya tienes Seguro de Accidentes con Socio SyD');
                        });
                    }
                }
                if ($totalAmount>500 && $totalAmount<=1300) {
                    if (!$client->silver_sms){
                        $send_sms = C3ntroService::sendSMS($silver_messsage,'+52'.$client->phone);
                        Mail::send('emails.individualLevelPlata', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('Ya cuentas con las asistencias de nivel Plata dentro de Socio SYD');
                        });
                        if($send_sms){
                            DB::table('customers_sessions')
                                ->where('client_number','=',$client->client_number)
                                ->update(['silver_sms' => true]);
                        }
                    }
                }
                if ($totalAmount>1300) {
                    if (!$client->gold_sms){
                        $send_sms = C3ntroService::sendSMS($gold_messsage,'+52'.$client->phone);
                        Mail::send('emails.individualLevelGold', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('Ya cuentas con las asistencias de nivel Oro dentro de Socio SYD');
                        });

                        if($send_sms){
                            DB::table('customers_sessions')
                                ->where('client_number','=',$client->client_number)
                                ->update(['gold_sms' => true]);
                        }
                    }
                }
            }else if($client->type_user === '3'){
                $client->type_user = 'Empleado Dependiente';
                if ($totalAmount>=2500 && $totalAmount<=4500) {
                    if(!$client->sms_insurance){
                        if(count($beneficiaries) > 0){
                            $url = 'https://sociosyd.com.mx/sms_pdf/'.$client->client_number.'/'.$client->branch_number;
                            $messsage = 'Felicidades, ya tienes Seguro de Accidentes con Socio SyD. Descarga, llena y firma tu certificado aqui  '.$url;
                            $send_sms = C3ntroService::sendSMS($messsage,'+52'.$client->phone);
                            if($send_sms){
                                DB::table('customers_sessions')
                                    ->where('client_number','=',$client->client_number)
                                    ->update(['sms_insurance' => true]);
                            }
                        }else{
                            $url = 'https://sociosyd.com.mx/register/beneficiaries/'.$client->email;
                            $messsage = 'Ya tienes derecho a tu seguro de accidentes de Socio SyD, registra a tus beneficiarios y descarga tu certificado aqui '.$url;
                            $send_sms = C3ntroService::sendSMS($messsage,'+52'.$client->phone);
                            if($send_sms){
                                DB::table('customers_sessions')
                                    ->where('client_number','=',$client->client_number)
                                    ->update(['sms_insurance' => true]);
                            }
                        }
                        Mail::send('emails.companyLevelBronce', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('¡Felicidades! Ya tienes Seguro de Accidentes con Socio SyD');
                        });
                    }
                }
                if ($totalAmount>4500 && $totalAmount<=7500) {
                    if (!$client->silver_sms){
                        $send_sms = C3ntroService::sendSMS($silver_messsage,'+52'.$client->phone);
                        Mail::send('emails.companyLevelPlata', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('Ya cuentas con las asistencias de nivel Plata dentro de Socio SYD');
                        });
                        if($send_sms){
                            DB::table('customers_sessions')
                                ->where('client_number','=',$client->client_number)
                                ->update(['silver_sms' => true]);
                        }
                    }
                }
                if ($totalAmount>7500) {
                    if (!$client->gold_sms){
                        $send_sms = C3ntroService::sendSMS($gold_messsage,'+52'.$client->phone);
                        Mail::send('emails.companyLevelGold', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('Ya cuentas con las asistencias de nivel Oro dentro de Socio SYD');
                        });
                        if($send_sms){
                            DB::table('customers_sessions')
                                ->where('client_number','=',$client->client_number)
                                ->update(['gold_sms' => true]);
                        }
                    }
                }
            }else if($client->type_user === '4'){
                $client->type_user = 'Cadenas';
                if ($totalAmount>=2500 && $totalAmount<=4500) {
                    if(!$client->sms_insurance){
                        if(count($numberEmployees) === 0){
                            $url = 'https://sociosyd.com.mx/register/beneficiariebranch/'.$client->email;
                            $messsage = 'Estimado Socio SyD, ahora que has alcanzado beneficios en tu cuenta, puedes dar de alta a tus colaboradores. Hazlo aqui  '.$url;
                            $send_sms = C3ntroService::sendSMS($messsage,'+52'.$client->phone);
                        }
                        if(count($beneficiaries) > 0){
                            $url = 'https://sociosyd.com.mx/sms_pdf/'.$client->client_number.'/'.$client->branch_number;
                            $messsage = 'Felicidades, ya tienes Seguro de Accidentes con Socio SyD. Descarga, llena y firma tu certificado aqui  '.$url;
                            $send_sms = C3ntroService::sendSMS($messsage,'+52'.$client->phone);
                            if($send_sms){
                                DB::table('customers_sessions')
                                    ->where('client_number','=',$client->client_number)
                                    ->update(['sms_insurance' => true]);
                            }
                        }else{
                            $url = 'https://sociosyd.com.mx/register/beneficiaries/'.$client->email;
                            $messsage = 'Ya tienes derecho a tu seguro de accidentes de Socio SyD, registra a tus beneficiarios y descarga tu certificado aqui '.$url;
                            $send_sms = C3ntroService::sendSMS($messsage,'+52'.$client->phone);
                            if($send_sms){
                                DB::table('customers_sessions')
                                    ->where('client_number','=',$client->client_number)
                                    ->update(['sms_insurance' => true]);
                            }
                        }
                        Mail::send('emails.companyLevelBronce', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('¡Felicidades! Ya tienes Seguro de Accidentes con Socio SyD');
                        });
                    }
                }
                if ($totalAmount>4500 && $totalAmount<=7500) {
                    if (!$client->silver_sms){
                        $send_sms = C3ntroService::sendSMS($silver_messsage,'+52'.$client->phone);
                        Mail::send('emails.companyLevelPlata', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('Ya cuentas con las asistencias de nivel Plata dentro de Socio SYD');
                        });
                        if($send_sms){
                            DB::table('customers_sessions')
                                ->where('client_number','=',$client->client_number)
                                ->update(['silver_sms' => true]);
                        }
                    }
                }
                if ($totalAmount>7500) {
                    if (!$client->gold_sms){
                        $send_sms = C3ntroService::sendSMS($gold_messsage,'+52'.$client->phone);
                        Mail::send('emails.companyLevelGold', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('Ya cuentas con las asistencias de nivel Oro dentro de Socio SYD');
                        });
                        if($send_sms){
                            DB::table('customers_sessions')
                                ->where('client_number','=',$client->client_number)
                                ->update(['gold_sms' => true]);
                        }
                    }
                }
            }else if($client->type_user === '5'){
                $client->type_user = 'Publico General';
                if ($totalAmount>=200 && $totalAmount<=500) {
                    if(!$client->sms_insurance){                        
                        if(count($beneficiaries) > 0){
                            $url = 'https://sociosyd.com.mx/sms_pdf/'.$client->client_number.'/'.$client->branch_number;
                            $messsage = 'Felicidades, ya tienes Seguro de Accidentes con Socio SyD. Descarga, llena y firma tu certificado aqui  '.$url;
                            $send_sms = C3ntroService::sendSMS($messsage,'+52'.$client->phone);
                            if($send_sms){
                                DB::table('customers_sessions')
                                    ->where('client_number','=',$client->client_number)
                                    ->update(['sms_insurance' => true]);
                            }
                        }else{
                            $url = 'https://sociosyd.com.mx/register/beneficiaries/'.$client->email;
                            $messsage = 'Ya tienes derecho a tu seguro de accidentes de Socio SyD, registra a tus beneficiarios y descarga tu certificado aqui '.$url;
                            $send_sms = C3ntroService::sendSMS($messsage,'+52'.$client->phone);
                            if($send_sms){
                                DB::table('customers_sessions')
                                    ->where('client_number','=',$client->client_number)
                                    ->update(['sms_insurance' => true]);
                            }
                        }
                        Mail::send('emails.individualLevelBronce', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('¡Felicidades! Ya tienes Seguro de Accidentes con Socio SyD');
                        });
                    }

                }
                if ($totalAmount>500 && $totalAmount<=1300) {
                    if (!$client->silver_sms){
                        $send_sms = C3ntroService::sendSMS($silver_messsage,'+52'.$client->phone);
                        Mail::send('emails.individualLevelPlata', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('Ya cuentas con las asistencias de nivel Plata dentro de Socio SYD');
                        });
                        if($send_sms){
                            DB::table('customers_sessions')
                                ->where('client_number','=',$client->client_number)
                                ->update(['silver_sms' => true]);
                        }
                    }
                }
                if ($totalAmount>1300) {
                    if (!$client->gold_sms){
                        $send_sms = C3ntroService::sendSMS($gold_messsage,'+52'.$client->phone);
                        Mail::send('emails.individualLevelGold', [] ,function($m) use ($client) {
                            $m->from('sociosyd@syd.com.mx',"Socio SYD");
                            $m->to($client->email)->subject('Ya cuentas con las asistencias de nivel Oro dentro de Socio SYD');
                        });
                        if($send_sms){
                            DB::table('customers_sessions')
                                ->where('client_number','=',$client->client_number)
                                ->update(['gold_sms' => true]);
                        }
                    }
                }
            }
            $client->active === 0 ? $client->active = 'false' : $client->active = 'true';
        }
        return response()->json('success');
    }
}
