<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //USAR ESCRITURA SQL

class solicitudesController extends Controller
{
	
		public function CrearNuevaSolicitud(Request $req){
			$crearSolicitud = DB::table('solicitudes')->insertGetId(   //! INSERTO PRODUCTO EXISTENTE
				[
						'id_cliente' =>  $req -> id_cliente,
						'id_usuario' =>  $req -> id_usuario,
						'fecha'      =>  $req -> fecha,
						'hora'		   =>  $req -> hora ,
						'nota'       =>  $req -> nota
				]
			);
			return $crearSolicitud ? response('Se creo correctamente', 200) : 
															 response('Ocurrio un error',500);   //!RETORNO ID ENCONTRADO O FALSO SI HAY UN ERROR
		}
		
	// !AGREGAR PRODUCTO ------------------------------------------>
		public function agregaProductoSol(Request $req){

<<<<<<< HEAD
			$insertProducto = DB::table('det_sol')->insertGetId(
				[
						'id_solicitud' => $req -> id_solicitud,
						'id_depto' 		 => $req -> id_depto,
						'id_producto'  => $req -> id_producto,
						'tipo_prod'    => $req -> tipo_prod,
						'cantidad'     => $req -> cantidad
				]
			);

			return $insertProducto ? response('El producto se creo correctamente', 200):
															 response('Ocurrio un error al crear el producto, intentelo de nuevo', 500);
		}

		public function actualizaProductoSol($id, Request $req){
			$actualizaProdSol = DB::update('UPDATE det_sol SET id_solicitud=:id_solicitud, id_depto=:id_depto, id_producto=:id_producto,
																												 tipo_prod=:tipo_prod, cantidad=:cantidad
																					WHERE id =:id',['id_solicitud' => $req  -> id_solicitud,
																													'id_depto'     => $req  -> id_depto,
																													'id_producto'  => $req  -> id_producto,
																													'tipo_prod'    => $req  -> tipo_prod,
																													'cantidad'     => $req  -> cantidad,
																													'id' 		 			 => $id ]);

