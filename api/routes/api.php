<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return view('welcome');
});
Route::post('iniciar.sesion.integral', 'userController@IniciarSesionIntegral')->name('IniciarSesionIntegral');
Route::post('valida.sesion.activa', 'userController@validaSesionActiva')->name('validaSesionActiva');
Route::post('obtener.datos.usuario', 'userController@obtenerDatosUsuario')->name('obtenerDatosUsuario');
Route::post('cerrar.sesion', 'userController@CerrarSesion')->name('CerrarSesion');
//==================================== NIVELES ====================================================
    Route::get('niveles', 'nivelController@obtenerNiveles')->name('obtenerNiveles');
    Route::get('sistemas', 'sistemasController@obtenerSistemas')->name('obtenerSistemas');
    Route::get('consulta.accesos.usuario/{id}', 'sistemasController@AccesosASistemas')->name('AccesosASistemas');
    Route::post('login', 'userController@IniciarSesion')->name('IniciarSesion');
    Route::post('login.permisos', 'userController@SesionPermisos')->name('SesionPermisos');
    Route::get('gama.etiquetas', 'gamaEtiquetasController@modulosActivos')->name('modulosActivos');
    Route::post('login.programacion.flexo', 'userController@SesionProgramacionFlexo')->name('SesionProgramacionFlexo');
//==================================== USUARIOS ====================================================
    Route::post('usuarios', 'userController@agregarUsuario')->name('agregarUsuario');
    Route::get('catusuarios', 'userController@catalogoUsuarios')->name('catalogoUsuarios');
    Route::put('usuarios/{id}', 'userController@actualizarUsuario')->name('actualizarUsuario');
    Route::get('usuarios', 'userController@getAll')->name('getAllUsuarios');
    Route::delete('usuarios/{id}', 'userController@delete')->name('deleteUsuarios');
    Route::get('choferes', 'userController@choferesAll')->name('choferesAll');
    Route::post('estatus.user', 'userController@estatusUser')->name('estatusUser');
//==================================== VENDEDORES===================================================
    Route::get('vendedores', 'vendedoresController@vendedores')->name('vendedores');
    Route::get('vendxsuc/{suc}', 'vendedoresController@vendxSuc')->name('vendxSuc');
//==================================== CLIENTES ====================================================
    Route::get('clientes.productos', 'clientesController@clientes')->name('Clientes');
    Route::get('clientes', 'clientesController@catClientes')->name('catClientes');
    Route::get('clientes.selector', 'clientesController@clientesSelector')->name('clientesSelector');
    Route::post('cliente', 'clientesController@add')->name('addCliente');
    Route::put('cliente/{id}', 'clientesController@update')->name('updateCliente');
    Route::post('cambia.estatus', 'clientesController@cambiaEstatus')->name('cambiaEstatus');
//==================================== PROVEDORES ==================================================
    Route::get('catproveedores', 'proveedoresController@getcatalogo')->name('getcatprov');
    Route::get('proveedores', 'proveedoresController@getAll')->name('getAllproveedores');
    Route::post('proveedores', 'proveedoresController@add')->name('addProveedor');
    Route::put('proveedores/{id}', 'proveedoresController@update')->name('updateProveedor');
    Route::post('cambia.estatus.p', 'proveedoresController@cambiaEstatusP')->name('cambiaEstatusP');
//==================================== PRODUCTOS ===================================================
    Route::get('catproductos', 'productosController@getcatalogo')->name('getcatproducto');
    Route::get('productosxId/{id}', 'productosController@getcatalogoxId')->name('getcatalogoxId');
    Route::get('productos', 'productosController@getAll')->name('getAllproductos');
    Route::post('productos', 'productosController@add')->name('addProductos');
    Route::put('productos/{id}', 'productosController@update')->name('updateProductos');
//==================================== SUCURSALES ==================================================
    Route::get('sucursales', 'sucursalesController@getAll')->name('getAllSuc');
    Route::post('sucursales', 'sucursalesController@add')->name('addsuc');
    Route::put('sucursales/{id}', 'sucursalesController@update')->name('updatesuc');
//==================================== ZONAS =======================================================
    Route::get('zonas', 'zonasController@getAll')->name('getAllZonas');
    Route::get('catzonas', 'zonasController@getcatalogo')->name('getcatalogo');
    Route::post('zonas', 'zonasController@add')->name('addZonas');
    Route::put('zonas/{id}', 'zonasController@update')->name('updateZonas');
