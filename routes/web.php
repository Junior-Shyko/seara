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

// Home
Route::group(['prefix' => '/'], function(){
	Route::get('/', 'HomeController@index');
	Route::get('/datatable', 'HomeController@dataTable')->name('home.datatables');
});


// EMRPESAS
/* ROTA PARA EMPRESA */
Route::resource('companies', 'CompanyController');

Route::group(['prefix' => 'companies'], function () {
	Route::get('/{id}/edit' 		, 'CompanyController@edit');
    Route::put('/update/{id}' 		, 'CompanyController@update');
    Route::post('/alterar-status'	, 'CompanyController@alterStatus');
	Route::delete('/delete' 		, 'CompanyController@destroy');
	Route::post('/alterar-logo' 	, 'CompanyController@alterLogo');
});


// USUÁRIOS
Route::get('users/datatable', 'UserController@dataTable')->name('users.datatables');
Route::resource('users', 'UserController');
// Route::get('usuarios', 'UserController@anyData');

//ROTA PARA RECIBOS
Route::resource('receipt-company', 'ReceiptCompanyController');
Route::get('receipt-company/{receipt}/pdf', 'ReceiptCompanyController@generatePDF');

Route::get('recibo-empresa', 'ReceiptCompanyController@index');
Route::get('recibo-empresa/datatable', 'ReceiptCompanyController@anyData')->name('receipt-company.datatables');


//ROTA PARA CAIXA

Route::post('caixa/store' , 'BoxController@store');
Route::post('caixa/delete' , 'BoxController@destroy');
Route::get('caixa/saldo-inicial' , 'BoxController@balance_initial');
Route::resource('caixa' , 'BoxController');

Route::resource('conta' , 'AccountController');
//

// Route::controller('recibo-empresa', 'ReceiptDatatablesController', [
//     'anyData'  => 'datatables.data',
//     'getIndex' => 'recibo-empresa'
// ]);
