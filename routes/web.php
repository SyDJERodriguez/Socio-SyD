<?php

/*Route::get('/testing', [\App\Http\Controllers\CustomerController::class,'getCustommersJSON'])->name('get_customers_json');
Route::get('/customer/{customer}', [\App\Http\Controllers\CustomerController::class,'getCustommerJSON'])->name('get_customer_json');*/
   //return view('ClientArea.Home.index');});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.estadoDeCuenta');
});
Route::get('customer/information','CustomerController@verify_client_number')->name('customer.information');
