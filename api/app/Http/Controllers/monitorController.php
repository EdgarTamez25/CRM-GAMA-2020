<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //USAR ESCRITURA SQL


class monitorController extends Controller
{
    
    public function ObtenerDatosMonitor(Request $req){

    	$Monitor = DB::select('SELECT do.id, do.partida, do.id_ot, ot.id_cliente, c.nombre as nomcli, do.id_depto,
																    do.id_producto, p.codigo, do.id_sucursal, s.nombre as nomsuc, do.cantidad, 
															      do.fecha_progra, do.fecha_entrega,do.concepto, do.urgencia, do.razon, 
															      do.estatus, u.nombre as solicitante
															FROM det_ot do LEFT JOIN ot 		ON do.id_ot = ot.id
																					   LEFT JOIN clientes c   ON ot.id_cliente = c.id
																					   LEFT JOIN prodxcli p   ON do.id_producto = p.id
																					   LEFT JOIN sucursales s ON do.id_sucursal = s.id
															               LEFT JOIN users u      ON ot.id_solicitante = u.id
															WHERE do.estatus = ? AND do.id_depto = ? AND do.creacion BETWEEN ? AND ? ORDER BY do.id DESC',
			[$req -> estatus, $req -> id_depto, $req -> fecha1, $req -> fecha2 ]);

			return $Monitor ? $Monitor : [];
    }
    public function ProgramarProductos(Request $req){
    	for($i=0;$i<count($req -> detalle);$i++ ):

				if($req -> detalle[$i]['id_depto'] === 1): // FLEXOGRAFIA
					$this -> insertarFlexoOT($req , $req -> detalle[$i]);
					$this -> actualizaDetOT($req -> detalle[$i]['id'], 2 , $req -> creacion );
					$this -> actualizaSucursal($req -> detalle[$i]['id'], $req -> id_sucursal);
				endif;
				if($req -> detalle[$i]['id_depto'] === 2): // BORDADOS
					$this -> insertarBordadosOT($req , $req -> detalle[$i]);
					$this -> actualizaDetOT($req -> detalle[$i]['id'], 2, $req -> creacion);
					$this -> actualizaSucursal($req -> detalle[$i]['id'], $req -> id_sucursal);
				endif;
				if($req -> detalle[$i]['id_depto'] === 3): // DIGITAL
					$this -> insertarDigitalOT($req , $req -> detalle[$i]);
					$this -> actualizaDetOT($req -> detalle[$i]['id'], 2, $req -> creacion);
					$this -> actualizaSucursal($req -> detalle[$i]['id'], $req -> id_sucursal);
				endif;
				if($req -> detalle[$i]['id_depto'] === 4): // OFFSET
					$this -> insertarOffsetOT($req , $req -> detalle[$i]);
					$this -> actualizaDetOT($req -> detalle[$i]['id'], 2, $req -> creacion);
					$this -> actualizaSucursal($req -> detalle[$i]['id'], $req -> id_sucursal);
				endif;
				if($req -> detalle[$i]['id_depto'] === 5): // SERIGRAFIA
					$this -> insertarSerigrafiaOT($req , $req -> detalle[$i]);
					$this -> actualizaDetOT($req -> detalle[$i]['id'], 2, $req -> creacion);
					$this -> actualizaSucursal($req -> detalle[$i]['id'], $req -> id_sucursal);
				endif;
				if($req -> detalle[$i]['id_depto'] === 6): // EMPAQUE
					$this -> insertarEmpaqueOT($req , $req -> detalle[$i]);
					$this -> actualizaDetOT($req -> detalle[$i]['id'], 2, $req -> creacion);
					$this -> actualizaSucursal($req -> detalle[$i]['id'], $req -> id_sucursal);
				endif;
				if($req -> detalle[$i]['id_depto'] === 7): // SUBLIMACIÓN
					$this -> insertarSublimacionOT($req , $req -> detalle[$i]);
					$this -> actualizaDetOT($req -> detalle[$i]['id'], 2, $req -> creacion);
					$this -> actualizaSucursal($req -> detalle[$i]['id'], $req -> id_sucursal);
				endif;
				if($req -> detalle[$i]['id_depto'] === 8): // TAMPOGRAFÍA
					$this -> insertarTampografiaOT($req , $req -> detalle[$i]);
					$this -> actualizaDetOT($req -> detalle[$i]['id'], 2, $req -> creacion);
					$this -> actualizaSucursal($req -> detalle[$i]['id'], $req -> id_sucursal);
				endif;
				if($req -> detalle[$i]['id_depto'] === 9): // UV
					$this -> insertarUvOT($req , $req -> detalle[$i]);
					$this -> actualizaDetOT($req -> detalle[$i]['id'], 2, $req -> creacion);
					$this -> actualizaSucursal($req -> detalle[$i]['id'], $req -> id_sucursal);
				endif;
			endfor;
			return response("Los productos se programaron correctamente",200);
    }

