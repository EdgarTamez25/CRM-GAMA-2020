<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

<<<<<<< ET
<<<<<<< HEAD
Route::get('/', function () { return view('welcome'); });

Route::post('iniciar.sesion.integral'      ,'userController@IniciarSesionIntegral') -> name('IniciarSesionIntegral');
Route::post('valida.sesion.activa'         ,'userController@validaSesionActiva')    -> name('validaSesionActiva');
Route::post('obtener.datos.usuario'        ,'userController@obtenerDatosUsuario')   -> name('obtenerDatosUsuario');
Route::post('cerrar.sesion'                ,'userController@CerrarSesion')          -> name('CerrarSesion');


// NIVELES
Route::get('niveles','nivelController@obtenerNiveles')   -> name('obtenerNiveles');
Route::get('sistemas','sistemasController@obtenerSistemas')   -> name('obtenerSistemas');
Route::get('consulta.accesos.usuario/{id}' ,'sistemasController@AccesosASistemas')          -> name('AccesosASistemas');





Route::post('login'                    ,'userController@IniciarSesion')           -> name('IniciarSesion');
Route::post('login.permisos'           ,'userController@SesionPermisos')  	      -> name('SesionPermisos');
Route::get('gama.etiquetas'            ,'gamaEtiquetasController@modulosActivos') -> name('modulosActivos');   
Route::post('login.programacion.flexo' ,'userController@SesionProgramacionFlexo') -> name('SesionProgramacionFlexo');

//===================================  USUARIOS ====================================================
	Route::post('usuarios'       ,'userController@agregarUsuario')      -> name('agregarUsuario');    	
	Route::get('catusuarios'     ,'userController@catalogoUsuarios') 	-> name('catalogoUsuarios');   
	Route::put('usuarios/{id}'   ,'userController@actualizarUsuario')  	-> name('actualizarUsuario');  
	

	Route::get('usuarios'	       ,'userController@getAll')      -> name('getAllUsuarios');  
	Route::delete('usuarios/{id}','userController@delete')      -> name('deleteUsuarios');  
	Route::get('choferes'	       ,'userController@choferesAll') -> name('choferesAll');  	
	Route::post('estatus.user'   ,'userController@estatusUser') -> name('estatusUser');    	

//===================================  VENDEDORES===================================================
	Route::get('vendedores'		  ,'vendedoresController@vendedores') -> name('vendedores');  	 
	Route::get('vendxsuc/{suc}' ,'vendedoresController@vendxSuc')   -> name('vendxSuc');  	 
=======
Route::get('/', function () {
    return view('welcome');
});
=======
Route::get('/', function () { return view('welcome'); });
>>>>>>> Actualizacion General

Route::post('iniciar.sesion.integral'      ,'userController@IniciarSesionIntegral') -> name('IniciarSesionIntegral');
Route::post('valida.sesion.activa'         ,'userController@validaSesionActiva')    -> name('validaSesionActiva');
Route::post('obtener.datos.usuario'        ,'userController@obtenerDatosUsuario')   -> name('obtenerDatosUsuario');
Route::post('cerrar.sesion'                ,'userController@CerrarSesion')          -> name('CerrarSesion');

<<<<<<< ET
//=================================== USUARIOS======================================================
Route::get('catusuarios'  ,'userController@getcatalogo')-> name('catusuarios');   
Route::get('usuarios'	    ,'userController@getAll')     -> name('getAllUsuarios');  			 //PROBADA
Route::post('usuarios'    ,'userController@add')        -> name('addUsuarios');    				 //PROBADA
Route::put('usuarios/{id}','userController@update')  		-> name('updateUsuarios');  			 //PROBADA
Route::delete('usuarios/{id}','userController@delete')   -> name('deleteUsuarios');  			 //PROBADA
Route::get('choferes'	    ,'userController@choferesAll') -> name('choferesAll');  		 //PROBADA
>>>>>>> parent of 63191fd... Actualizacion General
=======
>>>>>>> Actualizacion General

// NIVELES
Route::get('niveles','nivelController@obtenerNiveles')   -> name('obtenerNiveles');
Route::get('sistemas','sistemasController@obtenerSistemas')   -> name('obtenerSistemas');
Route::get('consulta.accesos.usuario/{id}' ,'sistemasController@AccesosASistemas')          -> name('AccesosASistemas');

