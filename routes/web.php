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

Route::resource('lancar' , 'EntryController');
//

// Route::controller('recibo-empresa', 'ReceiptDatatablesController', [
//     'anyData'  => 'datatables.data',
//     'getIndex' => 'recibo-empresa'
// ]);