//==================================== SUB ZONAS ===================================================
    Route::get('subzonas/{id}', 'subzonasController@SubzonaxZona')->name('SubzonaxZona');
//==================================== CARTERAS ====================================================
    Route::get('carteras', 'carterasController@getAll')->name('getAllCarteras');
    Route::post('carteras', 'carterasController@add')->name('addCartera');
    Route::put('carteras/{id}', 'carterasController@update')->name('updateCartera');
//==================================== CIUDADES ====================================================
    Route::get('ciudades', 'ciudadesController@getAll')->name('getAllCiudades');
//==================================== MONEDAS =====================================================
    Route::get('monedas', 'monedasController@getAll')->name('getAllmonedas');
    Route::post('monedas', 'monedasController@add')->name('addMoneda');
    Route::put('monedas/{id}', 'monedasController@update')->name('updateMoneda');
    Route::put('predeterminado/{id}', 'monedasController@predeterminado')->name('moneda_predeterminado');
    Route::get('monedaPredeterminada', 'monedasController@getPredeterminada')->name('get_moneda_predeterminada');
//==================================== LINEAS ======================================================
    Route::get('lineas', 'lineas_prodController@getAll')->name('getAlllineas');
    Route::post('lineas', 'lineas_prodController@add')->name('addLineas');
    Route::put('lineas/{id}', 'lineas_prodController@update')->name('updateLineas');
//==================================== UNIDADES ====================================================
    Route::get('unidades', 'unidadesController@getAll')->name('getAllunidades');
    Route::post('unidades', 'unidadesController@add')->name('addUnidad');
    Route::put('unidades/{id}', 'unidadesController@update')->name('updateUnidad');
//==================================== PRECIOS =====================================================
    Route::get('catprecios', 'preciosController@getcatalogo')->name('getcatprecios');
    Route::get('preciosxid/{id}', 'preciosController@preciosxId')->name('preciosxId');
    Route::get('precios', 'preciosController@getAll')->name('getAllprecios');
    Route::post('precios', 'preciosController@add')->name('addPrecios');
    Route::put('precios/{id}', 'preciosController@update')->name('updatePrecios');
    Route::get('mp-productos', 'preciosController@mp_producto')->name('get-mp_producto');
// SE USA PARA LA MODAL DE PRECIOS
    Route::get('detalle_productos/{id}', 'preciosController@detalle_productos')->name('getdetalle_productos');
    Route::post('predeterminado', 'preciosController@predeterminado')->name('predeterminado');
//==================================== TIPOS PRECIOS ===============================================
    Route::get('tipos-precios', 'tipo_precioController@getAll')->name('getAllTipoPrecio');
    Route::post('tipos-precios', 'tipo_precioController@add')->name('addTipoPrecio');
    Route::put('tipos-precios/{id}', 'tipo_precioController@update')->name('updateTipoPrecio');
//==================================== CATEGORIAS ==================================================
    Route::get('categorias', 'categoriasController@categorias')->name('categorias');
//==================================== COMPROMISOS =================================================
    Route::post('compromisos', 'compromisosController@Compromisos')->name('Compromisos');
    Route::post('addcompromiso', 'compromisosController@addcompromiso')->name('addcompromiso');
    Route::put('putcompromiso/{id}', 'compromisosController@putcompromiso')->name('putcompromiso');
    Route::put('putcompromiso/{id}', 'compromisosController@putcompromiso')->name('putcompromiso');
    Route::post('fase.venta', 'compromisosController@FaseVenta')->name('FaseVenta');
//==================================== HISTORIAL ===================================================
    Route::get('numero.orden/{id}', 'histrorialController@NumerodeOrden')->name('NumerodeOrden');
    Route::get('ver.resumen/{id}', 'histrorialController@VerResumen')->name('VerResumen');
    Route::post('historial', 'histrorialController@Historial')->name('Historial');
    Route::post('historialxvend', 'histrorialController@HistorialxVend')->name('HistorialxVend');
    Route::post('recotización', 'histrorialController@Recotización')->name('recotización');
