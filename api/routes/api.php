<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return view('welcome');
});


//=================================== USUARIOS======================================================
Route::get('catusuarios'  ,'userController@getcatalogo')-> name('catusuarios');   
Route::get('usuarios'	    ,'userController@getAll')     -> name('getAllUsuarios');  			 //PROBADA
Route::post('usuarios'    ,'userController@add')        -> name('addUsuarios');    				 //PROBADA
Route::put('usuarios/{id}','userController@update')  		-> name('updateUsuarios');  			 //PROBADA
Route::delete('usuarios/{id}','userController@delete')   -> name('deleteUsuarios');  			 //PROBADA
Route::get('choferes'	    ,'userController@choferesAll') -> name('choferesAll');  		 //PROBADA

//=================================== VENDEDORES======================================================
Route::get('vendedores'		 ,'vendedoresController@vendedores')-> name('VendxSuc');  			 //PROBADA
Route::get('vendxsuc/{suc}','vendedoresController@vendxSuc')  -> name('VendxSuc');  			 //PROBADA

//==================================== CLIENTES=====================================================
Route::get('clientes','clientesController@catClientes') -> name('catClientes');            //PROBADA
Route::post('cliente','clientesController@add')         -> name('addCliente');             //PROBADA
Route::put('cliente/{id}','clientesController@update')  -> name('updateCliente');          //PROBADA

//==================================== PROVEDORES ==================================================
Route::get('catproveedores'  ,'proveedoresController@getcatalogo')-> name('getcatprov');   //PROBADA
Route::get('proveedores'     ,'proveedoresController@getAll') -> name('getAllproveedores');//PROBADA
Route::post('proveedores'    ,'proveedoresController@add')    -> name('addProveedor');     //PROBADA
Route::put('proveedores/{id}','proveedoresController@update') -> name('updateProveedor');  //PROBADA

//==================================== PRODUCTOS ===================================================
Route::get('catproductos'  ,'productosController@getcatalogo')-> name('getcatproducto');   //PROBADA
Route::get('productos'     ,'productosController@getAll') -> name('getAllproductos');  		 //PROBADA
Route::post('productos'    ,'productosController@add')    -> name('addProductos');     		 //PROBADA
Route::put('productos/{id}','productosController@update') -> name('updateProductos');  		 //PROBADA

//==================================== SUCURSALES ==================================================
Route::get('sucursales'	,'sucursalesController@getAll')			-> name('getAllSuc');         //PROBADA
Route::post('sucursales'		,'sucursalesController@add')    -> name('addsuc');         		//PROBADA
Route::put('sucursales/{id}','sucursalesController@update') -> name('updatesuc');      		//PROBADA

//==================================== ZONAS =======================================================
Route::get('zonas'			,'zonasController@getAll')     -> name('getAllZonas');             //PROBADA
Route::get('catzonas'		,'zonasController@getcatalogo')-> name('getcatalogo');             //PROBADA
Route::post('zonas'			,'zonasController@add')        -> name('addZonas');                //PROBADA
Route::put('zonas/{id}'	,'zonasController@update')   	 -> name('updateZonas');             //PROBADA

////================================== SUB ZONAS ===================================================
Route::get('subzonas/{id}','subzonasController@SubzonaxZona')-> name('SubzonaxZona');      //PROBADA

////================================== CARTERAS ====================================================
Route::get('carteras'     ,'carterasController@getAll') -> name('getAllCarteras');         //PROBADA
Route::post('carteras'    ,'carterasController@add')    -> name('addCartera');             //PROBADA
Route::put('carteras/{id}','carterasController@update') -> name('updateCartera');          //PROBADA

//==================================== CIUDADES ====================================================
Route::get('ciudades','ciudadesController@getAll')-> name('getAllCiudades');               //PROBADA

//==================================== MONEDAS =====================================================
Route::get('monedas'     ,'monedasController@getAll')     -> name('getAllmonedas');        //PROBADA
Route::post('monedas'    ,'monedasController@add')        -> name('addMoneda');            //PROBADA
Route::put('monedas/{id}','monedasController@update')     -> name('updateMoneda');         //PROBADA
Route::put('predeterminado/{id}', 'monedasController@predeterminado')  -> name('moneda_predeterminado');
Route::get('monedaPredeterminada','monedasController@getPredeterminada')->name('get_moneda_predeterminada');


