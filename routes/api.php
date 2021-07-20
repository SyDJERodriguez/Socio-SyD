<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::middleware('auth:api')->group(function (){
    Route::post('client_number/store',[\App\Http\Controllers\Api\CustomerController::class,'insert_client_number'])->name('client_number_insert');
    Route::get('registers_updated', [\App\Http\Controllers\Api\CustomerController::class,'get_clients_updated'])->name('get_registers_updated');
    Route::post('client/transactions',[\App\Http\Controllers\Api\TransactionsController::class,'insert_transaction'])->name('insert_transactions_clients');
	//Route::post('admin/customer/store','Admin\CustomerController@store');
	Route::get('customers',[\App\Http\Controllers\Api\CustomerController::class,'apiList'])->name('api.customer');
    //Route::post('customer/lead/register',[\App\Http\Controllers\CustomerController::class,'insert_lead'])->name('api.lead.register');
    Route::post('collector/customer/',[App\Http\Controllers\Api\CollectorCustomerController::class,'store'])->name('api.collector.customer.create');
    Route::post('testing',[\App\Http\Controllers\TestingController::class, 'test'])->name('api.testing');
});

//customers

Route::post('customer/stage/update','CustomerController@stage_update')->name('api.customer_stage.update');
Route::get('catalogs/cities','CollectorController@api_cities_by_state')->name('api.collector.catalog.cities');


//Vue routes



