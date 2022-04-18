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
    $branches = DB::table('branches')
                ->orderBy('name','ASC')
                ->get();
    $popup= false;

return view('pages.home', compact('branches','popup'));
})->name('home');

Route::get('/privacy', function(){
    return view('pages.noticePrivacy');
})->name('noticePrivacy');



Route::post('/contact_us','CustomerController@contact_us');
Route::get('/register/beneficiariebranch/{email}', 'CustomerController@employeesbranch')->name('employeesbranch');
Route::get('/addsuccess', function () {
      return view('pages.success');
})->name('addsuccess');
Route::put('/addEmployeebranch', 'CustomerController@addEmployeebranch')->name('addEmployeebranch');
//Route::post('/add_beneficiariebranch', 'BeneficiaryController@addBeneficiariebranch')->name('add.beneficiariebranch'

// Routes without login
/**  Download PDF by SMS **/
Route::get('/sms_pdf/{client_number}/{branch_number}', 'BeneficiaryController@generatePDFSMS')->name('sms.generate.pdf');
Route::get('/pdf/{email}/', 'BeneficiaryController@generatePDFEmail')->name('email.generate.pdf');
Route::get('/register/beneficiaries/{email}', function ($email){
    $data = DB::table('customer_platforms')->where('email', $email)->first();
    $data_session = DB::table('customers_sessions')->where('email', $email)->first();

    $client_number = $data_session->client_number;
    $branch_number = $data_session->branch_number;
    $beneficiaries = DB::table('beneficiaries')
        ->where('customer_id','=', $data->id)
        ->get();
    $beneficiaries = json_decode($beneficiaries);
    $beneficiary = (array)$beneficiaries;//convert to array

    if($beneficiary){
        return view('pages.registerBeneficiaries', compact('data', 'beneficiary', 'client_number', 'branch_number'));
    }

    return view('pages.registerBeneficiaries', ['email' => $email, 'branch_number' => $branch_number]);
})->name('register.beneficiaries');
Route::post('/add_beneficiaries', 'BeneficiaryController@addBeneficiaries')->name('add.beneficiaries');

//Password functions
Route::get('/send_restore_password', 'CustomerController@send_restore_password')->name('send.restore.password');
Route::get('password/edit/{client_number}', 'CustomerController@edit_password')->name('edit.password');
Route::put('customer/update/password', 'CustomerController@update_password')->name('update.password');
Route::get('/invitation/{client_number}/{mobile_number}', 'CustomerController@invitationForm')->name('invitationForm');
Route::post('/invitation/send','CustomerController@signUpInvitation')->name('signUpInvitation');

//Account functions
Route::get('/send_activate_account', 'CustomerController@send_activate_account')->name('send.activate.account');
Route::get('account/activate/{client_number}', 'CustomerController@edit_account')->name('edit.account');
Route::put('account/update/password', 'CustomerController@update_account')->name('update.account');
Route::get('account/verify/{client_number}', 'CustomerController@verify_account')->name('verify.account');
Route::get('account/verify/invitation/{email}', 'CustomerController@verify_invitation')->name('verify.invitation');
Route::get('account/verify/{client_number}/{mobile_number}', 'CustomerController@verify_associate')->name('verify.associate');

//CNT functions
Route::post('/registerCNT', 'CustomerController@cntRegister')->name('cnt.register');
Route::get('/registerCNTNumbers', 'CustomerController@insertCNTNumber')->name('cnt.numbers');

//Change mechanic to employee
Route::get('/mechanic_to_dependent/{array}', 'CustomerController@convertMechanicToDependentByEmail')->name('update.mechanic.dependent');