<<<<<<< ET
<<<<<<< HEAD
  Route::get('clientes.productos','clientesController@clientes')         -> name('Clientes');              
	Route::get('clientes'          ,'clientesController@catClientes')      -> name('catClientes');            
	Route::get('clientes.selector' ,'clientesController@clientesSelector') -> name('clientesSelector'); 
	Route::post('cliente'          ,'clientesController@add')              -> name('addCliente');             
	Route::put('cliente/{id}'      ,'clientesController@update')           -> name('updateCliente');          
	Route::post('cambia.estatus'   ,'clientesController@cambiaEstatus')    -> name('cambiaEstatus'); 

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
	Route::post('compromisos' 			 ,'compromisosController@Compromisos')   -> name('Compromisos');
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

//==================================== PRODUCTOS X CLIENTE==========================================
	Route::get('productos.cliente/{id_cliente}' ,'productosxcliController@productosxCli')     -> name('productosxCli');
	Route::post('crear.producto.cliente'        ,'productosxcliController@crearDetalle')      -> name('crearDetalle');
	Route::put('actualiza.producto.cliente/{id}','productosxcliController@actualizaProducto') -> name('actualizaProducto');
	Route::post('productos.cliente.deptos'      ,'productosxcliController@PxCxD')     				-> name('PxCxD');

//==================================== SOLICITUDES =================================================
	Route::post('solicitudes.ddd'			 ,'solicitudesController@SolicitudesDDD')  	  -> name('SolicitudesDDD'); 
	Route::post('actualiza.encargado'	 ,'solicitudesController@ActualizaEncargado') -> name('ActualizaEncargado'); 
	Route::post('procesa.movimiento'	 ,'solicitudesController@ProcesaMovimiento')  -> name('ProcesaMovimiento'); 
	
	Route::post('solicitudes'					 ,'solicitudesController@Solicitudes')  	    -> name('Solicitudes'); 
	Route::get('detalle.solicitud/{id}','solicitudesController@DetalleSolicitud')   -> name('DetalleSolicitud');
	Route::get('modificaciones/{id}'   ,'solicitudesController@Modificaciones')     -> name('Modificaciones');
	Route::post('caracteristicas'   	 ,'solicitudesController@Caracteristicas')    -> name('Caracteristicas');
	Route::post('actualiza.modif'   	 ,'solicitudesController@ActualizaModif')     -> name('ActualizaModif');
	Route::post('actualiza.prod.nuevo' ,'solicitudesController@ActualizaProdNuevo') -> name('ActualizaProdNuevo');
	Route::post('actualiza.prod.existente' ,'solicitudesController@ActualizaProdExistente') -> name('ActualizaProdExistente');
	Route::post('actualiza.prod.modif'     ,'solicitudesController@ActualizaProdModif') -> name('ActualizaProdModif');
	Route::post('crear.nueva.solicitud'    ,'solicitudesController@CrearNuevaSolicitud') -> name('CrearNuevaSolicitud');

	
	
	Route::post('movim.sol'   	 		    ,'solicitudesController@MovimSol')   			  -> name('MovimSol');
	Route::post('enviar.movimiento'     ,'solicitudesController@EnviarSol')  			  -> name('EnviarSol');
	Route::post('elimina.movimiento'    ,'solicitudesController@EliminarMovim') 		 -> name('EliminarMovim'); 
	Route::post('finaliza.prodexit'     ,'solicitudesController@FinalizaProdExist')  -> name('FinalizaProdExist');

	Route::post('valida.cancelacion'         ,'solicitudesController@ValidaCancelacion')  -> name('ValidaCancelacion');
	Route::post('valida.cancelacion.partida' ,'solicitudesController@ValidaCancelacionPartida')  -> name('ValidaCancelacionPartida');
	Route::post('cancelar.movimiento'        ,'solicitudesController@CancelarMovimiento')  -> name('CancelarMovimiento');

	Route::post('agregar.producto.solicitud' ,'solicitudesController@agregaProductoSol')  -> name('agregaProductoSol');
	
	

//==================================== MATERIALES ==================================================
	Route::get('materiales/{dx}' ,'materialesController@Materiales')  -> name('Materiales');
