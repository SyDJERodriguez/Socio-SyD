<?php

namespace App\Console\Commands;

use App\Helpers\Twilio\TwilioService;
use Illuminate\Console\Command;

class SmsTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a SMS test';

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
        $url = url('account/verify/000000001');
        $messsage = 'Bienvenido a Socio SYD, por favor verifica tu cuenta dando clic en el siguiente enlace: '.$url.'Desde el jon';
        return TwilioService::send_sms($messsage,'+529211400440');
    }
}
