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


Route::get('/login', function () {
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


Route::get('/company/index','CompanyController@index')->name('comp_profile');
Route::get('/company/create','CompanyController@create')->name('comp_create');
Route::post('/company/store','CompanyController@store')->name('company_store');
Route::get('/company/view/{id}','CompanyController@view')->name('comp_view');
Route::get('/company/edit/{id}','CompanyController@edit')->name('comp_edit');
Route::post('/company/update/{id}','CompanyController@update')->name('comp_update');
Route::get('/company/delete/{id}','CompanyController@delete')->name('com_delete');
Route::get('/company/restore/{id}','CompanyController@companyRestore')->name('company_restore');

//projects route


Route::get('/project/index','ProjectController@index')->name('project');
Route::get('/project/create','ProjectController@create')->name('project_create');
Route::post('/project/store','ProjectController@store')->name('project_store');
Route::get('/project/edit/{id}' ,'ProjectController@edit')->name('project_edit');
Route::post('/project/update/{id}' ,'ProjectController@update')->name('project_update');
Route::get('/project/delete/{id}' ,'ProjectController@delete')->name('project_delete');
Route::get('/project/restore/{id}','ProjectController@projectRestore')->name('project_restore');

//Settings route


Route::get('/setting','SettingsController@index')->name('setting');
Route::get('/setting/create','SettingsController@create')->name('setting_create');
Route::post('/setting/store','SettingsController@store')->name('setting_store');


//Payment route

Route::get('/payment','PaymentController@index')->name('payment');
Route::get('/payment/create/','PaymentController@create')->name('payment_create');
Route::post('/payment/store','PaymentController@store')->name('payment_store');
Route::get('/payment/edit/{id}','PaymentController@edite')->name('payment_edit');
Route::get('/payment/draft/view','PaymentController@draftView')->name('payment_draft_view');
Route::post('/payment/draft/to/confirm','PaymentController@draftToConfirmStore')->name('payment_store_confirm');
Route::post('/payment/update/{id}','PaymentController@update')->name('payment_update');
Route::get('/payment/delete/{id}','PaymentController@delete')->name('delete');
Route::post('/payment/details/delete/{id}','PaymentDetailsController@deleteAjax')->name('delete_ajax');
Route::post('/payment/status/{id}','PaymentController@verify')->name('verify');
Route::post('/payment/status/unpark/{id}','PaymentController@unPark')->name('unpark');
Route::post('/payment/status/approve/{id}','PaymentController@approve')->name('danger');
Route::post('/payment/status/paid/{id}','PaymentController@payment_paid')->name('payment_paid');
Route::post('/payment/datatable', 'PaymentController@dataTable')->name('payment_datatable');

//Payment Settlement Route
Route::get('/settlement/list','PaymentSettlementController@index')->name('settlement_list');
Route::post('/settlement/payment/{id}','PaymentSettlementController@store')->name('settlement_store');
Route::post('/payment/settlement/datatable','PaymentSettlementController@dataTablePaymentSettlement')->name('settlement_datatable');

Route::post('/comments/payment/{id}','PaymentController@commentStore')->name('comments_store');
Route::post('/attachments/payment/{id}','PaymentController@paymentAttachmentStore')->name('payment_attachment_store');

//Payment Transferred Route
Route::post('/transferred/payment/{id}','PaymentTransferredController@store')->name('transferred_store');

//Ajax route

Route::get('/project/user/{id}','UserController@projectByUser')->name('user_project');
Route::get('/user/payment/{id}','UserController@vocherAmount')->name('vocher_amount');
Route::get('/user/payment/project/{id}','UserController@voucherProject')->name('voucher_project');
Route::get('/user/payment/paid/{payment}/{project}','UserController@paidAmount')->name('paid_amount');



Route::get('/payment/details/{id}','PaymentController@details')->name('details');
Route::get('/payment/details/delete/{id}','PaymentDetailsController@delete')->name('details_delete');
Route::get('/payment/print-pdf/{id}','PaymentController@paymentPDF')->name('printPDF');
Route::get('/payment/print/{id}','PaymentController@paymentPrint')->name('payment_print');
Route::get('/payment/quick/view/{id}','PaymentController@quickView')->name('payment_quick_view');
Route::post('/amendment/approved/{id}','PaymentDetailsController@approved')->name('amendment_approved');





//  amendmentPayment

Route::get('/amendment/','AmmendmentController@index')->name('amendment');
Route::get('/amendment/create/{id}','AmmendmentController@create')->name('amendment_create');
Route::post('/amendment/store/{id}','AmmendmentController@store')->name('amendment_store');
Route::get('/amendment/print-pdf/{id}','AmmendmentController@amendmentPDF')->name('amendment_printPDF');

//Route::get('/amendment/edit/{id}','AmmendmentController@edit')->name('amendment_edit');

//Route::get('/amendment/details/{id}','AmmendmentController@index')->name('details');



//Admin route and Template

Route::get('/','AdminController@index')->name('admin_index');
//Route::post('register', 'Auth\RegisterController@register')->name('register');
//UserType

Route::get('/usertype/index','UserTypeController@index')->name('usertype');
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
Route::get('/user/delete/{id}','UserController@delete')->name('User_delete');
Route::get('/user/restore/{id}','UserController@userRestore')->name('user_restore');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('password/change/{id}', 'UserController@passwordChange')->name('password-change');
Route::post('password/update/{id}', 'UserController@passwordUpdate')->name('password-update');

//pdf controller

//spaite

Route::group(['middleware' => ['auth']], function() {
    Route::resource('payments','PaymentController');
    Route::resource('users','UserController');
    Route::resource('payment-verify','PaymentController@verify');
    Route::resource('payment-approve','PaymentController@approve');
    Route::resource('payment-index','PaymentController@index');
    Route::resource('payment-edit','PaymentController@edite');
    Route::resource('payment-edit','PaymentDetailsController@deleteAjax');
    Route::resource('payment-delete','PaymentController@delete');
    Route::resource('payment-paid','PaymentController@payment_paid');

    Route::resource('payment-settlement-list','PaymentSettlementController@index');
    Route::resource('payment-settlement-create','PaymentSettlementController@store');


    Route::resource('vocher','VocherController');
    Route::resource('vocher','VocherController@approved');


   // Route::resource('register','UserController');
    Route::resource('projects','ProjectController');
    Route::resource('companies','CompanyController');
    Route::resource('roles','RoleController');
    //Rout::resource('')

});

//voucher

Route::post('/voucher/store','VoucherController@store')->name('voucher_store');
Route::get('/voucher/index','VoucherController@index')->name('voucher_index');
Route::post('/voucher/item/datatable', 'VoucherController@dataTable')->name('voucher_item_datatable');
Route::get('/voucher/draft/view','VoucherController@draftView')->name('voucher_draft_view');
Route::post('/voucher/draft/to/confirm','VoucherController@draftToConfirmStore')->name('voucher_store_confirm');

Route::get('/voucher/archived/index','VoucherController@archivedList')->name('voucher_archive_index');
Route::post('/voucher/archived/datatable', 'VoucherController@dataTableArchived')->name('voucher_archived_datatable');
Route::get('/voucher/item/remove/{id}','VoucherController@deleteVoucherItemAjax')->name('voucher_item_remove');
Route::get('/voucher/details/{id}','VoucherController@details')->name('voucher_details');
Route::get('/voucher/pdf/{id}','VoucherController@voucherPdf')->name('voucher_pdf');
Route::get('/voucher/print/{id}','VoucherController@voucherPrint')->name('voucher_print');
Route::get('/voucher/quick/view/{id}','VoucherController@quickView')->name('voucher_quick_view');
Route::get('/ajax/voucher/delete/{id}' ,'VoucherController@delete')->name('voucher_delete');

//Reports

Route::get('/reports/details/','ReportController@index')->name('report_index');



Route::get('/daterange', 'DateRangeController@index');
Route::Post('/daterange/fetch_data', 'DateRangeController@fetch_data')->name('daterange.fetch_data');


//testing for date filtering

Route::get('/reports/details/reports/','ReportController@reportDate')->name('report_try');
Route::get('/generate-pdf','PaymentDetailsController@generatePDF');

//ajax request section
Route::get('/ajax/project/company/{id}','AjaxFunctionController@getProjectsByCompany')->name('ajax_project_by_company_id');
Route::get('/ajax/user/project/{id}','AjaxFunctionController@getUsersByProject')->name('ajax_user_by_project_id');

Route::get('/number/to/word/convert/{text}','AjaxFunctionController@numberToWordConvert')->name('ajax_number_to_word_convert');

Route::get('/ajax/bank/{id}','AjaxFunctionController@getBranchByBank')->name('ajax_branch_by_bank_id');
Route::get('/ajax/company/bank/{id}','AjaxFunctionController@getBanksByCompany')->name('ajax_bank_by_company_id');
Route::get('/ajax/company/bank/branch/{cId}/{bId}','AjaxFunctionController@getBranchesByCompanyBank')->name('ajax_branch_by_company_bank');
Route::get('/ajax/company/bank/branch/account/{cId}/{bId}/{brId}','AjaxFunctionController@getAccountsByCompanyBankBranch')->name('ajax_branch_by_company_bank_branch');

Route::post('/ajax/add/voucher_item/','AjaxFunctionController@addVoucherItem')->name('ajax_add_voucher_item');

//report section

Route::get('/report/payment', 'ReportController@paymentReport')->name('payment_report');
Route::post('/report/payment/datatable', 'ReportController@dataTablePaymentReport')->name('payment_report_datatable');

//Expenditure Sector section
Route::get('/expenditure_sector/index','ExpenditureSectorController@index')->name('expenditure_sector_index');
Route::get('/expenditure_sector/create','ExpenditureSectorController@create')->name('expenditure_sector_create');
Route::post('/expenditure_sector/store','ExpenditureSectorController@store')->name('expenditure_sector_store');
Route::get('/expenditure_sector/edit/{id}','ExpenditureSectorController@edit')->name('expenditure_sector_edit');
Route::post('/expenditure_sector/update/{id}','ExpenditureSectorController@update')->name('expenditure_sector_update');
Route::get('/expenditure_sector/delete/{id}' ,'ExpenditureSectorController@destroy')->name('expenditure_sector_delete');

//Bank
Route::get('/bank/index','BankAndBranchController@indexBank')->name('bank_index');
Route::post('/bank/datatable','BankAndBranchController@dataTableBank')->name('bank_datatable');
Route::get('/bank/create','BankAndBranchController@createBank')->name('bank_create');
Route::post('/bank/store','BankAndBranchController@storeBank')->name('bank_store');
Route::get('/bank/edit/{id}','BankAndBranchController@editBank')->name('bank_edit');
Route::post('/bank/update/{id}','BankAndBranchController@updateBank')->name('bank_update');
Route::get('/bank/delete/{id}' ,'BankAndBranchController@deleteBank')->name('bank_delete');
Route::get('/bank/restore/{id}' ,'BankAndBranchController@bankRestore')->name('bank_restore');
//Branch
Route::get('/branch/index','BankAndBranchController@indexBranch')->name('branch_index');
Route::post('/branch/datatable','BankAndBranchController@dataTableBranch')->name('branch_datatable');
Route::get('/branch/create','BankAndBranchController@createBranch')->name('branch_create');
Route::post('/branch/store','BankAndBranchController@storeBranch')->name('branch_store');
Route::get('/branch/edit/{id}','BankAndBranchController@editBranch')->name('branch_edit');
Route::post('/branch/update/{id}','BankAndBranchController@updateBranch')->name('branch_update');
Route::get('/branch/delete/{id}' ,'BankAndBranchController@deleteBranch')->name('branch_delete');
Route::get('/branch/restore/{id}' ,'BankAndBranchController@branchRestore')->name('branch_restore');
//Bank account section
Route::get('/account/index','BankAccountController@index')->name('account_index');
Route::get('/account/create','BankAccountController@create')->name('account_create');
Route::post('/account/store','BankAccountController@store')->name('account_store');
Route::get('/account/edit/{id}','BankAccountController@edit')->name('account_edit');
Route::post('/account/update/{id}','BankAccountController@update')->name('account_update');
Route::post('/account/datatable','BankAccountController@dataTableAccount')->name('account_datatable');
Route::get('/account/delete/{id}' ,'BankAccountController@deleteAccount')->name('account_delete');
Route::get('/account/restore/{id}' ,'BankAccountController@accountRestore')->name('account_restore');


//Check Registry section
Route::get('/check/registry/index','CheckRegistryController@index')->name('check_registry_index');
Route::get('/check/registry/create','CheckRegistryController@create')->name('check_registry_create');
Route::post('/check/registry/store','CheckRegistryController@store')->name('check_registry_store');
Route::post('/check/registry/datatable','CheckRegistryController@dataTable')->name('check_registry_datatable');
Route::get('/check/registry/details/{id}','CheckRegistryController@details')->name('check_registry_details');
Route::get('/check/registry/quick/view/{id}','CheckRegistryController@quickView')->name('check_registry_quick_view');


Route::get('/daily/cash/balance','DailyCashBalanceController@dailyCashTransaction')->name('daily_cash_balance');

Route::get('/cash/daily/opening/balance/session/list','DailyCashBalanceSessionController@index')->name('opening_balance_session_list');
Route::post('/cash/daily/opening/balance/session/start/','DailyCashBalanceSessionController@generate')->name('opening_balance_start');
Route::get('/cash/daily/opening/balance/session/draft/view','DailyCashBalanceSessionController@draftView')->name('cash_balance_session_draft_view');
Route::post('/cash/daily/opening/balance/session/draft/to/confirm','DailyCashBalanceSessionController@draftToConfirmStore')->name('cash_balance_session_store_confirm');
Route::get('/cash/daily/session/quick/view','DailyCashBalanceSessionController@quickView')->name('cash_balance_session_quick_view');

Route::post('/cash/daily/closing/balance/session/update/','DailyCashBalanceSessionController@closingBalanceUpdate')->name('closing_balance_update');

//Loan and Income section
Route::get('/loanOrIncome/create','LoanIncomeController@createLoanAndIncome')->name('loan_income_create');
Route::post('/loan/check/store','LoanIncomeController@checkLoanStore')->name('check_loan_store');
Route::post('/loan/cash/store','LoanIncomeController@cashLoanStore')->name('cash_loan_store');
Route::post('/income/check/store','LoanIncomeController@checkIncomeStore')->name('check_income_store');
Route::post('/income/cash/store','LoanIncomeController@cashIncomeStore')->name('cash_income_store');
