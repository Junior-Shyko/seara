<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('seed/{seed}', 'SeedController');

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

// Cadastro
Route::get('/cadastro', 'SignUpController@index');
Route::post('/cadastro', 'SignUpController@signup');
Route::post('/cadastro/checkCNPJ', 'SignUpController@checkCNPJ');
Route::get('/cnpj/autocomplete/{cnpj}', 'CompanyController@getCompanyData');

// Home
Route::group(['prefix' => '/'], function(){
	Route::get('/', 'HomeController@index');
	Route::get('/datatable', 'HomeController@dataTable')->name('home.datatables');
});


// EMRPESAS
/* ROTA PARA EMPRESA */

Route::group(['prefix' => 'companies'], function () {
    Route::post('alterar-status'	, 'CompanyController@alterStatus');
	Route::post('alterar-logo' 	, 'CompanyController@alterLogo');
	Route::get('dataTable', 'CompanyController@dataTable');
});

Route::resource('companies', 'CompanyController');

// USUÁRIOS
Route::get('users/datatable', 'UserController@dataTable')->name('users.datatables');
Route::resource('users', 'UserController');
// Route::get('usuarios', 'UserController@anyData');

//ROTA PARA RECIBOS - Empresa
Route::get('recibo-empresa', 'ReceiptCompanyController@index');
Route::get('recibo-empresa/datatable', 'ReceiptCompanyController@anyData');

Route::get('receipt-company/{receipt}/pdf', 'ReceiptCompanyController@generatePDF');
Route::get('receipt-company/settings', 'ReceiptCompanyController@getReceiptSettings');
Route::post('receipt-company/settings', 'ReceiptCompanyController@storeReceiptSettings');

Route::resource('receipt-company', 'ReceiptCompanyController');

// Recibo - Comum
Route::get('recibo-comum/{receipt}/pdf', 'ReceiptCommonController@generatePDF');
Route::get('recibo-comum', 'ReceiptCommonController@index');
Route::get('recibo-comum/dataTable', 'ReceiptCommonController@dataTable');

Route::resource('receipt-common', 'ReceiptCommonController');


//ROTA PARA CAIXA

Route::post('caixa/store' , 'BoxController@store');
Route::post('caixa/delete' , 'BoxController@destroy');
Route::get('caixa/saldo-inicial' , 'BoxController@balance_initial');
Route::get('caixa/abrir-caixa' , 'BoxController@box_open');

Route::resource('caixa' , 'BoxController');
Route::post('abrir-caixa' , 'BoxController@open_box');
Route::post('fechar-caixa' , 'BoxController@close_box');

Route::get('conta/dataTable', 'AccountController@dataTable');
Route::resource('conta' , 'AccountController');

Route::resource('tipo-conta', 'AccountTypeController');
Route::resource('lancar' , 'EntryController');
Route::post('caixa/upload' , 'EntryController@upload');
Route::get('all-launch', 'EntryController@getAll');
Route::post('lancar/delete' , 'EntryController@destroy');
// PARA LANÇAMENTO DE CONTAS DO MOVIMENTO DO CAIXA
Route::group(['prefix' => 'launch'], function () {
    Route::get('account'	, 'AccountLaunchController@index');
    Route::post('account/create', 'AccountLaunchController@store');
    Route::get('account/all' , 'AccountLaunchController@getDataTable');
    Route::put('account/{id}' , 'AccountLaunchController@update');
    Route::post('account/delete' , 'AccountLaunchController@destroy');
    Route::get('account/search/{id}' , 'AccountLaunchController@search');

});


// Categoria de receitas
Route::get('categoria-receita', 'Financing\IncomeCategoryController@index');
Route::get('income-category/dataTable', 'Financing\IncomeCategoryController@dataTable');
Route::resource('income-category', 'Financing\IncomeCategoryController', [
    'only' => ['store', 'update', 'destroy', 'show']
]);

// Contas a receber
Route::get('contas-a-receber', 'Financing\ReceivableController@index');
Route::get('receivable/dataTable', 'Financing\ReceivableController@dataTable');
Route::put('receivable/payment/{id}', 'Financing\ReceivableController@payReceivable');
Route::put('receivable/{id}/receipt', 'Financing\ReceivableController@generateReceipt');
Route::resource('receivable', 'Financing\ReceivableController',[
    'only' => ['store', 'update', 'destroy', 'show']
]);

// Relatórios
Route::get('relatorio/dividas-e-pagamentos', 'Report\DebtAndPaymentController@index');
Route::post('report/debt-and-payment', 'Report\DebtAndPaymentController@generateReport');

// Pagamentos
Route::get('pagamentos', 'Financing\PaymentController@index');
Route::get('payment/dataTable', 'Financing\PaymentController@dataTable');
Route::resource('payment', 'Financing\PaymentController', [
    'only' => ['show', 'update', 'destroy']
]);
