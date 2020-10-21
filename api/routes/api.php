<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return view('welcome');
});

Route::post('login'          ,'userController@IniciarSesion')           -> name('IniciarSesion');
Route::post('login.permisos' ,'userController@SesionPermisos')  	    -> name('SesionPermisos');
Route::get('gama.etiquetas'  ,'gamaEtiquetasController@modulosActivos') -> name('modulosActivos');   

//===================================  USUARIOS ====================================================
	Route::get('catusuarios'     ,'userController@getcatalogo') -> name('getcatalogo');   
	Route::get('usuarios'	       ,'userController@getAll')      -> name('getAllUsuarios');  
	Route::post('usuarios'       ,'userController@add')         -> name('addUsuarios');    	
	Route::put('usuarios/{id}'   ,'userController@update')  	  -> name('updateUsuarios');  
	Route::delete('usuarios/{id}','userController@delete')      -> name('deleteUsuarios');  
	Route::get('choferes'	       ,'userController@choferesAll') -> name('choferesAll');  	
	Route::post('estatus.user'   ,'userController@estatusUser') -> name('estatusUser');    	

//===================================  VENDEDORES===================================================
	Route::get('vendedores'		  ,'vendedoresController@vendedores') -> name('vendedores');  	 
	Route::get('vendxsuc/{suc}' ,'vendedoresController@vendxSuc')   -> name('vendxSuc');  	 

//==================================== CLIENTES ====================================================
	Route::get('clientes'         ,'clientesController@catClientes')      -> name('catClientes');            
	Route::get('clientes.selector','clientesController@clientesSelector') -> name('clientesSelector'); 
	Route::post('cliente'         ,'clientesController@add')              -> name('addCliente');             
	Route::put('cliente/{id}'     ,'clientesController@update')           -> name('updateCliente');          
	Route::post('cambia.estatus'  ,'clientesController@cambiaEstatus')    -> name('cambiaEstatus'); 

//==================================== PROVEDORES ==================================================
	Route::get('catproveedores'   ,'proveedoresController@getcatalogo')     -> name('getcatprov');   
	Route::get('proveedores'      ,'proveedoresController@getAll')          -> name('getAllproveedores');
	Route::post('proveedores'     ,'proveedoresController@add')             -> name('addProveedor');     
	Route::put('proveedores/{id}' ,'proveedoresController@update')          -> name('updateProveedor');  
	Route::post('cambia.estatus.p','proveedoresController@cambiaEstatusP')  -> name('cambiaEstatusP'); 

//==================================== PRODUCTOS ===================================================
	Route::get('catproductos'      ,'productosController@getcatalogo')    -> name('getcatproducto');   
	Route::get('productosxId/{id}' ,'productosController@getcatalogoxId') -> name('getcatalogoxId');   
	Route::get('productos'         ,'productosController@getAll')         -> name('getAllproductos');  		 
	Route::post('productos'        ,'productosController@add')            -> name('addProductos');     		 
	Route::put('productos/{id}'    ,'productosController@update')         -> name('updateProductos');  		 
//==================================== SUCURSALES ==================================================
	Route::get('sucursales'	    ,'sucursalesController@getAll')	-> name('getAllSuc');         
	Route::post('sucursales'		,'sucursalesController@add')     -> name('addsuc');         		
	Route::put('sucursales/{id}','sucursalesController@update')  -> name('updatesuc');      		
//==================================== ZONAS =======================================================
	Route::get('zonas'			,'zonasController@getAll')     -> name('getAllZonas');             
	Route::get('catzonas'		,'zonasController@getcatalogo')-> name('getcatalogo');             
	Route::post('zonas'			,'zonasController@add')        -> name('addZonas');                
	Route::put('zonas/{id}'	,'zonasController@update')   	 -> name('updateZonas');             
////================================== SUB ZONAS ===================================================
	Route::get('subzonas/{id}','subzonasController@SubzonaxZona')-> name('SubzonaxZona');      
