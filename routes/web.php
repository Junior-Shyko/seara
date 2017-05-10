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

/* ROTA PARA EMPRESA */
Route::resource('companies', 'CompanyController');

/* ROTA PARA USUARIOS*/
Route::resource('users', 'UserController');

//ROTA PARA RECIBOS
Route::resource('receipt-company', 'ReceiptCompanyController');
Route::get('receipt-company/{receipt}/pdf', 'ReceiptCompanyController@generatePDF');

// DataTables
Route::get('recibo-empresa', 'ReceiptDatatablesController@getIndex');
Route::get('recibo-empresa/data', 'ReceiptDatatablesController@anyData')->name('datatables.data');

// Route::controller('recibo-empresa', 'ReceiptDatatablesController', [
//     'anyData'  => 'datatables.data',
//     'getIndex' => 'recibo-empresa'
// ]);
