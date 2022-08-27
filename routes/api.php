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
    /***************** Webservices BI *****************/
    Route::get('get_registered_clients',[\App\Http\Controllers\Api\CustomerController::class,'get_registered_clients'])->name('get.registered.clients');
    Route::post('save_typeform_survey',[\App\Http\Controllers\Api\CustomerController::class,'save_survey_typeform'])->name('save.typeform.survey');


    /***************** To Send Certificates *****************/
    Route::get('send_certificate', [\App\Http\Controllers\Api\CustomerController::class,'send_sms_certificate'])->name('send.sms.certificate');

    /***************** To Save Register of Ecommerce *****************/
    Route::post('insert_customer', [\App\Http\Controllers\Api\CustomerController::class,'store'])->name('save.customer');

    /*********************** GET insurance certificate *********************/
    Route::get('get_certificates', [\App\Http\Controllers\Api\CustomerController::class,'get_certificates'])->name('send.sms.certificate');

    /*********************** Webservices SAP *********************/
    Route::post('client_number/store',[\App\Http\Controllers\Api\CustomerController::class,'insert_client_number'])->name('client_number_insert');
    Route::get('registers_updated', [\App\Http\Controllers\Api\CustomerController::class,'get_clients_updated'])->name('get_registers_updated');
    Route::post('client/transactions',[\App\Http\Controllers\Api\TransactionsController::class,'insert_transaction'])->name('insert_transactions_clients');
});