  // ====================== INSERSIONES EN TABLAS           =================================================================
    public function insertarFlexoOT($data, $detalle){
    	$insertProducto = DB::table('flexo_ot')->insertGetId(
				[
						'id_det_ot'   => $detalle['id'],
						'creacion' 	  => $data['creacion'],
						'id_creador'  => $data['id_creador'],
						'id_sucursal' => $data['id_sucursal'],
						'urgencia' 		=> $detalle['urgencia']
				]
			);
    }
    public function insertarBordadosOT($data, $detalle){
    	$insertProducto = DB::table('bordados_ot')->insertGetId(
				[
						'id_det_ot'   => $detalle['id'],
						'creacion' 	  => $data['creacion'],
						'id_creador'  => $data['id_creador'],
						'id_sucursal' => $data['id_sucursal'],
						'urgencia' 		=> $detalle['urgencia']
				]
			);
    }
    public function insertarDigitalOT($data, $detalle){
    	$insertProducto = DB::table('digital_ot')->insertGetId(
				[
						'id_det_ot'   => $detalle['id'],
						'creacion' 	  => $data['creacion'],
						'id_creador'  => $data['id_creador'],
						'id_sucursal' => $data['id_sucursal'],
						'urgencia' 		=> $detalle['urgencia']
				]
			);
    }
    public function insertarOffsetOT($data, $detalle){
    	$insertProducto = DB::table('offset_ot')->insertGetId(
				[
						'id_det_ot'   => $detalle['id'],
						'creacion' 	  => $data['creacion'],
						'id_creador'  => $data['id_creador'],
						'id_sucursal' => $data['id_sucursal'],
						'urgencia' 		=> $detalle['urgencia']
				]
			);
    }
    public function insertarSerigrafiaOT($data, $detalle){
    	$insertProducto = DB::table('serigrafia_ot')->insertGetId(
				[
						'id_det_ot'   => $detalle['id'],
						'creacion' 	  => $data['creacion'],
						'id_creador'  => $data['id_creador'],
						'id_sucursal' => $data['id_sucursal'],
						'urgencia' 		=> $detalle['urgencia']
				]
			);
    }
    public function insertarEmpaqueOT($data, $detalle){
    	$insertProducto = DB::table('empaque_ot')->insertGetId(
				[
						'id_det_ot'   => $detalle['id'],
						'creacion' 	  => $data['creacion'],
						'id_creador'  => $data['id_creador'],
						'id_sucursal' => $data['id_sucursal'],
						'urgencia' 		=> $detalle['urgencia']
				]
			);
    }
    public function insertarSublimacionOT($data, $detalle){
    	$insertProducto = DB::table('sublimacion_ot')->insertGetId(
				[
						'id_det_ot'   => $detalle['id'],
						'creacion' 	  => $data['creacion'],
						'id_creador'  => $data['id_creador'],
						'id_sucursal' => $data['id_sucursal'],
						'urgencia' 		=> $detalle['urgencia']
				]
			);
    }
    public function insertarTampografiaOT($data, $detalle){
    	$insertProducto = DB::table('tampografia_ot')->insertGetId(
				[
						'id_det_ot'   => $detalle['id'],
						'creacion' 	  => $data['creacion'],
						'id_creador'  => $data['id_creador'],
						'id_sucursal' => $data['id_sucursal'],
						'urgencia' 		=> $detalle['urgencia']
				]
			);
    }
    public function insertarUvOT($data, $detalle){
    	$insertProducto = DB::table('uv_ot')->insertGetId(
				[
						'id_det_ot'   => $detalle['id'],
						'creacion' 	  => $data['creacion'],
						'id_creador'  => $data['id_creador'],
						'id_sucursal' => $data['id_sucursal'],
						'urgencia' 		=> $detalle['urgencia']
				]
			);
    }
  // ====================== CONSULTA DE DATOS               =================================================================
    public function ObtenerPrograBordados(Request $req){
			$fecha2 = $req -> fecha2 .' '. $req -> horaActual;
    	$bordados = DB::select('SELECT b.id, b.id_det_ot, do.id_producto, p.codigo, do.cantidad, ot.id as id_ot, ot.id_cliente, c.nombre as nomcli,
																	  b.id_maquina, m.nombre as maquina,b.id_sucursal, b.urgencia, b.creacion, b.id_creador, b.finalizacion, b.estatus
																	FROM bordados_ot b LEFT JOIN det_ot do  ON b.id_det_ot = do.id
																					   				 LEFT JOIN prodxcli p ON do.id_producto= p.id
															                       LEFT JOIN ot 		    ON do.id_ot = ot.id 
															                       LEFT JOIN clientes c ON ot.id_cliente = c.id
															                       LEFT JOIN maquinas m ON b.id_maquina  = m.id
														  WHERE b.estatus = ? AND b.id_sucursal = ? AND b.creacion BETWEEN ? AND ? ORDER BY do.id DESC',
			[$req -> estatus, $req -> id_sucursal, $req -> fecha1, $fecha2 ]);
			
			return $bordados ? $bordados:[]; 
    }
    public function ObtenerPrograDigital(Request $req){
			$fecha2 = $req -> fecha2 .' '. $req -> horaActual;
    	$digital = DB::select('SELECT b.id, b.id_det_ot, do.id_producto, p.codigo, do.cantidad, ot.id as id_ot, ot.id_cliente, c.nombre as nomcli,
																	  b.id_maquina, m.nombre as maquina, b.id_sucursal, b.urgencia, b.creacion, b.id_creador, b.finalizacion, b.estatus
																	FROM digital_ot b  LEFT JOIN det_ot do  ON b.id_det_ot   = do.id
																					   				 LEFT JOIN prodxcli p ON do.id_producto= p.id
															                       LEFT JOIN ot 		    ON do.id_ot      = ot.id 
															                       LEFT JOIN clientes c ON ot.id_cliente = c.id
															                       LEFT JOIN maquinas m ON b.id_maquina  = m.id
														  WHERE b.estatus = ? AND b.id_sucursal = ? AND b.creacion BETWEEN ? AND ? ORDER BY do.id DESC',
			[$req -> estatus, $req -> id_sucursal, $req -> fecha1, $fecha2 ]);
			
			return $digital ? $digital:[]; 
    }
    public function ObtenerPrograOffset(Request $req){
			$fecha2 = $req -> fecha2 .' '. $req -> horaActual;
    	$offset = DB::select('SELECT b.id, b.id_det_ot, do.id_producto, p.codigo, do.cantidad, ot.id as id_ot, ot.id_cliente, c.nombre as nomcli,
																	  b.id_maquina,m.nombre as maquina, b.id_sucursal, b.urgencia, b.creacion, b.id_creador, b.finalizacion, b.estatus
																	FROM offset_ot b   LEFT JOIN det_ot do  ON b.id_det_ot   = do.id
																					   				 LEFT JOIN prodxcli p ON do.id_producto= p.id
															                       LEFT JOIN ot 		    ON do.id_ot      = ot.id 
															                       LEFT JOIN clientes c ON ot.id_cliente = c.id
															                       LEFT JOIN maquinas m ON b.id_maquina  = m.id
														  WHERE b.estatus = ? AND b.id_sucursal = ? AND b.creacion BETWEEN ? AND ? ORDER BY do.id DESC',
			[$req -> estatus, $req -> id_sucursal, $req -> fecha1, $fecha2 ]);
			
			return $offset ? $offset:[]; 
    }
    public function ObtenerPrograSerigrafia(Request $req){
			$fecha2 = $req -> fecha2 .' '. $req -> horaActual;
    	$serigrafia = DB::select('SELECT b.id, b.id_det_ot, do.id_producto, p.codigo, do.cantidad, ot.id as id_ot, ot.id_cliente, c.nombre as nomcli,
																	  b.id_maquina,m.nombre as maquina, b.id_sucursal, b.urgencia, b.creacion, b.id_creador, b.finalizacion, b.estatus
																	FROM serigrafia_ot b LEFT JOIN det_ot do  ON b.id_det_ot   = do.id
																						   				 LEFT JOIN prodxcli p ON do.id_producto= p.id
																                       LEFT JOIN ot 		    ON do.id_ot      = ot.id 
																                       LEFT JOIN clientes c ON ot.id_cliente = c.id
																                       LEFT JOIN maquinas m ON b.id_maquina  = m.id
														  WHERE b.estatus = ? AND b.id_sucursal = ? AND b.creacion BETWEEN ? AND ? ORDER BY do.id DESC',
			[$req -> estatus, $req -> id_sucursal, $req -> fecha1, $fecha2 ]);
			
			return $serigrafia ? $serigrafia:[]; 
    }
    public function ObtenerPrograEmpaque(Request $req){
			$fecha2 = $req -> fecha2 .' '. $req -> horaActual;
    	$empaque = DB::select('SELECT b.id, b.id_det_ot, do.id_producto, p.codigo, do.cantidad, ot.id as id_ot, ot.id_cliente, c.nombre as nomcli,
																	  b.id_maquina,m.nombre as maquina,b.id_sucursal, b.urgencia, b.creacion, b.id_creador, b.finalizacion, b.estatus
																	FROM empaque_ot b LEFT JOIN det_ot do  ON b.id_det_ot   = do.id
																				   				  LEFT JOIN prodxcli p ON do.id_producto= p.id
														                        LEFT JOIN ot 		     ON do.id_ot      = ot.id 
														                        LEFT JOIN clientes c ON ot.id_cliente = c.id
															                      LEFT JOIN maquinas m ON b.id_maquina  = m.id
														  WHERE b.estatus = ? AND b.id_sucursal = ? AND b.creacion BETWEEN ? AND ? ORDER BY do.id DESC',
			[$req -> estatus, $req -> id_sucursal, $req -> fecha1, $fecha2 ]);
			
			return $empaque ? $empaque:[]; 
    }
    public function ObtenerPrograSublimacion(Request $req){
			$fecha2 = $req -> fecha2 .' '. $req -> horaActual;
    	$sublimacion = DB::select('SELECT b.id, b.id_det_ot, do.id_producto, p.codigo, do.cantidad, ot.id as id_ot, ot.id_cliente, c.nombre as nomcli,
																	  b.id_maquina,m.nombre as maquina,b.id_sucursal, b.urgencia, b.creacion, b.id_creador, b.finalizacion, b.estatus
																	FROM sublimacion_ot b LEFT JOIN det_ot do  ON b.id_det_ot   = do.id
																						   				  LEFT JOIN prodxcli p ON do.id_producto= p.id
																                        LEFT JOIN ot 		     ON do.id_ot      = ot.id 
																                        LEFT JOIN clientes c ON ot.id_cliente = c.id
																                        LEFT JOIN maquinas m ON b.id_maquina  = m.id
														  WHERE b.estatus = ? AND b.id_sucursal = ? AND b.creacion BETWEEN ? AND ? ORDER BY do.id DESC',
			[$req -> estatus, $req -> id_sucursal, $req -> fecha1, $fecha2 ]);
			
			return $sublimacion ? $sublimacion:[]; 
    }
    public function ObtenerPrograTampografia(Request $req){
			$fecha2 = $req -> fecha2 .' '. $req -> horaActual;
    	$tampografia = DB::select('SELECT b.id, b.id_det_ot, do.id_producto, p.codigo, do.cantidad, ot.id as id_ot, ot.id_cliente, c.nombre as nomcli,
																	  b.id_maquina,m.nombre as maquina,b.id_sucursal, b.urgencia, b.creacion, b.id_creador, b.finalizacion, b.estatus
																	FROM tampografia_ot b LEFT JOIN det_ot do  ON b.id_det_ot   = do.id
																					   				    LEFT JOIN prodxcli p ON do.id_producto= p.id
															                          LEFT JOIN ot 		     ON do.id_ot      = ot.id 
															                          LEFT JOIN clientes c ON ot.id_cliente = c.id
																                        LEFT JOIN maquinas m ON b.id_maquina  = m.id
														  WHERE b.estatus = ? AND b.id_sucursal = ? AND b.creacion BETWEEN ? AND ? ORDER BY do.id DESC',
			[$req -> estatus, $req -> id_sucursal, $req -> fecha1, $fecha2 ]);
			
			return $tampografia ? $tampografia:[]; 
    }
    public function ObtenerPrograUV(Request $req){
			$fecha2 = $req -> fecha2 .' '. $req -> horaActual;
    	$uv = DB::select('SELECT b.id, b.id_det_ot, do.id_producto, p.codigo, do.cantidad, ot.id as id_ot, ot.id_cliente, c.nombre as nomcli,
																	  b.id_maquina,m.nombre as maquina,b.id_sucursal, b.urgencia, b.creacion, b.id_creador, b.finalizacion, b.estatus
																	FROM uv_ot b LEFT JOIN det_ot do  ON b.id_det_ot   = do.id
																		   				 LEFT JOIN prodxcli p ON do.id_producto= p.id
												                       LEFT JOIN ot 		    ON do.id_ot      = ot.id 
												                       LEFT JOIN clientes c ON ot.id_cliente = c.id
													                     LEFT JOIN maquinas m ON b.id_maquina  = m.id
														  WHERE b.estatus = ? AND b.id_sucursal = ? AND b.creacion BETWEEN ? AND ? ORDER BY do.id DESC',
			[$req -> estatus, $req -> id_sucursal, $req -> fecha1, $fecha2 ]);
			return $uv ? $uv:[]; 
    }
  // ====================== ACTUALIZAR ESTATUS DETALLE O.T. =================================================================
    public function actualizaDetOT($id, $estatus, $fecha){
    	DB::update('UPDATE det_ot SET  estatus=:estatus, fecha_progra=:fecha_progra 
										WHERE id=:id',['estatus' => $estatus, 'fecha_progra' => $fecha, 'id' => $id]);
    }
		public function actualizaSucursal($id, $id_sucursal){
    	DB::update('UPDATE det_ot SET  id_sucursal=:id_sucursal WHERE id=:id',['id_sucursal' => $id_sucursal, 'id' => $id]);
    }
  // ====================== ACTUAIZACION DE MAQUINAS        =================================================================

    public function ActualizaMaquinaBordados($id, Request $req){
    	DB::update('UPDATE bordados_ot SET  id_maquina=:id_maquina WHERE id=:id',['id_maquina' => $req -> id_maquina, 'id' => $id]);
    }
    public function ActualizaMaquinaDigital($id, Request $req){
    	DB::update('UPDATE digital_ot SET  id_maquina=:id_maquina WHERE id=:id',['id_maquina' => $req -> id_maquina, 'id' => $id]);
    }
    public function ActualizaMaquinaOffset($id, Request $req){
    	DB::update('UPDATE offset_ot SET  id_maquina=:id_maquina WHERE id=:id',['id_maquina' => $req -> id_maquina, 'id' => $id]);
    }
    public function ActualizaMaquinaSerigrafia($id, Request $req){
    	DB::update('UPDATE serigrafia_ot SET  id_maquina=:id_maquina WHERE id=:id',['id_maquina' => $req -> id_maquina, 'id' => $id]);
    }
    public function ActualizaMaquinaEmpaque($id, Request $req){
    	DB::update('UPDATE empaque_ot SET  id_maquina=:id_maquina WHERE id=:id',['id_maquina' => $req -> id_maquina, 'id' => $id]);
    }
    public function ActualizaMaquinaSublimacion($id, Request $req){
    	DB::update('UPDATE sublimacion_ot SET  id_maquina=:id_maquina WHERE id=:id',['id_maquina' => $req -> id_maquina, 'id' => $id]);
    }
    public function ActualizaMaquinaTampografia($id, Request $req){
    	DB::update('UPDATE tampografia_ot SET  id_maquina=:id_maquina WHERE id=:id',['id_maquina' => $req -> id_maquina, 'id' => $id]);
    }
    public function ActualizaMaquinaUV($id, Request $req){
    	DB::update('UPDATE uv_ot SET  id_maquina=:id_maquina WHERE id=:id',['id_maquina' => $req -> id_maquina, 'id' => $id]);
    }
  // ====================== FINALIZACION DE MAQUINAS        =================================================================
		public function FinalizaProdFlexo(Request $req){
    	$finFlexo = DB::update('UPDATE flexo_ot SET  finalizacion=:finalizacion WHERE id=:id',
    		['finalizacion' => $req -> finalizacion,'id' => $req -> id]);
    	$this -> actualizaDetOT($req -> id_det_ot , 3);
    	$this -> verificarEstatusOT($req -> id_ot);
    	return $finFlexo ? response('Se finalizo correctamente',200): 
    										 response('Ocurrio un error, intentelo mas tarde.',500);
    }
    public function FinalizaProdBordados(Request $req){
    	$finBordado = DB::update('UPDATE bordados_ot SET  finalizacion=:finalizacion, estatus=:estatus WHERE id=:id',
    		['finalizacion' => $req -> finalizacion, 'estatus' => $req -> estatus, 'id' => $req -> id]);
    	$this -> actualizaDetOT($req -> id_det_ot , 3);
    	$this -> verificarEstatusOT($req -> id_ot);
    	return $finBordado ? response('Se finalizo correctamente',200): 
    											 response('Ocurrio un error, intentelo mas tarde.',500);
    }
    public function FinalizaProdDigital(Request $req){
    	$finDigital = DB::update('UPDATE digital_ot SET  finalizacion=:finalizacion, estatus=:estatus WHERE id=:id',
    		['finalizacion' => $req -> finalizacion, 'estatus' => $req -> estatus, 'id' => $req -> id]);
    	$this -> actualizaDetOT($req -> id_det_ot , 3);
    	$this -> verificarEstatusOT($req -> id_ot);
    	return $finDigital ? response('Se finalizo correctamente',200): 
    											 response('Ocurrio un error, intentelo mas tarde.',500);
    }
    public function FinalizaProdOffset(Request $req){
    	$finOffset = DB::update('UPDATE offset_ot SET  finalizacion=:finalizacion, estatus=:estatus WHERE id=:id',
    		['finalizacion' => $req -> finalizacion, 'estatus' => $req -> estatus, 'id' => $req -> id]);
    	$this -> actualizaDetOT($req -> id_det_ot , 3);
    	$this -> verificarEstatusOT($req -> id_ot);
    	return $finOffset ? response('Se finalizo correctamente',200): 
    											 response('Ocurrio un error, intentelo mas tarde.',500);
    }
    public function FinalizaProdSerigrafia(Request $req){
    	$finSerigrafia = DB::update('UPDATE serigrafia_ot SET  finalizacion=:finalizacion, estatus=:estatus WHERE id=:id',
    		['finalizacion' => $req -> finalizacion, 'estatus' => $req -> estatus, 'id' => $req -> id]);
    	$this -> actualizaDetOT($req -> id_det_ot , 3);
    	$this -> verificarEstatusOT($req -> id_ot);
    	return $finSerigrafia ? response('Se finalizo correctamente',200): 
    											 response('Ocurrio un error, intentelo mas tarde.',500);
    }
    public function FinalizaProdEmpaque(Request $req){
    	$finEmpaque = DB::update('UPDATE empaque_ot SET  finalizacion=:finalizacion, estatus=:estatus WHERE id=:id',
    		['finalizacion' => $req -> finalizacion, 'estatus' => $req -> estatus, 'id' => $req -> id]);
    	$this -> actualizaDetOT($req -> id_det_ot , 3);
    	$this -> verificarEstatusOT($req -> id_ot);
    	return $finEmpaque ? response('Se finalizo correctamente',200): 
    											 response('Ocurrio un error, intentelo mas tarde.',500);
    }
    public function FinalizaProdSublimacion(Request $req){
    	$finSublimacion = DB::update('UPDATE sublimacion_ot SET  finalizacion=:finalizacion, estatus=:estatus WHERE id=:id',
    		['finalizacion' => $req -> finalizacion, 'estatus' => $req -> estatus, 'id' => $req -> id]);
    	$this -> actualizaDetOT($req -> id_det_ot , 3);
    	$this -> verificarEstatusOT($req -> id_ot);
    	return $finSublimacion ? response('Se finalizo correctamente',200): 
    											 response('Ocurrio un error, intentelo mas tarde.',500);
    }
    public function FinalizaProdTampografia(Request $req){
    	$finTampografia = DB::update('UPDATE tampografia_ot SET  finalizacion=:finalizacion, estatus=:estatus WHERE id=:id',
    		['finalizacion' => $req -> finalizacion, 'estatus' => $req -> estatus, 'id' => $req -> id]);
    	$this -> actualizaDetOT($req -> id_det_ot , 3);
    	$this -> verificarEstatusOT($req -> id_ot);
    	return $finTampografia ? response('Se finalizo correctamente',200): 
    											 response('Ocurrio un error, intentelo mas tarde.',500);
    }
    public function FinalizaProdUV(Request $req){
    	$finUV = DB::update('UPDATE uv_ot SET  finalizacion=:finalizacion, estatus=:estatus WHERE id=:id',
    		['finalizacion' => $req -> finalizacion, 'estatus' => $req -> estatus, 'id' => $req -> id]);
    	$this -> actualizaDetOT($req -> id_det_ot , 3);
    	$this -> verificarEstatusOT($req -> id_ot);
    	return $finUV ? response('Se finalizo correctamente',200): 
    											 response('Ocurrio un error, intentelo mas tarde.',500);
    }

  // ====================== VERIFICAR ESTATUS O.T. ==========================================================================
    public function verificarEstatusOT($id_ot){
    	$error = 0;
    	$detalle = DB::select('SELECT * FROM det_ot WHERE id_ot = ?', [ $id_ot]);
    	for($i=0;$i<count($detalle);$i++ ):
    		if(!$detalle[$i] -> estatus === 2):
    			$error++;
    		endif;
    	endfor;

    	if($error === 0):
    		DB::update('UPDATE ot SET  estatus=:estatus WHERE id=:id',['estatus' => 3, 'id' => $id_ot]);
    	endif;
    }

   
}