Route::prefix('customer')->name('customer.')->group(function(){
    //Register's URLs
    Route::get('/information','CustomerController@verify_client_number')->name('information');
    Route::get('/branchInformation','CustomerController@verify_client_branch')->name('branchInformation');
    Route::put('/update', 'CustomerController@update')->name('update');
    Route::put('/updateCadena', 'CustomerController@updateCadena')->name('updateCadena');
    Route::put('/update/data', 'CustomerController@updateData')->name('updateData');
    Route::post('/forgotClientNumber', 'CustomerController@forgotClientNumber')->name('forgotClientNumber');
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
        Route::get('/employees/{id}/{email}/delete', 'CustomerController@deleteEmployee')->name('deleteEmployee');
        Route::get('/pdf', 'BeneficiaryController@generatePDF')->name('pdf');

        //Logout
        Route::post('/logout', 'CustomerController@logout')->name('logout');

        //Deactivate
        Route::post('/delete', 'CustomerController@deactivate_account')->name('deactivate');

        //Change employee to mechanic
        Route::put('/upEmployee', 'CustomerController@employeeToMechanic')->name('update.employee');

    });
});

//CAT
Route::prefix('admin')->name('admin.')->group(function (){
    Route::get('/login','Admin\LoginController@showLoginForm')->name('login_form');
    Route::post('/login','Admin\LoginController@login')->name('login');
    Route::get('/register', 'Admin\LoginController@showRegisterForm')->name('register.form');
    Route::post('/register', 'Auth\RegisterController@register')->name('register');
    Route::group(['middleware' => ['auth:admin']], function() {
        Route::get('/total_registers', 'Admin\AdminController@total_registers')->name('total.registers');
        Route::get('/insert', 'Admin\InsertLogController@insert')->name('insertLog');
        Route::get('/logSesiones', 'Admin\InsertLogController@logSessions')->name('consultLogSessions');
        Route::get('/logBusquedas', 'Admin\InsertLogController@logSearches')->name('consultLogSearches');
        Route::get('/index', 'Admin\AdminController@index')->name('customers.index');
        Route::get('/client_number', 'Admin\AdminController@search_by_number')->name('search.client.number');
        Route::get('/email', 'Admin\AdminController@search_by_email')->name('search.email');
        Route::get('/branch', 'Admin\AdminController@search_by_branch')->name('search.branch');
        Route::get('/{id}', 'Admin\AdminController@search_dependent')->name('search.dependent');

        
        Route::post('/logout', 'Admin\LoginController@logout')->name('logout');
    });
    
});

Route::group(['middleware' => ['auth:admin']], function() {
Route::get('/searchBeneficiary', 'Admin\SearchBeneficiaryController@index')->name('beneficiary.index');
Route::get('/BeneficiaryClient_number', 'Admin\SearchBeneficiaryController@search_by_number')->name('beneficiary.search.client.number');
Route::get('/BeneficiaryEmail', 'Admin\SearchBeneficiaryController@search_by_email')->name('beneficiary.search.email');
Route::get('/BeneficiaryBranch', 'Admin\SearchBeneficiaryController@search_by_branch')->name('search.branchBeneficiary');
Route::post('add/beneficiaries', 'Admin\CustomerBeneficiaryController@add_beneficiaries')->name('beneficiary.add');
});
//Reports for Telasist and Chubb
Route::get('telasist_report', [\App\Http\Controllers\Api\CustomerController::class,'report_telasist'])->name('report_telasist');
Route::get('/chubb_report', [\App\Http\Controllers\Api\CustomerController::class,'chubb_report'])->name('chubb_report');
Route::get('/send_sms_verification/{mobile}', 'CustomerController@sms_verification')->name('send.sms.verification');


//Reports analytics
Route::get('daily_report', [\App\Http\Controllers\Api\CustomerController::class,'daily_report'])->name('daily_report');
Route::get('benefits_report', [\App\Http\Controllers\Api\CustomerController::class,'without_benefits_report'])->name('benefits_report');
Route::get('beneficiaries_report', [\App\Http\Controllers\Api\CustomerController::class,'beneficiaries_report'])->name('beneficiaries_report');
Route::get('sales_monthly', [\App\Http\Controllers\Api\CustomerController::class,'sales_monthly'])->name('sales_monthly');
