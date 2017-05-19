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
Route::get('/', 'HomeController@index');
Route::get('/cadastro', 'SignUpController@index');
Route::post('/cadastro', 'SignUpController@signup');

// EMRPESAS
/* ROTA PARA EMPRESA */
Route::resource('companies', 'CompanyController');

// USUÁRIOS
Route::get('users/datatable', 'UserController@dataTable')->name('users.datatables');
Route::resource('users', 'UserController');
// Route::get('usuarios', 'UserController@anyData');

//ROTA PARA RECIBOS
Route::resource('receipt-company', 'ReceiptCompanyController');
Route::get('receipt-company/{receipt}/pdf', 'ReceiptCompanyController@generatePDF');

Route::get('recibo-empresa', 'ReceiptCompanyController@index');
Route::get('recibo-empresa/datatable', 'ReceiptCompanyController@anyData')->name('receipt-company.datatables');

//

// Route::controller('recibo-empresa', 'ReceiptDatatablesController', [
//     'anyData'  => 'datatables.data',
//     'getIndex' => 'recibo-empresa'
// ]);
