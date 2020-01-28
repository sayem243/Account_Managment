<?php

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
    return view('auth.login');

});

//Auth::routes();

//Route::get('/index' ,'AccountController@index')->name('index');
//
//Route::get('/create','AccountController@create')->name('create');
//Route::get('/edit/{id}','AccountController@edit')->name('edit');
//Route::post('account/store','AccountController@store')->name('account_store');
//Route::post('/update/{id}' ,'AccountController@update')->name('update');
//Route::get('/delete/{id}','AccountController@delete')->name('delete');

//profile route
//Route::get('/userprofile/create','UserProfileController@create')->name('create');
Route::get('/userprofile/','UserProfileController@index')->name('userprofile');
ROute::get('/userprofile/show/{id}','UserProfileController@show')->name('userprofile_show');
Route::get('/userprofile/edit','UserProfileController@edit')->name('userprofile_edit');
Route::post('/userprofile/store','UserProfileController@store')->name('userprofile_store');

Route::get('/userprofile/update','UserProfileController@update')->name('userprofile_update');

//company route


Route::get('home', [
    'middleware' => 'auth',
    'uses' => 'HomeController@index'
]);


Route::get('/comp_profile','CompanyController@index')->name('comp_profile');
Route::get('company/create','CompanyController@create')->name('comp_create');
Route::post('company/store','CompanyController@store')->name('company_store');
Route::get('/company/view/{id}','CompanyController@view')->name('comp_view');
Route::get('/company/edit/{id}','CompanyController@edit')->name('comp_edit');
Route::post('/company/update/{id}','CompanyController@update')->name('comp_update');
Route::get('/company/delete/{id}','CompanyController@delete')->name('com_delete');


//projects route


Route::get('/project','ProjectController@index')->name('project');
Route::get('/project/create','ProjectController@create')->name('project_create');
Route::post('/project/store','ProjectController@store')->name('project_store');
Route::get('/project/edit/{id}' ,'ProjectController@edit')->name('project_edit');
Route::post('/project/update/{id}' ,'ProjectController@update')->name('project_update');
Route::get('/project/delete/{id}' ,'ProjectController@delete')->name('project_delete');

//Settings route


Route::get('/setting','SettingsController@index')->name('setting');
Route::get('/setting/create','SettingsController@create')->name('setting_create');
Route::post('/setting/store','SettingsController@store')->name('setting_store');


//Payment route

Route::get('/payment','PaymentController@index')->name('payment');
Route::get('/payment/create/','PaymentController@create')->name('payment_create');
Route::post('/payment/store','PaymentController@store')->name('payment_store');
Route::get('/payment/edit/{id}','PaymentController@edite')->name('payment_edit');
Route::post('/payment/update/{id}','PaymentController@update')->name('payment_update');
Route::get('/payment/delete/{id}','PaymentController@delete')->name('delete');
Route::post('/payment/status/{id}','PaymentController@verify')->name('verify');
Route::post('/payment/status/approve/{id}','PaymentController@approve')->name('danger');


//Ajax route

Route::get('/project/user/{id}','UserController@projectByUser')->name('user_project');
Route::get('/user/payment/{id}','UserController@vocherAmount')->name('vocher_amount');
Route::get('/user/payment/project/{id}','UserController@voucherProject')->name('voucher_project');
Route::get('/user/payment/paid/{payment}/{project}','UserController@paidAmount')->name('paid_amount');



Route::get('/payment/details/{id}','PaymentDetailsController@index')->name('details');
Route::get('/payment/details/delete/{id}','PaymentDetailsController@delete')->name('details_delete');
Route::get('/payment/print-pdf/{id}','PaymentDetailsController@paymentPDF')->name('printPDF');

Route::get('/payment/print/{id}','PaymentDetailsController@printpdf')->name('payment_print');


Route::post('/amendment/approved/{id}','PaymentDetailsController@approved')->name('amendment_approved');


//  amendmentPayment

Route::get('/amendment/','AmmendmentController@index')->name('amendment');
Route::get('/amendment/create/{id}','AmmendmentController@create')->name('amendment_create');
Route::post('/amendment/store/{id}','AmmendmentController@store')->name('amendment_store');



//Route::get('/amendment/details/{id}','AmmendmentController@index')->name('details');



//Admin route and Template

Route::get('/admin','AdminController@index')->name('admin_index');

//Route::post('register', 'Auth\RegisterController@register')->name('register');
//UserType

Route::get('/usertype','UserTypeController@index')->name('usertype');
Route::get('/usertype/create','UserTypeController@create')->name('usertype_create');
Route::post('/usertype/store','UserTypeController@store')->name('usertype_store');


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// Registration Routes...
Route::get('register', 'UserController@showRegistrationForm')->name('register');
Route::post('store', 'UserController@store')->name('store');
Route::get('/register/edit/{id}','UserController@userprofileEdit')->name('userprofileEdit');
Route::post('/register/update{id}','UserController@userprofileUpdate')->name('userprofileUpdate');
Route::get('delete/{id}','UserController@delete')->name('User_delete');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//pdf controller

//spaite

Route::group(['middleware' => ['auth']], function() {
    Route::resource('payments','PaymentController');
    Route::resource('users','UserController');
    Route::resource('verify','PaymentController@verify');
    Route::resource('approve','PaymentController@approve');
    Route::resource('vocher','VocherController');
    Route::resource('vocher','VocherController@approved');


   // Route::resource('register','UserController');
    Route::resource('projects','ProjectController');
    Route::resource('companies','CompanyController');
    Route::resource('roles','RoleController');
    //Rout::resource('')

});

//voucher

//Route::get('/Voucher/details/{id}','PaymentController@Voucher')->name('Voucher');

Route::get('/voucher/create/','VocherController@create')->name('voucher_create');
Route::post('/voucher/store','VocherController@store')->name('voucher_store');
Route::get('/voucher/index/','VocherController@index')->name('voucher_index');
Route::get('/voucher/edit/{id}','VocherController@edit')->name('voucher_edit');
Route::post('/voucher/update/{id}','VocherController@update')->name('voucher_update');

Route::Post('voucher/approved/{id}','VocherController@approved')->name('voucher_approved');

Route::get('/voucher/delete/{id}' ,'VocherController@delete')->name('voucher_delete');

//voucher details

Route::get('voucher/details/{id}','VocherDetailsController@index')->name('voucherDetails_index');
Route::get('/voucher/details/print-pdf/{id}','VocherDetailsController@printPDF')->name('voucher_printPDF');
Route::get('voucher/details/print/{id}','VocherDetailsController@prnpriview')->name('print');
Route::get('/voucher/details/delete/{id}','VocherDetailsController@delete')->name('voucherDetails_delete');

//Reports

Route::get('/reports/details/','ReportController@index')->name('report_index');



Route::get('/daterange', 'DateRangeController@index');
Route::Post('/daterange/fetch_data', 'DateRangeController@fetch_data')->name('daterange.fetch_data');


//testing for date filtering

Route::get('/reports/details/reports/','ReportController@reportDate')->name('report_try');
Route::get('/generate-pdf','PaymentDetailsController@generatePDF');