//==================================== ACABADOS   ==================================================
	Route::get('acabados/{dx}'   ,'acabadosController@Acabados')      -> name('Acabados');

	Route::post('ordenes.trabajo'    ,'ordenesTrabajoController@OrdenesTrabajo')  	-> name('OrdenesTrabajo'); 
	Route::post('crear.orden.trabajo','ordenesTrabajoController@CrearOT')  					-> name('CrearOT'); 
	Route::get('detalle.ot/{id}'     ,'ordenesTrabajoController@DetalleOT')         -> name('DetalleOT');
	Route::put('actualiza.ot/{id}'   ,'ordenesTrabajoController@ActualizaOT')       -> name('ActualizaOT');
	
	Route::delete('elimina.partida.detot/{id}','ordenesTrabajoController@EliminarPartidaDetOT')     -> name('EliminarPartidaDetOT');  
	Route::post('actualiza.partida.detot'     ,'ordenesTrabajoController@ActualizaPartidaDetOT')  	-> name('ActualizaPartidaDetOT'); 
	Route::post('agregar.partida.detot'       ,'ordenesTrabajoController@AgregarPartidaOT')  				-> name('AgregarPartidaOT'); 
=======
//==================================== CLIENTES=====================================================
Route::get('clientes','clientesController@catClientes') -> name('catClientes');            //PROBADA
Route::post('cliente','clientesController@add')         -> name('addCliente');             //PROBADA
Route::put('cliente/{id}','clientesController@update')  -> name('updateCliente');          //PROBADA
=======
>>>>>>> Actualizacion General




Route::post('login'                    ,'userController@IniciarSesion')           -> name('IniciarSesion');
Route::post('login.permisos'           ,'userController@SesionPermisos')  	      -> name('SesionPermisos');
Route::get('gama.etiquetas'            ,'gamaEtiquetasController@modulosActivos') -> name('modulosActivos');
Route::post('login.programacion.flexo' ,'userController@SesionProgramacionFlexo') -> name('SesionProgramacionFlexo');

<<<<<<< ET
////================================== SUB ZONAS ===================================================
Route::get('subzonas/{id}','subzonasController@SubzonaxZona')-> name('SubzonaxZona');      //PROBADA
>>>>>>> parent of 63191fd... Actualizacion General
=======
//===================================  USUARIOS ====================================================
	Route::post('usuarios'       ,'userController@agregarUsuario')      -> name('agregarUsuario');
	Route::get('catusuarios'     ,'userController@catalogoUsuarios') 	-> name('catalogoUsuarios');
	Route::put('usuarios/{id}'   ,'userController@actualizarUsuario')  	-> name('actualizarUsuario');
>>>>>>> Actualizacion General


<<<<<<< ET
<<<<<<< HEAD
	
=======
//==================================== CIUDADES ====================================================
Route::get('ciudades','ciudadesController@getAll')-> name('getAllCiudades');               //PROBADA
>>>>>>> parent of 63191fd... Actualizacion General
=======
	Route::get('usuarios'	       ,'userController@getAll')      -> name('getAllUsuarios');
	Route::delete('usuarios/{id}','userController@delete')      -> name('deleteUsuarios');
	Route::get('choferes'	       ,'userController@choferesAll') -> name('choferesAll');
	Route::post('estatus.user'   ,'userController@estatusUser') -> name('estatusUser');
>>>>>>> Actualizacion General

//===================================  VENDEDORES===================================================
	Route::get('vendedores'		  ,'vendedoresController@vendedores') -> name('vendedores');
	Route::get('vendxsuc/{suc}' ,'vendedoresController@vendxSuc')   -> name('vendxSuc');

<<<<<<< ET
<<<<<<< HEAD
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
	Route::post('llamadas'            ,'llamadasController@llamadas')       -> name('Llamadas');