//==================================== ENTREGAS ====================================================
    Route::post('entrega.producto', 'entregasController@EntregarProducto')->name('EntregarProducto');
    Route::post('entrega.id', 'entregasController@entregabyid')->name('Entregabyid');
//==================================== PROSPECTOS ==================================================
    Route::get('prospectos', 'prospectosController@Prospectos')->name('Prospectos');
    Route::get('prospectos.id/{id}', 'prospectosController@ProspectosxId')->name('ProspectosxId');
    Route::post('add.prospecto', 'prospectosController@addProspecto')->name('addProspecto');
    Route::put('update.prospecto/{id}', 'prospectosController@UpdateProspecto')->name('UpdateProspecto');
    Route::post('pasar.cliente', 'prospectosController@PasarACliente')->name('PasarACliente');
    Route::delete('delete.prospecto/{id}', 'clientesController@EliminarProspecto')->name('EliminarProspecto');
//==================================== DEPARTAMENTOS ===============================================
    Route::get('departamentos', 'departamentosController@Departamentos')->name('Departamentos');
//==================================== PUESTOS =====================================================
    Route::get('puestos', 'puestosController@Puestos')->name('Puestos');
//==================================== PRODUCTOS X CLIENTE==========================================
    Route::get('productos.cliente/{id_cliente}', 'productosxcliController@productosxCli')->name('productosxCli');
    Route::post('crear.producto.cliente', 'productosxcliController@crearDetalle')->name('crearDetalle');
    Route::put('actualiza.producto.cliente/{id}', 'productosxcliController@actualizaProducto')->name('actualizaProducto');
    Route::post('productos.cliente.deptos', 'productosxcliController@PxCxD')->name('PxCxD');
//==================================== SOLICITUDES =================================================
    Route::post('solicitudes.ddd', 'solicitudesController@SolicitudesDDD')->name('SolicitudesDDD');      // EN PROCESO
    Route::post('actualiza.encargado', 'solicitudesController@ActualizaEncargado')->name('ActualizaEncargado');  // EN PROCESO
    Route::post('procesa.movimiento', 'solicitudesController@ProcesaMovimiento')->name('ProcesaMovimiento');
    Route::post('solicitudes', 'solicitudesController@Solicitudes')->name('Solicitudes');
    Route::get('detalle.solicitud/{id}', 'solicitudesController@DetalleSolicitud')->name('DetalleSolicitud');
    Route::get('modificaciones/{id}', 'solicitudesController@Modificaciones')->name('Modificaciones');
    Route::post('caracteristicas', 'solicitudesController@Caracteristicas')->name('Caracteristicas');
    //post('actualiza.modif'   	 ,'solicitudesController@ActualizaModif')     -> name('ActualizaModif');
    //post('actualiza.prod.nuevo' ,'solicitudesController@ActualizaProdNuevo') -> name('ActualizaProdNuevo');
    //post('actualiza.prod.existente' ,'solicitudesController@ActualizaProdExistente') -> name('ActualizaProdExistente');
    //post('actualiza.prod.modif'     ,'solicitudesController@ActualizaProdModif') -> name('ActualizaProdModif');
    Route::post('crear.nueva.solicitud', 'solicitudesController@CrearNuevaSolicitud')->name('CrearNuevaSolicitud');
    Route::post('elimina.movimiento', 'solicitudesController@EliminarMovim')->name('EliminarMovim');
    Route::post('finaliza.prodexit', 'solicitudesController@FinalizaProdExist')->name('FinalizaProdExist');
    Route::post('cancelar.movimiento', 'solicitudesController@CancelarMovimiento')->name('CancelarMovimiento');
    Route::get('movim.sol/{id_det_sol}', 'solicitudesController@MovimSol')->name('MovimSol');   // PROBADA ET
    Route::post('enviar.movimiento', 'solicitudesController@EnviarSol')->name('EnviarSol');  // PROBADA ET
    Route::post('actualiza.envio.movimiento', 'solicitudesController@ActualizaEnvioSol')->name('ActualizaEnvioSol');  //
    Route::post('valida.cancelacion.sol', 'solicitudesController@ValidaCancelacionSol')->name('ValidaCancelacionSol');     // PROBADA ET
    Route::post('valida.cancelacion.partida', 'solicitudesController@ValidaCancelacionPartida')->name('ValidaCancelacionPartida'); // PROBADA ET
    Route::post('agregar.producto.solicitud', 'solicitudesController@agregaProductoSol')->name('agregaProductoSol');        // PROBADA ET
    Route::put('actualiza.producto.solicitud/{id}', 'solicitudesController@actualizaProductoSol')->name('actualizaProductoSol');     // PROBADA ET