			return $actualizaProdSol? response("la información se guardo correctamente",200): 
																response("Ocurrio un error, intentelo de nuevo",500);
		}
		
	// !CATALOGO DE SOLICITUDES
		public function Solicitudes(Request $req){
			$solicitud = DB::select('SELECT s.id, s.id_cliente, c.nombre as nomcli, s.id_usuario, u.nombre as nomusuario, 
																			s.fecha, s.hora, s.nota, s.estatus, s.procesado
=======
			if($req -> tproducto === 1 ):
				if($prod_exist = $this->productoExistente($req -> id_solicitud, $req)): 						    // !MANDO A INSERTAR EL PRODUCTO EXISTENTE
					$this -> generaDetalleSoli($req -> id_solicitud,$req -> tproducto, $prod_exist);     // !MANDO A CREAR DETALLE DE LA SOLICITUD
				endif; 
			endif;
			
			if($req -> tproducto === 2 ): 
				if($prod_modif = $this->productoAModificar($req -> id_solicitud,$req -> xmodificar)): 						    // !MANDO A INSERTAR EL PRODUCTO A MODIFICAR
					$this -> generaDetalleSoli($req -> id_solicitud,$req -> tproducto, $prod_modif);     // !MANDO A CREAR DETALLE DE LA SOLICITUD
				endif;
			endif;

			if($req -> tproducto === 3 ): 
				if($prod_nuevo = $this->productoNuevo($req -> id_solicitud,$req)): 						    // !MANDO A INSERTAR EL PRODUCTO NUEVO
					$this -> generaDetalleSoli($req -> id_solicitud,$req -> tproducto, $prod_nuevo);     // !MANDO A CREAR DETALLE DE LA SOLICITUD
				endif;
			endif;

			return response("El producto se creo correctamente",200);// !SI SE INSERTO CORRECTAMENTE RETORNO RESPUESTA


		}

		public function productoExistente($id_solicitud, $detalle){
			$insertProducto = DB::table('prod_exist')->insertGetId(   //! INSERTO PRODUCTO EXISTENTE
															[
																	'id_solicitud' => $id_solicitud,
																	'dx' 					 => $detalle["dx"],
																	'ft'           => $detalle["referencia"],
																	'cantidad'		 => $detalle["cantidad"],
																	'tipo_prod'    => $detalle["tproducto"],
															]
													);
			return $insertProducto ? $insertProducto : false;   //!RETORNO ID ENCONTRADO O FALSO SI HAY UN ERROR
		}

		public function productoAModificar($id_solicitud, $detalle){
			$prodmodif = DB::table('prod_modif')->insertGetId(   //!INSERTO PRODUCTO POR MODIFICAR
															[
																	'id_solicitud' => $id_solicitud,
																	'dx' 					 => $detalle["dx"],
																	'ft'           => $detalle["referencia"],
																	'cantidad'		 => $detalle["cantidad"],
																	'tipo_prod'    => $detalle["tproducto"],
															]
													);

			for($i=0;$i<count($detalle['xmodificar']); $i++):  //! GENERO UN CICLO EN EL ARRAY QUE RECIBO.
				if($detalle['xmodificar'][$i]['tipo'] === 1):    //! EVALUO SI EL OBJECTO SOLO CONTIENE UN ELEMENTO, MANDO A INSERTARLO
					$this -> insertarConcepto($prodmodif, $detalle['xmodificar'][$i]['concepto'], $detalle['xmodificar'][$i]['valor']);
				else:  																					//! SI EL OBJETO CONTIENE UN ARRAY ENTONCES MANDO A CICLARLO PARA INSERTAR
					$this -> ciclarConcepto($prodmodif, $detalle['xmodificar'][$i]['concepto'], $detalle['xmodificar'][$i]['valor']);
				endif; 
			endfor;

			return $prodmodif ? $prodmodif : false; //! RETORNO ID DE LA TABLA DE MODIFICACIONES.
		}

		//!ESTA FUNCION SOLO INSERTA EN LA TABLA DE MODIFICACIONES 
		//! Y SE MANDA A LLAMAR SOLO DE LA FUNCION productoAModificar
		public function insertarConcepto($prod_modif, $concepto, $valor){ 
			$dxmodif = DB::table('dx_modif')->insertGetId(
					[
							'id_prod_modif' => $prod_modif,
							'concepto'		  => $concepto,
							'valor'         => $valor,
					]
			);
		}
		//!ESTA FUNCION CICLA LOS ELEMENTOS DEL CONCEPTO A MODIFICAR
		//!Y LOS INCERTA DE MANERA INDIVIDUAL EN LA TABLA DE MODIFICACIONES.
		public function ciclarConcepto($prod_modif, $concepto, $valor){
			for($i=0;$i<count($valor); $i++):
				$this -> insertarConcepto($prod_modif, $concepto, $valor[$i]);
			endfor;
		}

		public function productoNuevo($id_solicitud, $detalle){
			$id_dx = null; //!DECLARAR VARIABLE PARA GUARDAR EL ID DE LA TABLA DONDE SE INSERTARA LA CARACTERISTICA
			switch ($detalle["dx"]) {
				case 1:
					$id_dx = $this -> insertarEnFlexo($detalle);
					break;
			}

			$insertProducto = DB::table('prod_nuevo')->insertGetId(   //! INSERTO PRODUCTO NUEVO
															[
																	'id_solicitud' => $id_solicitud,
																	'dx' 					 => $detalle["dx"],
																	'id_dx' 			 => $id_dx,
																	'ft'           => $detalle["referencia"],
																	'cantidad'		 => $detalle["cantidad"],
																	'tipo_prod'    => $detalle["tproducto"],
															]
													);
			return $insertProducto ? $insertProducto : false;   //!RETORNO ID ENCONTRADO O FALSO SI HAY UN ERROR
		}

		public function insertarEnFlexo($detalle){
			$id_flexo = DB::table('det_flexo')->insertGetId(   //! INSERTO PRODUCTO NUEVO
				[
						'id_material' 		=> $detalle["id_material"],
						'etqxrollo' 			=> $detalle["etqxrollo"],
						'med_nucleo'  		=> $detalle["med_nucleo"],
						'etqxpaso'		 		=> $detalle["etqxpaso"],
						'med_desarrollo'  => $detalle["med_desarrollo"],
						'med_eje'    			=> $detalle["med_eje"],
						'id_orientacion'  => $detalle["id_orientacion"],
						'ancho'    				=> $detalle["ancho"],
						'largo'    				=> $detalle["largo"],
				]
			);
			//! MANDO ACTUALIZAR DETALLES DE LA CARACTERISTICAS PARA CONSERVAR EL MISMO ID
			$detalles = DB::update('UPDATE det_flexo SET det_acabados=:det_acabados,det_pantones=:det_pantones
																WHERE id=:id', ['det_acabados' => $id_flexo,'det_pantones' => $id_flexo,'id' => $id_flexo	]);

			$this -> ciclaAcabados($id_flexo, $detalle); //!GENERO CICLO PARA INSERTAR ACABADOS
			$this -> ciclaPantones($id_flexo, $detalle); //!GENERO CICLO PARA INSERTAR PANTONES
			return $id_flexo;
		}

		public function generaDetalleSoli($id_solicitud, $px, $id_px){
			$insertProducto = DB::table('det_sol')->insertGetId(
				[
						'id_solicitud' => $id_solicitud,
						'px' 					 => $px,
						'id_px'        => $id_px,
				]
			);
		}
	// !FIN DE AGREGAR PRODUCTO ------------------------------------>


	// !CATALOGO DE SOLICITUDES
		public function Solicitudes(Request $req){
			$solicitud = DB::select('SELECT s.id, s.id_cliente, c.nombre as nomcli, s.id_usuario, u.nombre as nomusuario, 
																			s.fecha, s.hora, s.nota, s.estatus
>>>>>>> AE
																FROM	solicitudes s LEFT JOIN clientes c ON s.id_cliente = c.id
																										LEFT JOIN users u    ON s.id_usuario = u.id
																WHERE s.estatus = ? AND s.fecha BETWEEN ? AND ?
															ORDER BY s.id DESC',[ $req -> estatus, $req -> fecha1, $req -> fecha2 ]);
			return $solicitud ? $solicitud: $solicitud = [];
		}
<<<<<<< HEAD
		public function ActualizaEnvioSol(Request $req){
			$actualizaEnvioSol = DB::update('UPDATE movim_sol SET descripcion=:descripcion, id_depto=:id_depto
																					WHERE id =:id',['descripcion' =>  $req -> descripcion,
																													'id_depto'     => $req -> id_depto,
																													'id' 		 			 => $req -> idAEditar 
																												 ]);

			return $actualizaEnvioSol? response("la información se guardo correctamente",200): 
																response("Ocurrio un error, intentelo de nuevo",500);
		}
	//! CONSULTAR DETALLE DE LA SOLICITUD
		public function DetalleSolicitud($id){
			// ! IR A DET_SOL PARA OBTENER TODOS LOS PRODUCTOS DE LA SOLICITUD
			$detalle = DB::select('SELECT ds.id, ds.id_solicitud, ds.id_depto, ds.id_producto, pxc.nombre, 
																		pxc.codigo, pxc.descripcion, ds.tipo_prod, ds.cantidad, ds.estatus
															 FROM	det_sol ds LEFT JOIN prodxcli pxc ON ds.id_producto = pxc.id  
														WHERE id_solicitud = ?', [$id]);
			return $detalle ? $detalle: $detalle = [];
=======

	//! CONSULTAR DETALLE DE LA SOLICITUD
		public function DetalleSolicitud($id){
			// ! IR A DET_SOL PARA OBTENER TODOS LOS PRODUCTOS DE LA SOLICITUD
			$detalle = DB::select('SELECT * FROM	det_sol WHERE id_solicitud = ?', [$id]);
			$detSol = [];

			for($i=0;$i<count($detalle);$i++ ):
				if($detalle[$i] -> px === 1):
					$existente = $this -> consultaProdExistente($detalle[$i] -> id_px);
					array_push($detSol,  $existente[0]);
				endif;
				if($detalle[$i] -> px === 2):
					$Modificacion = $this -> consultaProdModif($detalle[$i] -> id_px);
					array_push($detSol, $Modificacion[0]);
				endif;
				if($detalle[$i] -> px === 3):
					$Nuevos = $this -> consultaProdNuevo($detalle[$i] -> id_px);
					array_push($detSol, $Nuevos[0]);
				endif; 
			endfor;
			
			return $detSol ? $detSol: $detSol = [];
>>>>>>> AE
		}
	
	// ! CONSULTAR SOLICITUDES DESARROLLO/DIGITAL/DISEÑO
		public function SolicitudesDDD(Request $req){
<<<<<<< HEAD
			$movimientos = DB::select('SELECT m.id, m.id_det_sol, ds.id_solicitud, m.id_depto, m.fecha, m.hora, m.id_compromiso,
																				m.id_cliente, c.nombre as nomcli, m.id_producto, p.codigo , m.descripcion, 
																				m.tipo, m.tipo_prod, m.id_encargado, u.usuario as encargado, m.id_creador, 
																				v.nombre as nomvend, m.estatus
																	FROM movim_sol m LEFT JOIN det_sol ds ON m.id_det_sol   = ds.id
																									 LEFT JOIN clientes c ON m.id_cliente   = c.id
																									 LEFT JOIN prodxcli p ON m.id_producto  = p.id
																						       LEFT JOIN users    u ON m.id_encargado = u.id
																									 LEFT JOIN users    v ON m.id_creador   = v.id
																WHERE m.estatus = ? AND m.id_depto = ? AND m.fecha BETWEEN ? AND ? order by m.fecha DESC ', 
																[ $req -> estatus, $req -> id_depto , $req -> fecha1 , $req -> fecha2]);

			return $movimientos ? $movimientos: $movimientos = [];

			// $movimSol = [];

			// for($i=0;$i<count($movimientos);$i++ ):
			// 	if($movimientos[$i] -> px === 1):
			// 		$existente = $this -> consultaProdExistente($movimientos[$i] -> id_px);
			// 		$arrayTemp = $this -> formarObjecto($existente, $movimientos[$i]);
			// 		array_push($movimSol,  $arrayTemp);
			// 	endif;
			// 	if($movimientos[$i] -> px === 2):
			// 		$Modificacion = $this -> consultaProdModif($movimientos[$i] -> id_px);
			// 		$arrayTemp = $this -> formarObjecto($Modificacion, $movimientos[$i]);
			// 		array_push($movimSol, $arrayTemp);
			// 	endif;
			// 	if($movimientos[$i] -> px === 3):
			// 		$Nuevos = $this -> consultaProdNuevo($movimientos[$i] -> id_px);
			// 		$arrayTemp = $this -> formarObjecto($Nuevos, $movimientos[$i]);
			// 		array_push($movimSol, $arrayTemp);
			// 	endif; 
			// endfor;

			// return $movimSol ? $movimSol: $movimSol = [];
=======
			$movimientos = DB::select('SELECT m.id, m.id_solicitud, m.px, m.id_px, m.id_depto, m.fecha, m.hora, m.estatus,u.nombre as nomvend, 
																				c.nombre as nomcli, us.id as id_encargado, us.usuario as encargado, us.nombre as nomencargado
																	FROM movim_sol m LEFT JOIN solicitudes s ON m.id_solicitud = s.id
																									LEFT JOIN users u       ON s.id_usuario   = u.id 
																									LEFT JOIN clientes c    ON s.id_cliente   = c.id
																									LEFT JOIN users us      ON m.id_encargado = us.id
																WHERE m.estatus = ? AND m.id_depto = ? AND m.fecha BETWEEN ? AND ?', 
																[ $req -> estatus, $req -> id_depto , $req -> fecha1 , $req -> fecha2]);
			// return $movimientos;

			$movimSol = [];

			for($i=0;$i<count($movimientos);$i++ ):
				if($movimientos[$i] -> px === 1):
					$existente = $this -> consultaProdExistente($movimientos[$i] -> id_px);
					$arrayTemp = $this -> formarObjecto($existente, $movimientos[$i]);
					array_push($movimSol,  $arrayTemp);
				endif;
				if($movimientos[$i] -> px === 2):
					$Modificacion = $this -> consultaProdModif($movimientos[$i] -> id_px);
					$arrayTemp = $this -> formarObjecto($Modificacion, $movimientos[$i]);
					array_push($movimSol, $arrayTemp);
				endif;
				if($movimientos[$i] -> px === 3):
					$Nuevos = $this -> consultaProdNuevo($movimientos[$i] -> id_px);
					$arrayTemp = $this -> formarObjecto($Nuevos, $movimientos[$i]);
					array_push($movimSol, $arrayTemp);
				endif; 
			endfor;

			return $movimSol ? $movimSol: $movimSol = [];
>>>>>>> AE

		}

		public function ActualizaEncargado(Request $req){
			$actualizaEncargado = DB::update('UPDATE movim_sol SET id_encargado=:id_encargado
																					WHERE id =:id',['id_encargado' => $req  ->  id_encargado,
																													'id' 		 			 => $req  -> id ]);

			return $actualizaEncargado? response("la información se guardo correctamente",200): 
																	response("Ocurrio un error, intentelo de nuevo",500);
			
		}

		public function ProcesaMovimiento(Request $req){

			$procesaMovim = DB::update('UPDATE movim_sol SET responsable2=:responsable2, estatus=:estatus
																					WHERE id =:id',['responsable2' => $req  -> responsable2,
																													'estatus'      => $req  -> estatus,
																													'id' 		 			 => $req  -> id_key
																												]);
			
			
			$this -> validaEstatusMovim($req);
			$this -> validaEstatusSolicitud($req);																								 
			return $procesaMovim? response("la información se guardo correctamente",200): 
														response("Ocurrio un error, intentelo de nuevo",500);
		}

	//! OBTENER MODIFICACIONES DE UNA SOLICITUD
		public function Modificaciones($id){
				return  DB::select('SELECT * FROM dx_modif WHERE id_prod_modif =?',[$id]);
		}

	// ! OBTENER CARACTERISTICAS POR FORMULARIO
		public function Caracteristicas(Request $req){
			switch ($req['dx'] ) {
				case 1:
					return $this -> Flexografia($req['id_dx'], $req['dx'] );
					break;
				case 3:
					return $this -> Digital($req['id_dx'], $req['dx'] );
					break;
			}
		}

	// TODO -> CONSULTAS CORRESPONDIENTES AL DETALLE DE SOLICITUD ******************
	// TODO ************************************************************************
		public function consultaProdExistente($id_px){
			return DB::select('SELECT * FROM prod_exist WHERE id =?',[$id_px]);
		}
		public function consultaProdModif($id_px){
			return DB::select('SELECT * FROM prod_modif WHERE id =?',[$id_px]);
		}
		public function consultaProdNuevo($id_px){
			return DB::select('SELECT * FROM prod_nuevo WHERE id =?',[$id_px]);
		}
	//! FORMA OBJETO QUE SE MANDARA EN SolicitudesDDD
		public function formarObjecto($data, $movim){
			// return $data;
			return $objetTemp = [ "id_key"			 => $movim -> id, 
														"id_solicitud" => $movim -> id_solicitud,
														"px" 					 => $movim -> px,
														"id_px" 			 => $movim -> id_px,
														"id_depto"     => $movim -> id_depto,
														"fecha"        => $movim -> fecha,
														"hora"         => $movim -> hora,
														"estatus_key"  => $movim -> estatus,
														"nomvend"      => $movim -> nomvend,
														"nomcli"       => $movim -> nomcli,
														"id_encargado" => $movim -> id_encargado,
														"encargado"    => $movim -> encargado,
														"nomencargado" => $movim -> nomencargado,
														"id"       		 => $data[0] -> id,
														"ft" 					 => $data[0] -> ft,
														"dx"					 => $data[0] -> dx,
														"id_dx"        => $movim -> px === 3 ? $data[0] -> id_dx : 0 ,
														"tipo_prod"    => $data[0] -> tipo_prod,
														"cantidad"     => $data[0] -> cantidad,
														"estatus"		   => $data[0] -> estatus
													];
		}
	// TODO ************************************************************************
	// TODO CARACTERISTICAS POR FORMULARIO******************************************
	// TODO ************************************************************************
		public function Flexografia($id_dx, $dx){
			$arrayTemporal = [];

			$flexo    = DB::select('SELECT * FROM det_flexo WHERE id =?',[$id_dx]);
			$pantones = $this -> obtenerPantones($flexo[0] -> det_pantones, $dx);
			$acabados = $this -> obtenerAcabados($flexo[0] -> det_acabados, $dx);

			$arrayTemporal = ["id" 					   => $flexo[0] -> id, 
												"id_material"    => $flexo[0] -> id_material,
												"det_acabados"   => $flexo[0] -> det_acabados,
												"etqxrollo"      => $flexo[0] -> etqxrollo,
												"etqxpaso" 		   => $flexo[0] -> etqxpaso,
												"med_nucleo" 	   => $flexo[0] -> med_nucleo, 
												"med_desarrollo" => $flexo[0] -> med_desarrollo,
												"med_eje" 			 => $flexo[0] -> med_eje,
												"id_orientacion" => $flexo[0] -> id_orientacion,
												"ancho" 			 	 => $flexo[0] -> ancho,
												"largo" 			   => $flexo[0] -> largo,
												"det_pantones"   => $flexo[0] -> det_pantones,
												"pantones" 		   => $pantones,
												"acabados" 		   => $acabados
												];
			return $arrayTemporal;
		}

		public function Digital($id_dx, $dx){
			$arrayTemporal = [];
			$digital       = DB::select('SELECT * FROM det_digital WHERE id =?',[$id_dx]);
			$pantones      = $this -> obtenerPantones($digital[0] -> det_pantones, $dx);
			$acabados      = $this -> obtenerAcabados($digital[0] -> det_acabados, $dx);

			$arrayTemporal = ["id" 					 => $digital[0] -> id, 
												"id_material"  => $digital[0] -> id_material,
												"det_sobre"    => $digital[0] -> det_sobre,
												"det_pantones" => $digital[0] -> det_pantones,
												"det_acabados" => $digital[0] -> det_acabados, 
												"estructura"   => $digital[0] -> estructura,
												"grosor" 			 => $digital[0] -> grosor,
												"ancho" 			 => $digital[0] -> ancho,
												"largo" 			 => $digital[0] -> largo,
												"pantones" 		 => $pantones,
												"acabados" 		 => $acabados
												];

			return $arrayTemporal;
		}
	// TODO ************************************************************************
	
		public function obtenerPantones($id_pantone, $dx){
			return DB::select('SELECT * FROM det_pantone WHERE id_dx = ? AND dx=?', [$id_pantone, $dx]);
		}

		public function obtenerAcabados($id_acabados , $dx){
			$acabados_modificados = [];
			$acabados = DB::select('SELECT d.id as id_key, d.id_dx, d.dx, d.id_acabado as id, a.nombre
														FROM det_acabado d LEFT JOIN acabados a ON d.id_acabado = a.id
													WHERE d.id_dx = ? AND d.dx = ?', [$id_acabados , $dx]);

			for($i=0;$i<count($acabados);$i++ ):
				$acabado = ["id_key" => $acabados[$i] -> id_key, 
											"id_dx"  => $acabados[$i] -> id_dx,
											"dx"     => $acabados[$i] -> dx, 
											"id"     => intval($acabados[$i] -> id), 
											"nombre" => $acabados[$i] -> nombre
				];
				array_push($acabados_modificados, $acabado);
			endfor;

			return $acabados_modificados;

		}

		public function ActualizaModif(Request $req){
			for($i=0;$i<count($req['data']);$i++):
				DB::update('UPDATE dx_modif SET accion=:accion, valor2=:valor2
																WHERE id =:id',['accion' => $req['data'][$i]['accion'] ,
																								'valor2' => $req['data'][$i]['valor2'] , 
																								'id' 		 => $req['data'][$i]['id']  ]);
			endfor;
			
			$this -> actualizaEstatusModif($req);
			return response("la información se guardo correctamente",200);
		}

<<<<<<< HEAD
		// public function actualizaEstatusModif($data){
		// 	// return $data;
		// 	DB::update('UPDATE prod_modif SET estatus=:estatus 
		// 								WHERE id=:id',['estatus' => $data['estatus'], 
		// 															'id' 		 => $data['id'] ]);
		// }

		// public function actualizaEstatusProdExist($data){
		// 	DB::update('UPDATE prod_exist SET estatus=:estatus 
		// 								WHERE id=:id',['estatus' => $data['estatus'], 
		// 															'id' 		 => $data['id'] ]);
		// }

		// public function actualizaEstatusProdNuevo($data){
		// 	DB::update('UPDATE prod_nuevo SET estatus=:estatus 
		// 								WHERE id=:id',['estatus' => $data['estatus'], 
		// 															'id' 		 => $data['id'] ]);
		// }

	//! ACTUALIZAR CARACTERISTICAS ***************************************************************************
		// public function ActualizaProdNuevo(Request $req){
		// 	// return $req;
		// 	switch ($req["dx"]) {
		// 		case 1:
		// 			$this -> actualizaFlexo($req);
		// 			break;
		// 		case 3:
		// 			$this -> actualizaDigital($req);
		// 			break;
		// 	}

		// 	DB::update('UPDATE prod_nuevo SET ft=:ft, cantidad=:cantidad
		// 								WHERE id =:id',['ft' 			 => $req['referencia'] ,
		// 																'cantidad' => $req['cantidad'] , 
		// 																'id' 		   => $req['id']  ]);
		// }

		// public function actualizaFlexo($req){
		// 	DB::update('UPDATE det_flexo SET id_material=:id_material, etqxrollo=:etqxrollo, med_nucleo=:med_nucleo, etqxpaso=:etqxpaso, 
		// 																		med_desarrollo=:med_desarrollo, med_eje=:med_eje,id_orientacion=:id_orientacion, 
		// 																		ancho=:ancho, largo=:largo
		// 								WHERE id=:id',	['id_material'   => $req['id_material'] ,
		// 																'etqxrollo'      => $req['etqxrollo'] , 
		// 																'med_nucleo'     => $req['med_nucleo'],
		// 																'etqxpaso'       => $req['etqxpaso'],
		// 																'med_desarrollo' => $req['med_desarrollo'],
		// 																'med_eje'        => $req['med_eje'],
		// 																'id_orientacion' => $req['id_orientacion'],
		// 																'ancho'          => $req['ancho'],
		// 																'largo'          => $req['largo'],
		// 																'id' 		         => $req['id_dx']  ]);

		// 	$this -> eliminaAcabado($req['id_dx']);      //!ELIMINO TODOS LOS ACABADOS QUE PERTENESCAN AL id_dx
		// 	$this -> eliminaPantone($req['id_dx']);			 //!ELIMINO TODOS LOS PANTONES QUE PERTENESCAN AL id_dx							
		// 	$this -> ciclaAcabados($req['id_dx'], $req); //!GENERO CICLO PARA ACABADOS
		// 	$this -> ciclaPantones($req['id_dx'], $req); //!GENERO CICLO PARA PANTONES

		// 	return response("la información se guardo correctamente",200);
		// }

		// public function actualizaDigital($req){
		// 	DB::update('UPDATE det_digital SET id_material=:id_material, det_sobre=:det_sobre, estructura=:estructura, grosor=:grosor, 
		// 																		ancho=:ancho, largo=:largo
		// 								WHERE id=:id',	['id_material'   => $req['id_material'] ,
		// 																'det_sobre'      => $req['id_material2'] , 
		// 																'estructura'     => $req['estructura'],
		// 																'grosor'         => $req['grosor'],
		// 																'ancho'          => $req['ancho'],
		// 																'largo'          => $req['largo'],
		// 																'id' 		         => $req['id_dx']  ]);

		// 	$this -> eliminaAcabado($req['id_dx']);      //!ELIMINO TODOS LOS ACABADOS QUE PERTENESCAN AL id_dx
		// 	$this -> eliminaPantone($req['id_dx']);			 //!ELIMINO TODOS LOS PANTONES QUE PERTENESCAN AL id_dx							
		// 	$this -> ciclaAcabados($req['id_dx'], $req); //!GENERO CICLO PARA ACABADOS
		// 	$this -> ciclaPantones($req['id_dx'], $req); //!GENERO CICLO PARA PANTONES

		// 	return response("la información se guardo correctamente",200);
		// }

		// public function ActualizaProdExistente(Request $req){
		// 	$actualizaProdExist = DB::update('UPDATE prod_exist SET ft=:ft, cantidad=:cantidad WHERE id=:id', 
		// 																				[ 'ft' 			 => $req -> referencia, 
		// 																					'cantidad' => $req -> cantidad, 
		// 																					'id' 		   => $req -> id  
		// 																				]);
		// 	return $actualizaProdExist ? response('OK', 200): response('Ocurrio un error al actualizar el producto existente.',500);
		// }

		// public function ActualizaProdModif(Request $req){
		// 	if($req -> tproducto === 2):
		// 		$this -> actualizaProductoModif($req);
		// 		$this -> eliminaDxModif($req -> conceptosAEliminar);
		// 		$this -> actualizaDxModif($req -> id_partida, $req -> xmodificar );
		// 	endif;
		// }

		// public function actualizaProductoModif($data){
		// 	$actualizaProdNuevo = DB::update('UPDATE prod_modif SET ft=:ft, cantidad=:cantidad WHERE id=:id', 
		// 																					[ 'ft' 			 => $data['referencia'], 
		// 																						'cantidad' => $data['cantidad'], 
		// 																						'id' 		   => $data['id']  
		// 																					]);
		// }

		// public function eliminaDxModif($conceptosAEliminar){
		// 	for($i=0;$i<count($conceptosAEliminar); $i++):  
		// 		DB::delete('DELETE FROM dx_modif WHERE id = ?', [ $conceptosAEliminar[$i] ]);
		// 	endfor;
		// }

		// public function actualizaDxModif($prodmodif, $detalle){
		// 	for($i=0;$i<count($detalle['xmodificar']); $i++):  //! GENERO UN CICLO EN EL ARRAY QUE RECIBO.
		// 		if($detalle['xmodificar'][$i]['tipo'] === 1):    //! EVALUO SI EL OBJECTO SOLO CONTIENE UN ELEMENTO, MANDO A INSERTARLO
		// 			$this -> insertarConcepto($prodmodif, $detalle['xmodificar'][$i]['concepto'], $detalle['xmodificar'][$i]['valor']);
		// 		else:  																					//! SI EL OBJETO CONTIENE UN ARRAY ENTONCES MANDO A CICLARLO PARA INSERTAR
		// 			$this -> ciclarConcepto($prodmodif, $detalle['xmodificar'][$i]['concepto'], $detalle['xmodificar'][$i]['valor']);
		// 		endif; 
		// 	endfor;
		// }
=======
		public function actualizaEstatusModif($data){
			// return $data;
			DB::update('UPDATE prod_modif SET estatus=:estatus 
										WHERE id=:id',['estatus' => $data['estatus'], 
																	'id' 		 => $data['id'] ]);
		}

		public function actualizaEstatusProdExist($data){
			DB::update('UPDATE prod_exist SET estatus=:estatus 
										WHERE id=:id',['estatus' => $data['estatus'], 
																	'id' 		 => $data['id'] ]);
		}

		public function actualizaEstatusProdNuevo($data){
			DB::update('UPDATE prod_nuevo SET estatus=:estatus 
										WHERE id=:id',['estatus' => $data['estatus'], 
																	'id' 		 => $data['id'] ]);
		}

	//! ACTUALIZAR CARACTERISTICAS ***************************************************************************
		public function ActualizaProdNuevo(Request $req){
			// return $req;
			switch ($req["dx"]) {
				case 1:
					$this -> actualizaFlexo($req);
					break;
				case 3:
					$this -> actualizaDigital($req);
					break;
			}

			DB::update('UPDATE prod_nuevo SET ft=:ft, cantidad=:cantidad
										WHERE id =:id',['ft' 			 => $req['referencia'] ,
																		'cantidad' => $req['cantidad'] , 
																		'id' 		   => $req['id']  ]);
		}

		public function actualizaFlexo($req){
			DB::update('UPDATE det_flexo SET id_material=:id_material, etqxrollo=:etqxrollo, med_nucleo=:med_nucleo, etqxpaso=:etqxpaso, 
																				med_desarrollo=:med_desarrollo, med_eje=:med_eje,id_orientacion=:id_orientacion, 
																				ancho=:ancho, largo=:largo
										WHERE id=:id',	['id_material'   => $req['id_material'] ,
																		'etqxrollo'      => $req['etqxrollo'] , 
																		'med_nucleo'     => $req['med_nucleo'],
																		'etqxpaso'       => $req['etqxpaso'],
																		'med_desarrollo' => $req['med_desarrollo'],
																		'med_eje'        => $req['med_eje'],
																		'id_orientacion' => $req['id_orientacion'],
																		'ancho'          => $req['ancho'],
																		'largo'          => $req['largo'],
																		'id' 		         => $req['id_dx']  ]);

			$this -> eliminaAcabado($req['id_dx']);      //!ELIMINO TODOS LOS ACABADOS QUE PERTENESCAN AL id_dx
			$this -> eliminaPantone($req['id_dx']);			 //!ELIMINO TODOS LOS PANTONES QUE PERTENESCAN AL id_dx							
			$this -> ciclaAcabados($req['id_dx'], $req); //!GENERO CICLO PARA ACABADOS
			$this -> ciclaPantones($req['id_dx'], $req); //!GENERO CICLO PARA PANTONES

			return response("la información se guardo correctamente",200);
		}

		public function actualizaDigital($req){
			DB::update('UPDATE det_digital SET id_material=:id_material, det_sobre=:det_sobre, estructura=:estructura, grosor=:grosor, 
																				ancho=:ancho, largo=:largo
										WHERE id=:id',	['id_material'   => $req['id_material'] ,
																		'det_sobre'      => $req['id_material2'] , 
																		'estructura'     => $req['estructura'],
																		'grosor'         => $req['grosor'],
																		'ancho'          => $req['ancho'],
																		'largo'          => $req['largo'],
																		'id' 		         => $req['id_dx']  ]);

			$this -> eliminaAcabado($req['id_dx']);      //!ELIMINO TODOS LOS ACABADOS QUE PERTENESCAN AL id_dx
			$this -> eliminaPantone($req['id_dx']);			 //!ELIMINO TODOS LOS PANTONES QUE PERTENESCAN AL id_dx							
			$this -> ciclaAcabados($req['id_dx'], $req); //!GENERO CICLO PARA ACABADOS
			$this -> ciclaPantones($req['id_dx'], $req); //!GENERO CICLO PARA PANTONES

			return response("la información se guardo correctamente",200);
		}

		public function ActualizaProdExistente(Request $req){
			$actualizaProdExist = DB::update('UPDATE prod_exist SET ft=:ft, cantidad=:cantidad WHERE id=:id', 
																						[ 'ft' 			 => $req -> referencia, 
																							'cantidad' => $req -> cantidad, 
																							'id' 		   => $req -> id  
																						]);
			return $actualizaProdExist ? response('OK', 200): response('Ocurrio un error al actualizar el producto existente.',500);
		}

		public function ActualizaProdModif(Request $req){
			if($req -> tproducto === 2):
				$this -> actualizaProductoModif($req);
				$this -> eliminaDxModif($req -> conceptosAEliminar);
				$this -> actualizaDxModif($req -> id_partida, $req -> xmodificar );
			endif;
		}

		public function actualizaProductoModif($data){
			$actualizaProdNuevo = DB::update('UPDATE prod_modif SET ft=:ft, cantidad=:cantidad WHERE id=:id', 
																							[ 'ft' 			 => $data['referencia'], 
																								'cantidad' => $data['cantidad'], 
																								'id' 		   => $data['id']  
																							]);
		}

		public function eliminaDxModif($conceptosAEliminar){
			for($i=0;$i<count($conceptosAEliminar); $i++):  
				DB::delete('DELETE FROM dx_modif WHERE id = ?', [ $conceptosAEliminar[$i] ]);
			endfor;
		}

		public function actualizaDxModif($prodmodif, $detalle){
			for($i=0;$i<count($detalle['xmodificar']); $i++):  //! GENERO UN CICLO EN EL ARRAY QUE RECIBO.
				if($detalle['xmodificar'][$i]['tipo'] === 1):    //! EVALUO SI EL OBJECTO SOLO CONTIENE UN ELEMENTO, MANDO A INSERTARLO
					$this -> insertarConcepto($prodmodif, $detalle['xmodificar'][$i]['concepto'], $detalle['xmodificar'][$i]['valor']);
				else:  																					//! SI EL OBJETO CONTIENE UN ARRAY ENTONCES MANDO A CICLARLO PARA INSERTAR
					$this -> ciclarConcepto($prodmodif, $detalle['xmodificar'][$i]['concepto'], $detalle['xmodificar'][$i]['valor']);
				endif; 
			endfor;
		}