//==================================== LINEAS ======================================================
Route::get('lineas'     ,'lineas_prodController@getAll') -> name('getAlllineas');          //PROBADA
Route::post('lineas'    ,'lineas_prodController@add')    -> name('addLineas');             //PROBADA
Route::put('lineas/{id}','lineas_prodController@update') -> name('updateLineas');          //PROBADA

//==================================== UNIDADES ====================================================
Route::get('unidades'     ,'unidadesController@getAll') -> name('getAllunidades');         //PROBADA
Route::post('unidades'    ,'unidadesController@add')    -> name('addUnidad');              //PROBADA
Route::put('unidades/{id}','unidadesController@update') -> name('updateUnidad');           //PROBADA

//==================================== PRECIOS =====================================================
Route::get('catprecios'  ,'preciosController@getcatalogo')-> name('getcatprecios');
Route::get('preciosxid/{id}' ,'preciosController@preciosxId') -> name('preciosxId');
Route::get('precios'     ,'preciosController@getAll') -> name('getAllprecios');
Route::post('precios'    ,'preciosController@add')    -> name('addPrecios');     
Route::put('precios/{id}','preciosController@update') -> name('updatePrecios'); 
Route::get('mp-productos','preciosController@mp_producto')-> name('get-mp_producto');
// SE USA PARA LA MODAL DE PRECIOS
Route::get('detalle_productos/{id}','preciosController@detalle_productos')-> name('getdetalle_productos');
Route::post('predeterminado', 'preciosController@predeterminado')  -> name('predeterminado');


////=============================== TIPOS PRECIOS ==================================================
Route::get('tipos-precios'     ,'tipo_precioController@getAll') -> name('getAllTipoPrecio');
Route::post('tipos-precios'    ,'tipo_precioController@add')    -> name('addTipoPrecio');
Route::put('tipos-precios/{id}','tipo_precioController@update') -> name('updateTipoPrecio');

////================================== CATEGORIAS ==================================================
Route::get('categorias'     ,'categoriasController@categorias') -> name('categorias');

////================================== COMPROMISOS ==================================================
Route::get('compromisos'     ,'compromisosController@Compromisos')   -> name('Compromisos');
Route::post('addcompromiso'  ,'compromisosController@addcompromiso') -> name('addcompromiso');
Route::put('putcompromiso/{id}'  ,'compromisosController@putcompromiso') -> name('putcompromiso');
Route::put('putcompromiso/{id}'  ,'compromisosController@putcompromiso') -> name('putcompromiso');
Route::post('fase.venta'  ,'compromisosController@FaseVenta') -> name('FaseVenta');

////================================== HISTORIAL ==================================================
Route::get('numero.orden/{id}' ,'histrorialController@NumerodeOrden') -> name('NumerodeOrden');
Route::get('ver.resumen/{id}' ,'histrorialController@VerResumen') -> name('VerResumen');
Route::post('historial' ,'histrorialController@Historial') -> name('Historial');
Route::post('historialxvend' ,'histrorialController@HistorialxVend') -> name('HistorialxVend');
Route::post('recotización' ,'histrorialController@Recotización') -> name('recotización');

////================================== ENTREGAS ==================================================
Route::post('entrega.producto' ,'entregasController@EntregarProducto') -> name('EntregarProducto');
Route::post('entrega.id','entregasController@entregabyid')-> name('Entregabyid');

//==================================== PROSPECTOS =====================================================
Route::get('prospectos' ,'prospectosController@Prospectos')     -> name('Prospectos');
Route::get('prospectos.id/{id}' ,'prospectosController@ProspectosxId')     -> name('ProspectosxId');
Route::post('add.prospecto','prospectosController@addProspecto')           -> name('addProspecto');
Route::put('update.prospecto/{id}','prospectosController@UpdateProspecto') -> name('UpdateProspecto');
Route::post('pasar.cliente','prospectosController@PasarACliente')           -> name('PasarACliente');
Route::delete('delete.prospecto/{id}','clientesController@EliminarProspecto')  -> name('EliminarProspecto'); 

Route::post('prueba','pruebasController@get')  -> name('get'); 
Route::get('prueba/{id}','pruebasController@getId')  -> name('getId'); 
Route::post('prueba.post','pruebasController@post')  -> name('post'); 
Route::put('prueba.put','pruebasController@put')  -> name('put'); 


