// =================================== REGISTRO-ACTIVIDAD ==========================================
    Route::post('agrega.resultados.actividad', 'registroActividadController@AgregaResultadosActividad')->name('AgregaResultadosActividad'); // PROBADA ET
    Route::get('obtener.res.act.id/{id}', 'registroActividadController@ObtenerResultadosxId')->name('ObtenerResultadosxId');      // PROBADA ET
    Route::delete('elimina.registro.actividad/{id}', 'registroActividadController@EliminaRegAct')->name('EliminaRegAct');             // PROBADA ET
    Route::post('actualiza.estatus.resultado', 'solicitudesController@ActualizaEstatusResult')->name('ActualizaEstatusResult');             // PROBADA ET
//==================================== MATERIALES ==================================================
    Route::get('materiales/{dx}', 'materialesController@Materiales')->name('Materiales');
//==================================== ACABADOS   ==================================================
    Route::get('acabados/{dx}', 'acabadosController@Acabados')->name('Acabados');
    Route::post('ordenes.trabajo', 'OTContrller@OrdenesTrabajo')->name('OrdenesTrabajo');  // PROBADA ET
    Route::get('detalle.ot/{id}', 'OTContrller@DetalleOT')->name('DetalleOT');      // PROBADA ET
    Route::put('actualiza.ot/{id}', 'OTContrller@ActualizaOT')->name('ActualizaOT');
    Route::delete('elimina.partida.detot/{id}', 'OTContrller@EliminarPartidaDetOT')->name('EliminarPartidaDetOT');
    Route::post('actualiza.partida.detot', 'OTContrller@ActualizaPartidaDetOT')->name('ActualizaPartidaDetOT');
    Route::post('agregar.partida.detot', 'OTContrller@AgregarPartidaOT')->name('AgregarPartidaOT');
    Route::post('crear.orden.trabajo', 'OTContrller@CrearOT')->name('CrearOT');     // EN PROCESO
    Route::put('actualiza.urgencia.det.ot/{id}', 'OTContrller@ActualizaUrgenciaDetOT')->name('ActualizaUrgenciaDetOT');
