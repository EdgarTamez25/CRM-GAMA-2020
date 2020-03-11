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

// USUARIOS

// CLIENTES
Route::get('clientes','clientesController@index')       -> name('getAllindex');        //PROBADA
Route::post('cliente','clientesController@add')         -> name('addCliente');         //PROBADA
Route::put('cliente/{id}','clientesController@update')  -> name('updateCliente');      //PROBADA

// ZONAS
Route::get('zonas','zonasController@getAll')        -> name('getAllZonas');            //PROBADA
Route::get('catzonas','zonasController@getcatalogo')-> name('getcatalogo');            //PROBADA
Route::post('zonas','zonasController@add')          -> name('addZonas');               //PROBADA
Route::put('zonas/{id}','zonasController@update')   -> name('updateZonas');            //PROBADA

// SUB ZONAS
Route::get('subzonas/{id}','subzonasController@SubzonaxZona')-> name('SubzonaxZona');   //PROBADA

// CARTERAS
Route::get('carteras'     ,'carterasController@getAll')     -> name('getAllCarteras');  //PROBADA
Route::post('carteras'    ,'carterasController@add')        -> name('addCartera');      //PROBADA
Route::put('carteras/{id}','carterasController@update')     -> name('updateCartera');   //PROBADA

// CIUDADES
Route::get('ciudades','ciudadesController@getAll')-> name('getAllCiudades');            //PROBADA

// MONEDAS
Route::get('monedas'     ,'monedasController@getAll')     -> name('getAllmonedas');  //PROBADA
Route::post('monedas'    ,'monedasController@add')        -> name('addMoneda');      //PROBADA
Route::put('monedas/{id}','monedasController@update')     -> name('updateMoneda');   //PROBADA


