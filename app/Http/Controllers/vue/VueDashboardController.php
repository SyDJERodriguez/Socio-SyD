<?php


namespace App\Http\Controllers\vue;


use App\Customer;

class VueDashboardController
{
    public function getTotalDB(){
        $db        = Customer::count();
        $club_dar  = Customer::where('customer_level',3)->count();
        $leads     = Customer::where('customer_level',1)->count();
        $clients   = Customer::where('customer_level',2)->count();
        $historic  = Customer::where('source','historic')->count();

        return response()->json(['code'=>1, 'totals'=>compact('db','club_dar','leads','historic','clients')]);
    }
}
