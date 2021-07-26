<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class InsertLogController extends Controller
{   
    public function insert (){
        $now = Carbon::now();
    $user = Auth::user();
    $nowDate = $now->format('Y-m-d');
    $nowTime = $now->format('H:m:s');
    $insert_log = DB::table('log_sessions_cat')->insert([
        'user' => $user->email,
        'name' => $user->name,
        'date' => $nowDate,
        'time' => $nowTime

    ]);
    return redirect()->route('admin.customers.index');
    }
    public function logSessions () {


        $logSessions = DB::table('log_sessions_cat')
        ->get();

    return view('Admin.logSessions', compact('logSessions'));

    }


}