//==================================== MONITOR   ==================================================
    Route::post('obtener.datos.monitor', 'monitorController@ObtenerDatosMonitor')->name('ObtenerDatosMonitor');
    Route::post('programar.producto', 'monitorController@ProgramarProductos')->name('ProgramarProductos');
    Route::post('obtener.programaciones.bordados', 'monitorController@ObtenerPrograBordados')->name('ObtenerPrograBordados');
    Route::post('obtener.programaciones.digital', 'monitorController@ObtenerPrograDigital')->name('ObtenerPrograDigital');
    Route::post('obtener.programaciones.offset', 'monitorController@ObtenerPrograOffset')->name('ObtenerPrograOffset');
    Route::post('obtener.programaciones.serigrafia', 'monitorController@ObtenerPrograSerigrafia')->name('ObtenerPrograSerigrafia');
    Route::post('obtener.programaciones.empaque', 'monitorController@ObtenerPrograEmpaque')->name('ObtenerPrograEmpaque');
    Route::post('obtener.programaciones.sublimacion', 'monitorController@ObtenerPrograSublimacion')->name('ObtenerPrograSublimacion');
    Route::post('obtener.programaciones.tampografia', 'monitorController@ObtenerPrograTampografia')->name('ObtenerPrograTampografia');
    Route::post('obtener.programaciones.uv', 'monitorController@ObtenerPrograUV')->name('ObtenerPrograUV');
    Route::put('actualiza.maquina.bordados/{id}', 'monitorController@ActualizaMaquinaBordados')->name('ActualizaMaquinaBordados');
    Route::put('actualiza.maquina.digital/{id}', 'monitorController@ActualizaMaquinaDigital')->name('ActualizaMaquinaDigital');
    Route::put('actualiza.maquina.offset/{id}', 'monitorController@ActualizaMaquinaOffset')->name('ActualizaMaquinaOffset');
    Route::put('actualiza.maquina.serigrafia/{id}', 'monitorController@ActualizaMaquinaSerigrafia')->name('ActualizaMaquinaSerigrafia');
    Route::put('actualiza.maquina.empaque/{id}', 'monitorController@ActualizaMaquinaEmpaque')->name('ActualizaMaquinaEmpaque');
    Route::put('actualiza.maquina.sublimacion/{id}', 'monitorController@ActualizaMaquinaSublimacion')->name('ActualizaMaquinaSublimacion');
    Route::put('actualiza.maquina.tampografia/{id}', 'monitorController@ActualizaMaquinaTampografia')->name('ActualizaMaquinaTampografia');
    Route::put('actualiza.maquina.uv/{id}', 'monitorController@ActualizaMaquinaUV')->name('ActualizaMaquinaUV');
    Route::post('finalizar.producto.flexo', 'monitorController@FinalizaProdFlexo')->name('FinalizaProdFlexo');
    Route::post('finalizar.producto.bordados', 'monitorController@FinalizaProdBordados')->name('FinalizaProdBordados');
    Route::post('finalizar.producto.digital', 'monitorController@FinalizaProdDigital')->name('FinalizaProdDigital');
    Route::post('finalizar.producto.offset', 'monitorController@FinalizaProdOffset')->name('FinalizaProdOffset');
    Route::post('finalizar.producto.serigrafia', 'monitorController@FinalizaProdSerigrafia')->name('FinalizaProdSerigrafia');
    Route::post('finalizar.producto.empaque', 'monitorController@FinalizaProdEmpaque')->name('FinalizaProdEmpaque');
    Route::post('finalizar.producto.sublimacion', 'monitorController@FinalizaProdSublimacion')->name('FinalizaProdSublimacion');
    Route::post('finalizar.producto.tampografia', 'monitorController@FinalizaProdTampografia')->name('FinalizaProdTampografia');
    Route::post('finalizar.producto.uv', 'monitorController@FinalizaProdUV')->name('FinalizaProdUV');
//==================================================================================================



//!==================================================================================================
//!==================================== RUTAS GAMA EXTERNOS =========================================
//!===================================================================================================

//*==================================== ACCESOS-RH ==================================================
//*===================================================================================================
    Route::get('bususuario.rh/{id}', 'accesosController@buscarUsuarioRH')->name('buscarUsuarioRH');
    Route::post('rh.acceso', 'accesosController@RHAcceso')->name('RHAcceso');
    Route::get('accesos/{id}', 'accesosController@Accesos')->name('Accesos');
    Route::post('accesos.all', 'accesosController@accesosAll')->name('accesosAll');
    Route::post('actualiza.acceso', 'accesosController@ActualizaAcceso')->name('ActualizaAcceso');

//==================================== VISITANTES-RH ===============================================
    Route::post('add.visitante', 'accesosController@addVisitante')->name('addVisitante');
    Route::get('visitantes/{id}', 'accesosController@Visitantes')->name('Visitantes');
    Route::post('visitantes.all', 'accesosController@visitantesAll')->name('visitantesAll');
    Route::post('marcar.salida', 'accesosController@MarcarSalida')->name('MarcarSalida');
//==================================== PERMISOS-RH =================================================
    Route::post('permisos', 'permisosController@Permisos')->name('Permisos');
    Route::get('busca.empleado/{id}', 'permisosController@buscaEmpleado')->name('buscaEmpleado');
    Route::post('permiso', 'permisosController@AddPermiso')->name('AddPermiso');
    Route::put('permiso/{id}', 'permisosController@PutPermiso')->name('PutPermiso');
//==================================== LLAMADAS-RH =================================================
    Route::post('add.llamada', 'llamadasController@addLLamada')->name('addLlamadas');
    Route::put('put.llamada/{id}', 'llamadasController@putLLamadas')->name('putLlamada');
    Route::post('llamadas', 'llamadasController@llamadas')->name('Llamadas');

    Route::post('add.junta', 'juntasController@addJuntas')->name('addJuntas');
    Route::put('put.junta/{id}', 'juntasController@putJuntas')->name('putJuntas');
    Route::post('sala.juntas', 'juntasController@salaJuntas')->name('salaJuntas');
//==================================================================================================