=======
>>>>>>> parent of 63191fd... Actualizacion General
=======
//==================================== CLIENTES ====================================================
>>>>>>> Actualizacion General

  Route::get('clientes.productos','clientesController@clientes')         -> name('Clientes');
	Route::get('clientes'          ,'clientesController@catClientes')      -> name('catClientes');
	Route::get('clientes.selector' ,'clientesController@clientesSelector') -> name('clientesSelector');
	Route::post('cliente'          ,'clientesController@add')              -> name('addCliente');
	Route::put('cliente/{id}'      ,'clientesController@update')           -> name('updateCliente');
	Route::post('cambia.estatus'   ,'clientesController@cambiaEstatus')    -> name('cambiaEstatus');

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
	// Route::get('subzonas/{id}','subzonasController@SubzonaxZona')-> name('SubzonaxZona');
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
	Route::post('compromisos' 			 ,'compromisosController@Compromisos')   -> name('Compromisos');
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

//==================================== PRODUCTOS X CLIENTE==========================================
	Route::get('productos.cliente/{id_cliente}' ,'productosxcliController@productosxCli')     -> name('productosxCli');
	Route::post('crear.producto.cliente'        ,'productosxcliController@crearDetalle')      -> name('crearDetalle');
	Route::put('actualiza.producto.cliente/{id}','productosxcliController@actualizaProducto') -> name('actualizaProducto');
	Route::post('productos.cliente.deptos'      ,'productosxcliController@PxCxD')     				-> name('PxCxD');


//==================================== SOLICITUDES =================================================
	Route::post('solicitudes.ddd'			 ,'solicitudesController@SolicitudesDDD')  	  -> name('SolicitudesDDD');
	Route::post('actualiza.encargado'	 ,'solicitudesController@ActualizaEncargado') -> name('ActualizaEncargado');
	Route::post('procesa.movimiento'	 ,'solicitudesController@ProcesaMovimiento')  -> name('ProcesaMovimiento');

	Route::post('solicitudes'					 ,'solicitudesController@Solicitudes')  	    -> name('Solicitudes');
	Route::get('detalle.solicitud/{id}','solicitudesController@DetalleSolicitud')   -> name('DetalleSolicitud');
	Route::get('modificaciones/{id}'   ,'solicitudesController@Modificaciones')     -> name('Modificaciones');
	Route::post('caracteristicas'   	 ,'solicitudesController@Caracteristicas')    -> name('Caracteristicas');
	Route::post('actualiza.modif'   	 ,'solicitudesController@ActualizaModif')     -> name('ActualizaModif');
	Route::post('actualiza.prod.nuevo' ,'solicitudesController@ActualizaProdNuevo') -> name('ActualizaProdNuevo');
	Route::post('actualiza.prod.existente' ,'solicitudesController@ActualizaProdExistente') -> name('ActualizaProdExistente');
	Route::post('actualiza.prod.modif'     ,'solicitudesController@ActualizaProdModif') -> name('ActualizaProdModif');
	Route::post('crear.nueva.solicitud'    ,'solicitudesController@CrearNuevaSolicitud') -> name('CrearNuevaSolicitud');


<<<<<<< ET
<<<<<<< HEAD
//==================================================================================================
//==================================== RUTAS PROGRAMACION FLEXO=====================================
=======
////=============================== TIPOS PRECIOS ==================================================
Route::get('tipos-precios'     ,'tipo_precioController@getAll') -> name('getAllTipoPrecio');
Route::post('tipos-precios'    ,'tipo_precioController@add')    -> name('addTipoPrecio');
Route::put('tipos-precios/{id}','tipo_precioController@update') -> name('updateTipoPrecio');

////================================== CATEGORIAS ==================================================
Route::get('categorias'     ,'categoriasController@categorias') -> name('categorias');
>>>>>>> parent of 63191fd... Actualizacion General
=======

	Route::post('movim.sol'   	 		    ,'solicitudesController@MovimSol')   			  -> name('MovimSol');
	Route::post('enviar.movimiento'     ,'solicitudesController@EnviarSol')  			  -> name('EnviarSol');
	Route::post('elimina.movimiento'    ,'solicitudesController@EliminarMovim') 		 -> name('EliminarMovim');
	Route::post('finaliza.prodexit'     ,'solicitudesController@FinalizaProdExist')  -> name('FinalizaProdExist');

	Route::post('valida.cancelacion'         ,'solicitudesController@ValidaCancelacion')  -> name('ValidaCancelacion');
	Route::post('valida.cancelacion.partida' ,'solicitudesController@ValidaCancelacionPartida')  -> name('ValidaCancelacionPartida');
	Route::post('cancelar.movimiento'        ,'solicitudesController@CancelarMovimiento')  -> name('CancelarMovimiento');

	Route::post('agregar.producto.solicitud' ,'solicitudesController@agregaProductoSol')  -> name('agregaProductoSol');



