<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// CLIENTES
Route::get('clientes','clientesController@index')-> name('getAllindex');
Route::post('cliente','clientesController@add')-> name('addCliente');
Route::put('cliente/{id}','clientesController@update')-> name('updateCliente');


// ZONAS
Route::get('zonas','zonasController@getAll')-> name('getAllZonas');

// SUB ZONAS
Route::get('subzonas/{id}','subzonasController@SubzonaxZona')-> name('SubzonaxZona');

// CARTERAS
Route::get('carteras','carterasController@getAll')-> name('getAllCarteras');