//*==================================== RUTAS PROGRAMACION FLEXO =====================================
//*===================================================================================================
    Route::get('obtener.operadores', 'userController@obtenerOperadores')->name('obtenerOperadores');
    Route::post('agregar.programacion', 'programacionFlexoController@programacionFlexo')->name('programacionFlexo');
    Route::put('actualizar.programacion/{id}', 'programacionFlexoController@actualizaProgramacion')->name('actualizaProgramacion');
    Route::post('obtener.programaciones', 'programacionFlexoController@obtenerProgramacion')->name('obtenerProgramacion');
    Route::get('obtener.detalle.programacion/{id}', 'programacionFlexoController@DetalleProgramacion')->name('DetalleProgramacion');
    Route::post('iniciaizar.ot.flexo', 'programacionFlexoController@InicializarProgramacion')->name('InicializarProgramacion');
    Route::put('actualizar.detalle.orden.flexo/{id}', 'programacionFlexoController@actualizarDetalle')->name('actualizarDetalle');
    Route::put('finalizar.orden.flexo/{id}', 'programacionFlexoController@FinalizarOTFlexo')->name('FinalizarOTFlexo');
    Route::put('cancelar.orden.trabajo/{id}', 'programacionFlexoController@cancelarOTFlexo')->name('cancelarOTFlexo');
    Route::post('agregar.maquina.operador', 'maquinasController@AgregarMaquinasxOP')->name('AgregarMaquinasxOP');
    Route::post('editar.maquina.operador', 'maquinasController@EditarMaquinasxOP')->name('EditarMaquinasxOP');
    Route::post('obtener.maquina.operador', 'maquinasController@ObtenerMaquinasxOp')->name('ObtenerMaquinasxOp');
    Route::get('obtener.maquinas.depto/{id_depto}', 'maquinasController@MaquinasxDepto')->name('MaquinasxDepto');
    Route::delete('eliminar.asignacion.maquina/{id}', 'maquinasController@EliminarAsignacion')->name('EliminarAsignacion');
    Route::post('valida.conservacion.asignación', 'maquinasController@ValidaConservacion')->name('ValidaConservacion');
    Route::post('obtener.maquina.asignada', 'maquinasController@MaquinaAsignada')->name('MaquinaAsignada');
    Route::get('obtener.programaciones.maquina/{id_maquina}', 'maquinasController@ProgramacionMaquina')->name('ProgramacionMaquina');
    Route::get('obtener.plecas', 'plecasController@Plecas')->name('Plecas');
    Route::get('obtener.suajes', 'suajesController@Suajes')->name('Suajes');
//==================================== UNIDADES ====================================================
    Route::get('obtener.unidades', 'unidadesController@obtenerUnidades')->name('obtenerUnidades');
    Route::post('agregar.unidades', 'unidadesController@agregarUnidades')->name('agregarUnidades');
    Route::put('actualizar.unidades/{id}', 'unidadesController@actualizarUnidades')->name('actualizarUnidades');
//==================================== PRODUCCION ==================================================
    Route::get('obtener.programacion'     , 'produccionController@obtenerProgramacion')      ->name('obtenerProgramacion');
    Route::post('agregar.programacion.mrp', 'produccionController@ciclaProgramacion')        ->name('ciclaProgramacion');
    Route::post('obtener.datos.produccion', 'produccionController@obtener_datos_produccion') ->name('obtener_datos_produccion');

    // Route::put('actualizar.produccion/{id}', 'produccionController@actualizarProduccion')->name('actualizarProduccion');
//=================================== MOVIM PROD ===================================================
    Route::get('obtener.MovimProd', 'movimProdController@obtenerMovimProd')->name('obtenerMovimProd');
    Route::post('agregar.MovimProd', 'movimProdController@agregarMovimProd')->name('agregarMovimProd');
    Route::put('actualizar.MovimProd/{id}', 'movimProdController@actualizarMovimProd')->name('actualizarMovimProd');
//=================================== DEPARTAMENTOS POR SUCURSAL ====================================
    Route::get('obtener.deptos.por.suc/{id}'   , 'departamentosController@obtener_deptos_por_suc')->name('obtener_deptos_por_suc');

//=================================== PUESTOS POR SUCURSAL ==========================================
    Route::get('obtener.puestos.por.depto/{id}', 'puestosController@obtener_puestos_por_depto')->name('obtener_puestos_por_depto');

    

