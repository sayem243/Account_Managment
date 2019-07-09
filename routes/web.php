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

Route::get('/comp_profile' ,'CompanyController@index')->name('comp_profile');
Route::get('company/create','CompanyController@create')->name('comp_create');
Route::post('company/store','CompanyController@store')->name('company_store');
Route::get('/company/view/{id}' ,'CompanyController@view')->name('comp_view');



//projects route


Route::get('/project','ProjectController@index')->name('project');