//==================================== MATERIALES ==================================================
	Route::get('materiales/{dx}' ,'materialesController@Materiales')  -> name('Materiales');
//==================================== ACABADOS   ==================================================
	Route::get('acabados/{dx}'   ,'acabadosController@Acabados')      -> name('Acabados');

	Route::post('ordenes.trabajo'    ,'ordenesTrabajoController@OrdenesTrabajo')  	-> name('OrdenesTrabajo');
	Route::post('crear.orden.trabajo','ordenesTrabajoController@CrearOT')  					-> name('CrearOT');
	Route::get('detalle.ot/{id}'     ,'ordenesTrabajoController@DetalleOT')         -> name('DetalleOT');
	Route::put('actualiza.ot/{id}'   ,'ordenesTrabajoController@ActualizaOT')       -> name('ActualizaOT');

	Route::delete('elimina.partida.detot/{id}','ordenesTrabajoController@EliminarPartidaDetOT')     -> name('EliminarPartidaDetOT');
	Route::post('actualiza.partida.detot'     ,'ordenesTrabajoController@ActualizaPartidaDetOT')  	-> name('ActualizaPartidaDetOT');
	Route::post('agregar.partida.detot'       ,'ordenesTrabajoController@AgregarPartidaOT')  				-> name('AgregarPartidaOT');





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
	Route::post('llamadas'            ,'llamadasController@llamadas')       -> name('Llamadas');

	Route::post('add.junta'          ,'juntasController@addJuntas')       -> name('addJuntas');
	Route::put('put.junta/{id}'      ,'juntasController@putJuntas')       -> name('putJuntas');
	Route::post('sala.juntas'        ,'juntasController@salaJuntas')      -> name('salaJuntas');





//==================================================================================================
//==================================== RUTAS PROGRAMACION FLEXO=====================================
>>>>>>> Actualizacion General

//==================================== LLAMADAS-RH =================================================

	Route::get('obtener.operadores'          ,'userController@obtenerOperadores')       -> name('obtenerOperadores');

	Route::post('agregar.programacion'               ,'programacionFlexoController@programacionFlexo')        -> name('programacionFlexo');
	Route::put('actualizar.programacion/{id}'        ,'programacionFlexoController@actualizaProgramacion')    -> name('actualizaProgramacion');
	Route::post('obtener.programaciones'             ,'programacionFlexoController@obtenerProgramacion')      -> name('obtenerProgramacion');
	Route::get('obtener.detalle.programacion/{id}'   ,'programacionFlexoController@DetalleProgramacion')      -> name('DetalleProgramacion');
	Route::post('iniciaizar.ot.flexo'         			 ,'programacionFlexoController@InicializarProgramacion')  -> name('InicializarProgramacion');
	Route::put('actualizar.detalle.orden.flexo/{id}' ,'programacionFlexoController@actualizarDetalle')   			-> name('actualizarDetalle');
	Route::put('finalizar.orden.flexo/{id}'          ,'programacionFlexoController@FinalizarOTFlexo')   			-> name('FinalizarOTFlexo');
	Route::put('cancelar.orden.trabajo/{id}'         ,'programacionFlexoController@cancelarOTFlexo')   			-> name('cancelarOTFlexo');

<<<<<<< ET
<<<<<<< HEAD
	Route::post('agregar.maquina.operador'    ,'maquinasController@AgregarMaquinasxOP')     -> name('AgregarMaquinasxOP');
	Route::post('editar.maquina.operador'     ,'maquinasController@EditarMaquinasxOP')      -> name('EditarMaquinasxOP');
	Route::post('obtener.maquina.operador'    ,'maquinasController@ObtenerMaquinasxOp')     -> name('ObtenerMaquinasxOp');
	Route::get('obtener.maquinas'   					,'maquinasController@Maquinas') 							-> name('Maquinas');  
	Route::delete('eliminar.asignacion.maquina/{id}','maquinasController@EliminarAsignacion')     -> name('EliminarAsignacion');  
	Route::post('valida.conservacion.asignación'   ,'maquinasController@ValidaConservacion')      -> name('ValidaConservacion');
	
	Route::post('obtener.maquina.asignada'                   ,'maquinasController@MaquinaAsignada')     -> name('MaquinaAsignada');
	Route::get('obtener.programaciones.maquina/{id_maquina}' ,'maquinasController@ProgramacionMaquina')          -> name('ProgramacionMaquina');
	
	Route::get('obtener.plecas'    ,'plecasController@Plecas')     -> name('Plecas');   
	Route::get('obtener.suajes'    ,'suajesController@Suajes')     -> name('Suajes');   