>>>>>>> AE


	//! ******************************************************************************************************

		public function ciclaAcabados($id_dx, $detalle){
			for($i=0;$i<count($detalle['acabados']); $i++):  
				$this -> insertarAcabado($id_dx, $detalle['acabados'][$i]['id'], $detalle['dx']);
			endfor;
		}

		public function ciclaPantones($id_dx, $detalle){
			for($i=0;$i<count($detalle['pantones']); $i++):  
				$this -> insertarPantone($id_dx, $detalle['pantones'][$i], $detalle['dx']);
			endfor;
		}

		public function eliminaAcabado($id_dx){
			DB::delete('DELETE FROM det_acabado WHERE id_dx=?',[$id_dx]);
		}

		public function eliminaPantone($id_dx){
			DB::delete('DELETE FROM det_pantone WHERE id_dx=?',[$id_dx]);
		}

		public function insertarAcabado($id_dx, $id_acabado, $dx){ 
			$acabado = DB::table('det_acabado')->insertGetId(
					[
							'dx'				 => $dx,
							'id_acabado' => $id_acabado,
							'id_dx'      => $id_dx,
					]
			);
		}
		public function insertarPantone($id_dx, $pantone, $dx){ 
			$pantone = DB::table('det_pantone')->insertGetId(
					[
							'dx'				=> $dx,
							'pantone' 	=> $pantone,
							'id_dx'     => $id_dx,
					]
			);
		}

