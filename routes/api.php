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
});
