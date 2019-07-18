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


//Admin route and Template

ROute::get('/admin','AdminController@index')->name('admin_index');


//UserType
ROute::get('/usertype','UserTypeController@index')->name('usertype');







Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
