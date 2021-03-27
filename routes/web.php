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

Route::get('/privacy', function(){
    return view('pages.noticePrivacy');
})->name('noticePrivacy');

Route::post('/contact_us','CustomerController@contact_us');

//Password functions
Route::get('/send_restore_password', 'CustomerController@send_restore_password')->name('send.restore.password');
Route::get('password/edit/{client_number}', 'CustomerController@edit_password')->name('edit.password');
Route::put('customer/update/password', 'CustomerController@update_password')->name('update.password');

//Account functions
Route::get('/send_activate_account', 'CustomerController@send_activate_account')->name('send.activate.account');
Route::get('account/activate/{client_number}', 'CustomerController@edit_account')->name('edit.account');
Route::put('account/update/password', 'CustomerController@update_account')->name('update.account');
Route::get('account/verify/{client_number}', 'CustomerController@verify_account')->name('verify.account');
Route::get('account/verify/{client_number}/{mobile_number}', 'CustomerController@verify_associate')->name('verify.associate');

//CNT functions
Route::put('/registerCNT', 'CustomerController@cntRegister')->name('cnt.register');
Route::get('/registerCNTNumbers', 'CustomerController@insertCNTNumber')->name('cnt.numbers');



Route::prefix('customer')->name('customer.')->group(function(){
    //Register's URLs
    Route::get('/information','CustomerController@verify_client_number')->name('information');
    Route::put('/update', 'CustomerController@update')->name('update');
    Route::post('/login', 'CustomerController@login')->name('login');
    Route::put('/addEmployee', 'CustomerController@addEmployee')->name('addEmployee');
    Route::get('/dismiss/{client_number}','CustomerController@dismissNotification')->name('dismissNotification');


//Account URLs
    Route::group(['middleware' => ['auth:customer']], function() {

        Route::get('/home', 'CustomerController@home')->name('home');

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
        Route::get('/employees/{id}', 'CustomerController@editEmployee');
        Route::post('/employees/update', 'CustomerController@updateEmployee')->name('updateEmployee');
        Route::get('/employees/{id}/delete', 'CustomerController@deleteEmployee')->name('deleteEmployee');
        Route::get('/pdf','BeneficiaryController@generatePDF')->name('pdf');

        //Logout
        Route::post('/logout', 'CustomerController@logout')->name('logout');

        //Deactivate
        Route::put('/delete', 'CustomerController@deactivate_account')->name('deactivate');
        
    });
});
