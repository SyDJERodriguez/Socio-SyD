<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class ResetFlagSmsInsurance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:reset_flag_sms_insurance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This job is for reset the insurance flag to false in customers _sessions table';

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
        //Update method for put false value
        $reset = DB::table('customers_sessions')->update([
            'sms_insurance' => false,
            'silver_sms'    => false,
            'gold_sms'      => false
        ]);
    }
}