=======
//==================================== PROSPECTOS =====================================================
Route::get('prospectos' ,'prospectosController@Prospectos')     -> name('Prospectos');
Route::get('prospectos.id/{id}' ,'prospectosController@ProspectosxId')     -> name('ProspectosxId');
Route::post('add.prospecto','prospectosController@addProspecto')           -> name('addProspecto');
Route::put('update.prospecto/{id}','prospectosController@UpdateProspecto') -> name('UpdateProspecto');
Route::post('pasar.cliente','prospectosController@PasarACliente')           -> name('PasarACliente');
Route::delete('delete.prospecto/{id}','clientesController@EliminarProspecto')  -> name('EliminarProspecto'); 
=======
	Route::post('agregar.maquina.operador'    ,'maquinasController@AgregarMaquinasxOP')     -> name('AgregarMaquinasxOP');
	Route::post('editar.maquina.operador'     ,'maquinasController@EditarMaquinasxOP')      -> name('EditarMaquinasxOP');
	Route::post('obtener.maquina.operador'    ,'maquinasController@ObtenerMaquinasxOp')     -> name('ObtenerMaquinasxOp');
	Route::get('obtener.maquinas'   					,'maquinasController@Maquinas') 							-> name('Maquinas');
	Route::delete('eliminar.asignacion.maquina/{id}','maquinasController@EliminarAsignacion')     -> name('EliminarAsignacion');
	Route::post('valida.conservacion.asignación'   ,'maquinasController@ValidaConservacion')      -> name('ValidaConservacion');
>>>>>>> Actualizacion General

	Route::post('obtener.maquina.asignada'                   ,'maquinasController@MaquinaAsignada')     -> name('MaquinaAsignada');
	Route::get('obtener.programaciones.maquina/{id_maquina}' ,'maquinasController@ProgramacionMaquina')          -> name('ProgramacionMaquina');

	Route::get('obtener.plecas'    ,'plecasController@Plecas')     -> name('Plecas');
	Route::get('obtener.suajes'    ,'suajesController@Suajes')     -> name('Suajes');





<<<<<<< ET
>>>>>>> parent of 63191fd... Actualizacion General
=======
//==================================================================================================
//============================== RUTAS REGISTRO TINTAS FLEXO =======================================
>>>>>>> Actualizacion General

	Route::get('obtener.tintas'     ,'tintasController@obtenerTintas')     -> name('obtenerTintas');
	Route::post('agregar.tintas'    ,'tintasController@agregarTintas')     -> name('agregarTintas');
    Route::post('editar.tintas'     ,'tintasController@editarTintas')      -> name('editarTintas');
    Route::put('actualizar.tintas'  ,'tintasController@actualizarTintas')  -> name('actualizarTintas');

//================================== REGISTRO TINTAS ===============================================

	Route::get('obtener.colores'     ,'coloresController@obtenerColores')     -> name('obtenerColores');
	Route::post('agregar.colores'    ,'coloresController@agregarColores')     -> name('agregarColores');
    Route::post('editar.colores'     ,'coloresController@actualizarColores')  -> name('actualizarColores');
    Route::put('actualizar.colores'  ,'coloresController@Colores')            -> name('Colores');

//================================== REGISTRO COLORES ==============================================

    Route::get('obtener.histintas'   ,'hisTintasController@obtenerHisTintas')   -> name('obtenerHisTintas');
    Route::post('agregar.histintas'  ,'hisTintasController@agregarHisTintas')   -> name('agregarHisTintas');

//============================ REGISTRO HISTORIAL TINTAS ===========================================

    Route::get('obtener.pantone'   ,'pantoneController@obtenerPantone')         -> name('obtenerPantone');

//================================== REGISTRO PANTONE ==============================================




