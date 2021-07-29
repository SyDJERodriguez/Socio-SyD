<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DB;

class EmailInvitationInsurance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:seguro';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de invitacion a seguro cada 20 de Mes';

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
    public function handle(){
        $now = Carbon::now();
        $texto = '';
        //$destinataries = ["laguirre@quaxar.com",
        //                "luis.24_aguirre@outlook.com"];
        // DB::rollback();
        // $update_customer = $th;
        // throw $th;
        try {

            $destinataries = DB::table('customers_sessions')
                                ->join('transactions', 'customers_sessions.branch_number', '=', 'transactions.branch_number')
                                ->whereMonth('transaction_date','=', $now)
                                ->select('customers_sessions.email',
                                         'customers_sessions.client_type',
                                        DB::raw('SUM(transactions.amount) as total'))
                                ->where('client_type','=', '1')//only negocios
                                //->havingRaw('SUM(transactions.amount) ? <',[2500])
                                ->groupBy('transactions.branch_number')
                                ->get();
            Storage::append('archivo.txt', $destinataries);
            //sin seguro negocios
            //\Mail::send('emails.sinSeguroInvitacionSeguroDuenio15Mes', ['data' => $destinataries] , function($m) use ($destinataries){
            //    Storage::append('archivo.text', $destinataries[0]);
            //    $m->to($destinataries)->subject('Invitacion a Seguro Socio SyD');
            //});
        } catch (\Throwable $th) {
            $texto = $th;
            Storage::append('archivo.txt', $texto);

            throw $th;
        }

        Storage::append('archivo.txt', $texto);
    }
}
