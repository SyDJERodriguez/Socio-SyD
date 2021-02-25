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
    return view('pages.home');
})->name('home');

Route::post('/contact_us','CustomerController@contact_us');
Route::get('/send_restore_password', 'CustomerController@send_restore_password')->name('send.restore.password');
Route::get('password/edit/{client_number}', 'CustomerController@edit_password')->name('edit.password');
Route::put('customer/update/password', 'CustomerController@update_password')->name('update.password');

Route::prefix('customer')->name('customer.')->group(function(){
    //Register's URLs
    Route::get('/information','CustomerController@verify_client_number')->name('information');
    Route::put('/update', 'CustomerController@update')->name('update');
    Route::post('/login', 'CustomerController@login')->name('login');
    Route::put('/addEmployee', 'CustomerController@addEmployee')->name('addEmployee');


//Account URLs
    Route::group(['middleware' => ['auth:customer']], function() {

        //My Account
        Route::get('/account/', 'CustomerController@account_status')->name('myAccount');

        //My Documents
        Route::get('/documents/', 'CustomerController@my_documents')->name('myDocuments');

        //Benefits
        Route::get('benefits/', 'CustomerController@benefits')->name('benefits');
        Route::get('/benefits/beneficiary/', 'CustomerController@register_beneficiary')->name('register.beneficiary');
        Route::get('benefits/signature/', 'CustomerController@benefits_signature')->name('benefits.signature');
        Route::get('benefits/assistance/', 'CustomerController@benefits_assistance')->name('benefits.assistance');
        Route::post('benefits/add/beneficiaries', 'BeneficiaryController@add_beneficiaries')->name('benefits.add.beneficiary');
        Route::post('benefits/signature/efirm', 'CustomerController@efirm')->name('efirm');

        //Beneficiaries
        Route::get('/employees/', 'CustomerController@employees')->name('employees');
        Route::get('/employees/{emp}', 'CustomerController@editEmployees');
        Route::post('/employees/update', 'CustomerController@updateEmployee')->name('updateEmployee');

        //Logout
        Route::post('/logout', 'CustomerController@logout')->name('logout');
        
    });
});
