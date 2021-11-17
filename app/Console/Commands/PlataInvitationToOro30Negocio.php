<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DB;

class PlataInvitationToOro30Negocio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:invitationOroNegocio30';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de invitacion negocios a oro cada 30 de Mes';

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
        $texto = '';
        try {

            $destinataries = DB::table('customers_sessions')
                                ->join('transactions', 'customers_sessions.branch_number', '=', 'transactions.branch_number')
                                ->whereMonth('transaction_date','=', $now)
                                ->select('customers_sessions.email')
                                ->groupBy('transactions.branch_number')
                                ->where('client_type','=', '1')//only negocios
                                ->havingRaw('SUM(transactions.amount) < ?', [7000])
                                ->get();
                                //sin seguro negocios
            $destinataries = json_decode($destinataries);
            $destinataries = (array)$destinataries;

            if(empty($destinataries) == false){

                foreach ($destinataries as $recipient) {
                    Mail::send('emails.plataInvitacionOroDuenio30Mes', [] ,function($m) use ($recipient) {
                        $m->from('sociosyd@syd.com.mx',"Socio SYD");
                        $m->to($recipient->email)->subject('Invitacion a Seguro Socio SyD');
                    });
                }
                //Storage::append('archivo.txt', json_encode($destinataries));
            }
        } catch (\Throwable $th) {
            $texto = $th;
            //Storage::append('archivo.txt', $texto);

            throw $th;
        }
        $this->info('Envio de invitacion negocios a oro cada 30 de Mes');
    }
}