////================================== CARTERAS ====================================================
	Route::get('carteras'     ,'carterasController@getAll') -> name('getAllCarteras');         
	Route::post('carteras'    ,'carterasController@add')    -> name('addCartera');             
	Route::put('carteras/{id}','carterasController@update') -> name('updateCartera');          
//==================================== CIUDADES ====================================================
	Route::get('ciudades','ciudadesController@getAll')-> name('getAllCiudades');               
//==================================== MONEDAS =====================================================
	Route::get('monedas'             ,'monedasController@getAll')           -> name('getAllmonedas');        
	Route::post('monedas'            ,'monedasController@add')              -> name('addMoneda');            
	Route::put('monedas/{id}'        ,'monedasController@update')           -> name('updateMoneda');         
	Route::put('predeterminado/{id}' , 'monedasController@predeterminado')  -> name('moneda_predeterminado');
	Route::get('monedaPredeterminada','monedasController@getPredeterminada')-> name('get_moneda_predeterminada');
//==================================== LINEAS ======================================================
	Route::get('lineas'     ,'lineas_prodController@getAll') -> name('getAlllineas');          
	Route::post('lineas'    ,'lineas_prodController@add')    -> name('addLineas');             
	Route::put('lineas/{id}','lineas_prodController@update') -> name('updateLineas');          
//==================================== UNIDADES ====================================================
	Route::get('unidades'     ,'unidadesController@getAll') -> name('getAllunidades');         
	Route::post('unidades'    ,'unidadesController@add')    -> name('addUnidad');              
	Route::put('unidades/{id}','unidadesController@update') -> name('updateUnidad');           
//==================================== PRECIOS =====================================================
	Route::get('catprecios'      ,'preciosController@getcatalogo')     -> name('getcatprecios');
	Route::get('preciosxid/{id}' ,'preciosController@preciosxId')      -> name('preciosxId');
	Route::get('precios'         ,'preciosController@getAll')          -> name('getAllprecios');
	Route::post('precios'        ,'preciosController@add')             -> name('addPrecios');     
	Route::put('precios/{id}'    ,'preciosController@update')          -> name('updatePrecios'); 
	Route::get('mp-productos'    ,'preciosController@mp_producto')     -> name('get-mp_producto');
// SE USA PARA LA MODAL DE PRECIOS
	Route::get('detalle_productos/{id}','preciosController@detalle_productos')-> name('getdetalle_productos');
	Route::post('predeterminado'       , 'preciosController@predeterminado')  -> name('predeterminado');
////================================== TIPOS PRECIOS ===============================================
	Route::get('tipos-precios'     ,'tipo_precioController@getAll') -> name('getAllTipoPrecio');
	Route::post('tipos-precios'    ,'tipo_precioController@add')    -> name('addTipoPrecio');
	Route::put('tipos-precios/{id}','tipo_precioController@update') -> name('updateTipoPrecio');
////================================== CATEGORIAS ==================================================
	Route::get('categorias','categoriasController@categorias') -> name('categorias');
////================================== COMPROMISOS =================================================
	Route::get('compromisos/{nivel}' ,'compromisosController@Compromisos')   -> name('Compromisos');
	Route::post('addcompromiso'      ,'compromisosController@addcompromiso') -> name('addcompromiso');
	Route::put('putcompromiso/{id}'  ,'compromisosController@putcompromiso') -> name('putcompromiso');
	Route::put('putcompromiso/{id}'  ,'compromisosController@putcompromiso') -> name('putcompromiso');
	Route::post('fase.venta'         ,'compromisosController@FaseVenta')     -> name('FaseVenta');
////================================== HISTORIAL ===================================================
	Route::get('numero.orden/{id}','histrorialController@NumerodeOrden') -> name('NumerodeOrden');
	Route::get('ver.resumen/{id}' ,'histrorialController@VerResumen') 	 -> name('VerResumen');
	Route::post('historial'       ,'histrorialController@Historial') 	   -> name('Historial');
	Route::post('historialxvend'  ,'histrorialController@HistorialxVend')-> name('HistorialxVend');
	Route::post('recotización'    ,'histrorialController@Recotización')  -> name('recotización');
