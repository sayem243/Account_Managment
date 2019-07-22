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
    return view('welcome');



});

//Auth::routes();

Route::get('/index' ,'AccountController@index')->name('index');

Route::get('/create','AccountController@create')->name('create');
Route::get('/edit/{id}','AccountController@edit')->name('edit');
Route::post('account/store','AccountController@store')->name('account_store');
Route::post('/update/{id}' ,'AccountController@update')->name('update');
Route::get('/delete/{id}' ,'AccountController@delete')->name('delete');


//company route



Route::get('home', [
    'middleware' => 'auth',
    'uses' => 'HomeController@index'
]);



Route::get('/comp_profile' ,'CompanyController@index')->name('comp_profile');
Route::get('company/create','CompanyController@create')->name('comp_create');
Route::post('company/store','CompanyController@store')->name('company_store');
Route::get('/company/view/{id}' ,'CompanyController@view')->name('comp_view');



//projects route


Route::get('/project','ProjectController@index')->name('project');
Route::get('/project/create','ProjectController@create')->name('project_create');
Route::post('/project/store','ProjectController@store')->name('project_store');


//Settings route


Route::get('/setting','SettingsController@index')->name('setting');
Route::get('/setting/create','SettingsController@create')->name('setting_create');
Route::post('/setting/store','SettingsController@store')->name('setting_store');


//Payment route

Route::get('/payment','PaymentController@index')->name('payment');
Route::get('/payment/create','PaymentController@create')->name('payment_create');
Route::post('/payment/store','PaymentController@store')->name('payment_store');
Route::get('/payment/edit/{id}','PaymentController@edite')->name('payment_edit');
Route::post('/payment/update/{id}' ,'PaymentController@update')->name('payment_update');
Route::get('/payment/delete/{id}' ,'PaymentController@delete')->name('delete');


Route::get('/payment/print-pdf/{id}','PaymentController@printPDF')->name('printPDF');



//Admin route and Template

Route::get('/admin','AdminController@index')->name('admin_index');

Route::post('register', 'Auth\RegisterController@register')->name('register');
//UserType

Route::get('/usertype','UserTypeController@index')->name('usertype');
Route::get('/usertype/create','UserTypeController@create')->name('usertype_create');
Route::post('/usertype/store','UserTypeController@store')->name('usertype_store');


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//pdf controller




Route::get('/home', 'HomeController@index')->name('home');