<<<<<<< HEAD
		public function MovimSol($id_det_sol){
			$movim = DB::select('SELECT * FROM movim_sol WHERE id_det_sol=? ORDER BY id DESC',[$id_det_sol]);
=======
		public function MovimSol(Request $req){
			$movim = DB::select('SELECT * FROM movim_sol WHERE id_px =? AND px=? ORDER BY id DESC',[$req -> id_px, $req -> px]);
>>>>>>> AE
			return $movim ? $movim: $movim = [];
		}

		public function EnviarSol(Request $req){
<<<<<<< HEAD
			$movimiento = DB::table('movim_sol')->insertGetId(
										[
												'id_det_sol' 	  => $req['id_det_sol'],
												'id_depto'			=> $req['id_depto'],
												'fecha'					=> $req['fecha'],
												'hora'					=> $req['hora'],
												'id_creador'    => $req['id_creador'],
												'descripcion'   => $req['descripcion']
										]
									);
			
			$this -> validaEstatusMovim($req);
		  $this -> validaEstatusSolicitud($req);
			return $movimiento ? response("La información se guardo correctamente",200):
												   response("Ocurrio un error, intentelo mas tarde.",500);

		}

		// public function FinalizaProdExist(Request $req){
		// 	$this -> actualizaEstatusProdExist($req);
		// 	$this -> validaEstatusSolicitud($req);
		// 	return response("la información se guardo correctamente",200);
		// }
	
		public function EliminarMovim(Request $req){
			$deleteMovim = DB::delete('DELETE FROM movim_sol WHERE id= ?',[$req -> id_delete]);
			$this -> validaEstatusMovim($req);
=======
			for($i=0;$i<count($req['deptos']); $i++):  
				DB::table('movim_sol')->insertGetId(
					[
							'id_solicitud' 	=> $req['id_solicitud'],
							'px'						=> $req['px'],
							'id_px'    		  => $req['id_px'],
							'id_depto'      => $req['deptos'][$i]['id'],
							'fecha'					=> $req['fecha'],
							'hora'					=> $req['hora'],
							'responsable'   => $req['id_usuario']
					]
				);
			endfor;
			

			if($req['px'] === 1): $this -> actualizaEstatusProdExist($req); endif;
			if($req['px'] === 2): $this -> actualizaEstatusModif($req)    ; endif;
			if($req['px'] === 3): $this -> actualizaEstatusProdNuevo($req); endif;
			
			$this -> validaEstatusSolicitud($req);
			return response("la información se guardo correctamente",200);

		}

		public function FinalizaProdExist(Request $req){
			$this -> actualizaEstatusProdExist($req);
			$this -> validaEstatusSolicitud($req);
			return response("la información se guardo correctamente",200);
		}
	
		public function EliminarMovim(Request $req){
			$deleteMovim = DB::delete('DELETE FROM movim_sol WHERE id= ?',[$req -> id_delete]);

			if($req -> px === 1): $this -> actualizaEstatusProdExist($req); endif;
			if($req -> px === 2): $this -> actualizaEstatusModif($req)    ; endif;
			if($req -> px === 3): $this -> actualizaEstatusProdNuevo($req); endif;
			
>>>>>>> AE
			$this -> validaEstatusSolicitud($req);
			return response("la información se guardo correctamente",200);
		}

		public function validaEstatusMovim($data){
<<<<<<< HEAD
			$cero=0;$uno=0; $dos=0; $tres=0; $cuatro=0; $movim=[];

			$movim = DB::select('SELECT * FROM movim_sol WHERE id_det_sol =? ', [$data -> id_det_sol]);

			if(count($movim) === 0){
			 $objetTemp  = ["id" => $data['id_det_sol'], "estatus" => 1 ];
			 $this -> actualizaEstatusDetSol($objetTemp);
		  }
=======
			$uno=0; $dos=0; $tres=0;
			$movim = DB::select('SELECT * FROM movim_sol WHERE id_solicitud =? AND id_px=? AND px=?', 
														[$data -> id_solicitud, $data -> id, $data -> px]);
>>>>>>> AE

			for($i=0;$i<count($movim); $i++): 
				if($movim[$i] -> estatus === 1 ):
					$uno++;
				elseif($movim[$i] -> estatus === 2):
					$dos++;
				elseif($movim[$i] -> estatus === 3):
					$tres++;
<<<<<<< HEAD
				elseif($movim[$i] -> estatus === 4):
					$cuatro++;
=======
>>>>>>> AE
				endif;
			endfor;
			
			if($uno > 0):
<<<<<<< HEAD
				$objetTemp  = ["id" => $data['id_det_sol'], "estatus" => 2 ];
				$this -> actualizaEstatusDetSol($objetTemp);
			elseif($dos > 0):
				$objetTemp  = ["id" => $data['id_det_sol'], "estatus" => 2 ];
				$this -> actualizaEstatusDetSol($objetTemp);
			elseif($tres > 0):
				$objetTemp  = ["id" => $data['id_det_sol'], "estatus" => 3 ];
				$this -> actualizaEstatusDetSol($objetTemp);
			elseif($cuatro > 0):
				$objetTemp  = ["id" => $data['id_det_sol'], "estatus" => 1 ];
				$this -> actualizaEstatusDetSol($objetTemp);
=======
				$objetTemp  = ["id" => $data -> id, "estatus" => 2];$objetTemp2 = [ "data" => $objetTemp];
				if($data -> px === 1): $this -> actualizaEstatusProdExist($objetTemp2['data']); endif;
				if($data -> px === 2): $this -> actualizaEstatusModif($objetTemp2['data'])    ; endif;
				if($data -> px === 3): $this -> actualizaEstatusProdNuevo($objetTemp2['data']); endif;

			elseif($dos > 0):
				$objetTemp = ["id" => $data -> id, "estatus" => 2];	$objetTemp2 = [ "data" => $objetTemp];
				if($data -> px === 1): $this -> actualizaEstatusProdExist($objetTemp2['data']); endif;
				if($data -> px === 2): $this -> actualizaEstatusModif($objetTemp2['data'])    ; endif;
				if($data -> px === 3): $this -> actualizaEstatusProdNuevo($objetTemp2['data']); endif;

			elseif($tres > 0):
				// return $data;
				$objetTemp = ["id" => $data -> id, "estatus" => 3];$objetTemp2 = [ "data" => $objetTemp];
				if($data -> px === 1): $this -> actualizaEstatusProdExist($objetTemp2['data']); endif;
				if($data -> px === 2): $this -> actualizaEstatusModif($objetTemp2['data'])    ; endif;
				if($data -> px === 3): $this -> actualizaEstatusProdNuevo($objetTemp2['data']); endif;
>>>>>>> AE
			endif;
		}

  // TODO ******************** FUNCIONES PARA VALIDAR ESTATUS DE SOLICITUD ***************************
	// TODO ********************************************************************************************
		public function	validaEstatusSolicitud($data){
			$cero=0;$uno=0;$dos=0; $tres=0; $cuatro=0;
			$detalle = $this -> DetalleSolicitud($data['id_solicitud']);
			
<<<<<<< HEAD
			if(count($detalle) === 0): 
=======
			// return $detalle;

			if(!$detalle): 
>>>>>>> AE
				$this -> actualizaEstatusSolicitud($data['id_solicitud'],1);
				return ;
			endif;

			for($i=0;$i<count($detalle); $i++): 
				if($detalle[$i] -> estatus === 0):
					$cero++;
				elseif($detalle[$i] -> estatus === 1):
					$uno++;
				elseif($detalle[$i] -> estatus === 2):
					$dos++;
				elseif($detalle[$i] -> estatus === 3):
					$tres++;
				elseif($detalle[$i] -> estatus === 4):
					$cuatro++;
				endif;
			endfor;
			
			if($cero > 0):
				// return "ACTUALIZA A UNO";
				$this -> actualizaEstatusSolicitud($data['id_solicitud'],1);
			elseif($uno > 0):
				// return "ACTUALIZA A UNO DOS";
				$this -> actualizaEstatusSolicitud($data['id_solicitud'],1);
			elseif($dos > 0):
				// return "ACTUALIZA A DOS";
				$this -> actualizaEstatusSolicitud($data['id_solicitud'],2);
			elseif($tres > 0):
				// return "ACTUALIZA A TRES";
				$this -> actualizaEstatusSolicitud($data['id_solicitud'],3);
			elseif($cuatro > 0):
				// return "ACTUALIZA A CUATRO";
				$this -> actualizaEstatusSolicitud($data['id_solicitud'],4);
			endif;
<<<<<<< HEAD
=======

>>>>>>> AE
		}

		public function actualizaEstatusSolicitud($id_solicitud, $estatus){
			DB::update('UPDATE solicitudes SET estatus=:estatus 
										WHERE id=:id',['estatus' => $estatus, 'id' => $id_solicitud]);
<<<<<<< HEAD
		}

	//! *************************** FUNCIONES PARA CANCELAR SOLICITUD **********************************
		public function ValidaCancelacionSol(Request $req){
=======
			
		}

	//! *************************** FUNCIONES PARA CANCELAR SOLICITUD **********************************
		public function ValidaCancelacion(Request $req){
>>>>>>> AE
			$detalle = $this -> DetalleSolicitud($req -> id_solicitud);
			$Evaluacion = [];

			for($i=0;$i<count($detalle); $i++):
<<<<<<< HEAD
				$movimientos = $this -> consultaMovimientos( $detalle[$i] -> id);
=======
				$movimientos = $this -> consultaMovimientos($detalle[$i] -> tipo_prod, $detalle[$i] -> id );
>>>>>>> AE
				$evaluacion  = $this -> evaluaCancelacion($movimientos);
				array_push($Evaluacion,  $evaluacion);
			endfor;
			
			if($this -> evaluarRespuestaCancelacion($Evaluacion) ):
<<<<<<< HEAD
				$cancelarSol = $this -> cancelarSolicitud($req);
				return $cancelarSol ? response("La solicitud se ha cancelado correctamente",200) :
													response("Ocurrio un problema, intentelo nuevamente",500);
=======
				$this -> cancelarSolicitud($req);
				return response("La solicitud se ha cancelado correctamente",200);
>>>>>>> AE
			else:
				return response("La solicitud no se puede cancelar ya que otro usuario lo está atendiendo",403);
			endif;

		}
<<<<<<< HEAD
		public function consultaMovimientos($id_det_sol){
			$movim = DB::select('SELECT * FROM movim_sol WHERE id_det_sol=? ',[$id_det_sol]);
			// $movim = DB::select('SELECT * FROM movim_sol WHERE px=? AND id_px =? ',[$px, $id_px]);
=======
		public function consultaMovimientos($px, $id_px){
			$movim = DB::select('SELECT * FROM movim_sol WHERE px=? AND id_px =? ',[$px, $id_px]);
>>>>>>> AE
			return $movim ? $movim: $movim = [];
		}
		public function evaluaCancelacion($movimientos){
			$errores = 0;
			if(count($movimientos) === 0): 
				return true;
			endif;

			for($i=0;$i<count($movimientos);$i++):
				if($movimientos[$i] -> estatus != 4 ):
					$errores++;
				endif; 
			endfor;

			return $errores === 0 ? true : false;
		}
		public function evaluarRespuestaCancelacion($Evaluacion){
			$errores=0;
			for($i=0;$i<count($Evaluacion);$i++):
				if($Evaluacion[$i] === false):
					$errores++;
				endif;
			endfor;
			
			return $errores === 0 ? true : false;
<<<<<<< HEAD
		}
		public function cancelarSolicitud(Request $req){
			$estatusSol = DB::update('UPDATE solicitudes SET estatus=:estatus WHERE id=:id',
																			[ 'estatus' => $req -> estatus, 
																				'id' 		  => $req -> id_solicitud  
																			]);
			return $estatusSol? true: false;
=======

		}
		public function cancelarSolicitud(Request $req){
			DB::update('UPDATE solicitudes SET estatus=:estatus WHERE id=:id',
																			[ 'estatus' => $req -> estatus, 
																				'id' 		  => $req -> id_solicitud  
																			]);
>>>>>>> AE
		}	
	//! *************************** FUNCIONES PARA CANCELAR PARTIDA **********************************

		public function ValidaCancelacionPartida(Request $req){
			$Evaluacion = [];
<<<<<<< HEAD
			$movimientos = $this -> consultaMovimientos($req -> id);
=======
			$movimientos = $this -> consultaMovimientos($req -> tipo_prod, $req -> id );

>>>>>>> AE
			$evaluacion  = $this -> evaluaCancelacion($movimientos);
			array_push($Evaluacion,  $evaluacion);
			
			if($this -> evaluarRespuestaCancelacion($Evaluacion) ):
<<<<<<< HEAD
				$detalle  = ["id" => $req -> id, "estatus" => $req -> estatus ];   //  SE FORMA OBJETO PARA PODER ACTUALIZAR EL DETALLE
				if($estatus = $this -> actualizaEstatusDetSol($detalle)):
					$solicitud  = ["id_solicitud" => $req -> id_solicitud ]; //  SE FORMA OBJETO PARA PODER ACTUALIZAR EL ESTATUS
				  $this -> validaEstatusSolicitud($solicitud);
					return response("La partida se ha cancelado correctamente",200);
				else:
					return response("Ocurrio un problema, intentelo nuevamente",500);
				endif;
				
			else:
				return response("La partida no se puede cancelar ya que otro usuario lo está atendiendo",403);
			endif;
		}

		public function actualizaEstatusDetSol($data){
			 $estatusDelSol = DB::update('UPDATE det_sol SET estatus=:estatus 
																			WHERE id=:id',['estatus' => $data['estatus'], 
																										 'id' 		 => $data['id'] ]);
			return $estatusDelSol ? true : false; 
		}

		public function ActualizaEstatusResult(Request $req ){
			$actualiza = DB::update('UPDATE movim_sol SET estatus=:estatus WHERE id=:id', 
																			[ 'estatus'  => $req -> estatus, 
																				'id' 		   => $req -> id  
																			]);
			
			$this -> validaEstatusMovim($req);
			$this -> validaEstatusSolicitud($req);
			return $actualiza? response('Se finalizo correctamente.',200):
			 									 response('Ocurrio un error intentalo mas tarde.',500);
		}
			// public function CancelarMovimiento(Request $req){
			// 	$movimiento = DB::update('UPDATE movim_sol SET estatus=:estatus WHERE id=:id',
			// 																	[ 'estatus' => $req -> estatus, 
			// 																		'id' 		  => $req -> id  
			// 																	]);
			// 	return $movimiento ? response("La cancelación se proceso correctamente",200):
			// 							         response("Ocurrio un error, intentelo mas",403);
			// }
=======
				if($req -> tipo_prod === 1):
					$this -> actualizaEstatusProdExist($req);
				endif;
				if($req -> tipo_prod === 2):
					$this -> actualizaEstatusModif($req);
				endif;
				if($req -> tipo_prod === 3):
					$this -> actualizaEstatusProdNuevo($req);
				endif;

				return response("La partida se ha cancelado correctamente",200);
			else:
				return response("La solicitud no se puede cancelar ya que otro usuario lo está atendiendo",403);
			endif;

		}
		public function CancelarMovimiento(Request $req){
			$movimiento = DB::update('UPDATE movim_sol SET estatus=:estatus WHERE id=:id',
																			[ 'estatus' => $req -> estatus, 
																				'id' 		  => $req -> id  
																			]);
			return $movimiento ? response("La cancelación se proceso correctamente",200):
									         response("Ocurrio un error, intentelo mas",403);
		}

	
		
>>>>>>> AE

}