////================================== ENTREGAS ====================================================
	Route::post('entrega.producto' ,'entregasController@EntregarProducto') -> name('EntregarProducto');
	Route::post('entrega.id'			 ,'entregasController@entregabyid')		   -> name('Entregabyid');
//==================================== PROSPECTOS ==================================================
	Route::get('prospectos'              ,'prospectosController@Prospectos')      -> name('Prospectos');
	Route::get('prospectos.id/{id}'      ,'prospectosController@ProspectosxId')   -> name('ProspectosxId');
	Route::post('add.prospecto'				   ,'prospectosController@addProspecto')    -> name('addProspecto');
	Route::put('update.prospecto/{id}'	 ,'prospectosController@UpdateProspecto') -> name('UpdateProspecto');
	Route::post('pasar.cliente'					 ,'prospectosController@PasarACliente')   -> name('PasarACliente');
	Route::delete('delete.prospecto/{id}','clientesController@EliminarProspecto') -> name('EliminarProspecto'); 

//==================================== DEPARTAMENTOS ===============================================
	Route::get('departamentos','departamentosController@Departamentos')  -> name('Departamentos'); 
//==================================== PUESTOS =====================================================
	Route::get('puestos','puestosController@Puestos')  -> name('Puestos'); 


//==================================================================================================
//==================================== RUTAS GAMA EXTERNOS =========================================
//==================================== ACCESOS-RH ==================================================
	Route::get('bususuario.rh/{id}' ,'accesosController@buscarUsuarioRH')  -> name('buscarUsuarioRH');
	Route::post('rh.acceso'         ,'accesosController@RHAcceso')         -> name('RHAcceso'); 
	Route::get('accesos/{id}'       ,'accesosController@Accesos')          -> name('Accesos');
	Route::post('accesos.all'       ,'accesosController@accesosAll')       -> name('accesosAll');
	Route::post('actualiza.acceso'  ,'accesosController@ActualizaAcceso')  -> name('ActualizaAcceso'); 
//==================================== VISITANTES-RH ===============================================
	Route::post('add.visitante'     ,'accesosController@addVisitante')     -> name('addVisitante'); 
	Route::get('visitantes/{id}'    ,'accesosController@Visitantes')       -> name('Visitantes');
	Route::post('visitantes.all'    ,'accesosController@visitantesAll')   -> name('visitantesAll');
	Route::post('marcar.salida'     ,'accesosController@MarcarSalida')     -> name('MarcarSalida'); 
//==================================== PERMISOS-RH =================================================
	Route::post('permisos' 			 ,'permisosController@Permisos')  	   -> name('Permisos');
	Route::get('busca.empleado/{id}' ,'permisosController@buscaEmpleado')  -> name('buscaEmpleado');
	Route::post('permiso'            ,'permisosController@AddPermiso')     -> name('AddPermiso'); 
	Route::put('permiso/{id}'        ,'permisosController@PutPermiso')     -> name('PutPermiso'); 
//==================================== LLAMADAS-RH =================================================
	Route::post('add.llamada' 	     ,'llamadasController@addLLamada')    -> name('addLlamadas');
	Route::put('put.llamada/{id}'    ,'llamadasController@putLLamadas')    -> name('putLlamada'); 
	Route::get('llamadas'            ,'llamadasController@llamadas')       -> name('Llamadas');

	Route::post('add.junta'          ,'juntasController@addJuntas')       -> name('addJuntas');
	Route::put('put.junta/{id}'      ,'juntasController@putJuntas')       -> name('putJuntas');
	Route::post('sala.juntas'        ,'juntasController@salaJuntas')      -> name('salaJuntas');




























