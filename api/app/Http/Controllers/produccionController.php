<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\OTContrller; 

// use App\Http\Controllers\OtroController;

class produccionController extends Controller{

    public function obtenerMovimProd(){
        $produccion = DB::select('SELECT * FROM movim_prod WHERE estatus = 1');
        return $produccion;
    }

    public function actualizarMovimProd($id, Request $req){
        $actualizar = DB::update('UPDATE movim_prod
                                    SET
                                            id_produccion=:id_produccion,       id_depto=:id_depto,
                                            id_sucursal=:id_sucursal,           id_producto=:id_producto,
                                            cant_sol=:cant_sol,                 recibidas=:recibidas,
                                            terminadas=:terminadas,             creacion=:creacion,
                                            estatus_prod=:estatus_prod,         estatus=:estatus
                                    WHERE   id=:id',
            [
                'id_produccion' => $req->id_produccion,
                'id_depto' => $req->id_depto,
                'id_sucursal' => $req->id_sucursal,
                'id_producto' => $req->id_producto,
                'cant_sol' => $req->cant_sol,
                'recibidas' => $req->recibidas,
                'terminadas' => $req->terminadas,
                'creacion' => $req->creacion,
                'estatus_prod' => $req->estatus_prod,
                'estatus' => $req->estatus,
                'id' => $req->id
            ]);
        if ($actualizar):
            return response("Se actualizo el registro de movimiento de produccion correctamente", 200);
        else:
            return response("Ocurrio un problema al actualizar el registro de movimiento de produccion, por favor intentelo mas tarde.", 500);
        endif;
    }

    public function obtener_datos_produccion(Request $req){

			$produccion = DB::select('SELECT m.*,
																			us.nombre  as nomemisor,
																			us2.nombre as nomreceptor,
																			d.nombre   as deptoemisor,
																			d2.nombre  as deptoreceptor,
																			a.codigo,
																			u.nombre as nomunidad,
																			p.fecha_entrega, p.urgencia,
																			dt.id as id_det_ot, dt.id_ot, dt.comentarios,
																			ot.id_cliente,
																			us3.nombre as creador,
																			c.nombre as nomcli,
																			DATEDIFF(p.fecha_entrega, NOW()) as dias
																	FROM movim_prod m
																			LEFT JOIN users         us ON m.id_usr_emisor = us.id
																			LEFT JOIN users    	   us2 ON m.id_usr_receptor = us2.id
																			LEFT JOIN depto_por_suc  d ON m.emisor = d.id
																			LEFT JOIN depto_por_suc d2 ON m.receptor = d2.id
																			LEFT JOIN prodxcli       a ON m.id_producto = a.id
																			LEFT JOIN unidades       u ON a.id_unidad = u.id
																			LEFT JOIN produccion     p ON m.id_produccion = p.id
																			LEFT JOIN det_ot        dt ON p.id_det_ot = dt.id
																			LEFT JOIN ot  		   	   ON dt.id_ot = ot.id
																				LEFT JOIN users    	   us3 ON ot.id_creador = us3.id
																			LEFT JOIN clientes       c ON ot.id_cliente = c.id
																	WHERE m.id_depto   = ? AND
																			m.estatus_prod = ? AND
																			m.creacion BETWEEN DATE(?) AND DATE(?)',
																			[
																					$req -> id_depto,
																					$req -> estatus,
																					$req -> fecha1,
																					$req -> fecha2
																			]);
				return $produccion ? $produccion: [];
    }

		public function iniciar_partida_movim(Request $req){
			$iniciar_partida = DB::update('UPDATE movim_prod SET fecha_inicio=:fecha_inicio, estatus_prod=:estatus_prod
																					WHERE id =:id',['fecha_inicio' => $req  ->  fecha_inicio,
																													'estatus_prod' => $req  ->  estatus_prod,
																													'id' 		 			 => $req  -> id_movim ]);

			return $iniciar_partida? response("La partida se inicio correctamente",200):
															 response("Ocurrio un error, intentelo de nuevo.",500);

		}


	// **************** AUTORIZAR ENVIO DE PRODUCTO *****************************
		public function autorizar_envio_material(Request $req){

			$id_movim_prod = DB::table('movim_prod')->insertGetId(
				[
					'id_produccion' => $req -> id_produccion,
					'id_movim_ant'  => $req -> id_movim,
					'id_depto' 		  => $req -> id_nuevo_depto,
					'id_sucursal'   => $req -> id_sucursal,
					'id_producto'   => $req -> id_producto,
					'cant_sol'      => $req -> cant_sol,
					'tipo_prog'     => $req -> tipo_prog,
					'id_usr_emisor' => $req -> id_usr_emisor,
					'emisor'        => $req -> emisor,
					'enviadas'      => $req -> enviadas,
					'creacion' 			=> $req -> creacion,
					'estatus_prod'  => $req -> estatus_prod,
				]
			);

			$this -> actualiza_movim_anterior($req -> id_movim, $req -> enviadas, $req -> id_usr_emisor);

			return $id_movim_prod? response("El producto se ha envíado correctamente.",200):
														 response("Ocurrio un error, intentelo nuevamente.",500);

		}
	// ! ************************************************************************

	// **************** AUTORIZAR RECIBO DE PRODUCTO ****************************
		public function autorizar_recibo_material(Request $req){
			$recibo_material = DB::update('UPDATE movim_prod
																			SET
																							id_usr_receptor=:id_usr_receptor,
																							receptor=:receptor,
																							recibidas=:recibidas,
																							estatus_prod=:estatus_prod
																			WHERE   id=:id',
							[
								'id_usr_receptor' => $req -> id_usr_receptor,
								'receptor' 			  => $req -> receptor,
								'recibidas' 			=> $req -> recibidas,
								'estatus_prod' 		=> $req -> estatus_prod,
								'id' 							=> $req -> id_movim
							]);
			return $recibo_material ? response("El producto se recibio correctamente.", 200):
																response("Ocurrio un problema , por favor intentelo mas tarde.", 500);
		}
	// ! ************************************************************************

	// **************** AUTORIZAR REPOSICION ************************************
		public function autorizar_reposicion_material(Request $req){
			$descuento = $req -> reposicion;
			$terminado = DB::update('UPDATE movim_prod SET 
																 terminadas=terminadas - :terminadas ,
		 														 reposicion=:reposicion + reposicion,
		 														 id_actualiza=:id_actualiza,
																 estatus_prod=:estatus_prod
		 														WHERE id=:id',
														[
															'terminadas' => $req -> reposicion,
															'reposicion' => $req -> reposicion,
															'id_actualiza' => $req -> id_usuario,
															'estatus_prod' => 2,
															'id' => $req -> id_movim_ant
														]);
			return $terminado ? response("La reposición se genero correctamente",200):
														response("Ocurrio un error, intentelo mas tarde",500);

		}

		public function actualiza_movim_anterior($id, $terminadas, $id_usuario){
			$actualizar = DB::update('UPDATE movim_prod SET 
																 terminadas=:terminadas + terminadas,
																 id_actualiza=:id_actualiza
																WHERE id=:id',
            [
                'terminadas' => $terminadas,
								'id_actualiza' => $id_usuario,
                'id' => $id
            ]);
		
		}
	// ! ************************************************************************
	
	// **************** FINALIZACION DE MOVIMIENTO ******************************
		public function finalizar_partida_movim(Request $req){
			$actualizar = DB::update('UPDATE movim_prod
                                    SET finalizacion=:finalizacion,
                                        estatus_prod=:estatus_prod
                                    WHERE   id=:id',
            [
                'finalizacion' => $req -> finalizacion,
                'estatus_prod' => 3,
                'id' => $req -> id_movim
            ]);

			$this -> validar_estatus_movimientos($req); // VERIFICAR EL ESTATUS DE PRODUCCION
			$this -> evaluaEstatusPartida($req);        // VERIFICAR EL ESTATUS DEL DETALLE DE LA ORDEN
			$this -> verificarEstatusOT($req -> id_ot); // VERIFICAR EL ESTATUS DE LA ORDEN DE TRABAJO
			return $actualizar ? response("La partida se finalizo correctamente", 200):
													 response("Ocurrio un error, intentelo mas tarde", 500);
		}
	// ! ************************************************************************

	// **************** PRODUCTOS ENVIADOS **************************************
		public function obtener_productos_enviados(Request $req){
			$prod_enviados =  DB::select('SELECT m.*,
																					us.nombre  as nomemisor,
																					us2.nombre as nomreceptor,
																					d.nombre   as deptoemisor,
																					d2.nombre  as deptoreceptor,
																					d3.nombre  as departamento,
																					a.codigo,
																					u.nombre as nomunidad,
																					p.fecha_entrega, p.urgencia,
																					dt.id_ot,
																					ot.id_cliente,
																					c.nombre as nomcli,
																					DATEDIFF(p.fecha_entrega, NOW()) as dias
																			FROM movim_prod m
																					LEFT JOIN users         us ON m.id_usr_emisor = us.id
																					LEFT JOIN users    	   us2 ON m.id_usr_receptor = us2.id
																					LEFT JOIN depto_por_suc  d ON m.emisor = d.id
																					LEFT JOIN depto_por_suc d2 ON m.receptor = d2.id
																					LEFT JOIN depto_por_suc d3 ON m.id_depto = d3.id
																					LEFT JOIN prodxcli       a ON m.id_producto = a.id
																					LEFT JOIN unidades       u ON a.id_unidad = u.id
																					LEFT JOIN produccion     p ON m.id_produccion = p.id
																					LEFT JOIN det_ot        dt ON p.id_det_ot = dt.id
																					LEFT JOIN ot  		   	     ON dt.id_ot = ot.id
																					LEFT JOIN clientes       c ON ot.id_cliente = c.id
																			WHERE m.emisor = ? AND m.creacion BETWEEN DATE(?) AND DATE(?)',
																					[
																							$req -> id_depto,
																							$req -> fecha1,
																							$req -> fecha2
																					]);
				return $prod_enviados ? $prod_enviados: [];
		}
	// ! ************************************************************************

	// **************** VALIDACION DE MOVIMIENTOS *******************************
		public function validar_estatus_movimientos($data){
			$cero=0;$uno=0; $dos=0; $tres=0; $cuatro=0; $movim=[];

			$movim = DB::select('SELECT * FROM movim_prod
														WHERE id_produccion =? AND id_producto = ?',
													[$data -> id_produccion, $data -> id_producto]);

			for($i=0;$i<count($movim); $i++):
				if($movim[$i] -> estatus_prod === 0 ):
					$cero++;
				elseif($movim[$i] -> estatus_prod === 1):
					$uno++;
				elseif($movim[$i] -> estatus_prod === 2):
					$dos++;
				elseif($movim[$i] -> estatus_prod === 3):
					$tres++;
				endif;
			endfor;

			if($cero > 0):
				$objetTemp  = ["id" => $data['id_produccion'], "estatus" => 1 ];
				$this -> actualizar_estatus_produccion($objetTemp);
			elseif($uno > 0):
				$objetTemp  = ["id" => $data['id_produccion'], "estatus" => 1 ];
				$this -> actualizar_estatus_produccion($objetTemp);
			elseif($dos > 0):
				$objetTemp  = ["id" => $data['id_produccion'], "estatus" => 1 ];
				$this -> actualizar_estatus_produccion($objetTemp);
			elseif($tres > 0):
				$objetTemp  = ["id" => $data['id_produccion'], "estatus" => 2 ];
				$this -> actualizar_estatus_produccion($objetTemp);
			endif;
		}

		// *** ACTUALIZAR ESTATUS DE PRODUCCION ***********************************
		public function actualizar_estatus_produccion($data){
		 $fecha_actual = date('Y-m-d h:i:s', time());
		 DB::update('UPDATE produccion SET finalizacion=:finalizacion, estatus=:estatus
									WHERE id =:id',['finalizacion' => $fecha_actual,
																	'estatus' => $data['estatus'],
																	'id' => $data['id']
																 ]);
		}
	// ! ************************************************************************

	// **************** ACTUALIZAR ESTATUS DE DETALLE DE PRODUCCION *************
		public function evaluaEstatusPartida($data){
				$uno=0; $dos=0; $prod=[];
				//consulta de objeto con los registros a evaluar
				$prod = DB::select('SELECT * FROM produccion WHERE id_det_ot =? ',
														[ $data -> id_det_ot ]);
				//ciclo de identificacion de estatus
				for($i=0;$i<count($prod); $i++):
						if($prod[$i] -> estatus === 1 ):
								$uno++;
						elseif($prod[$i] -> estatus === 2):
								$dos++;
						endif;
				endfor;
				//ciclo para establecer el estatus al cual se actualizara
				if($uno > 0):
						$tmp  = ["id" => $data['id_det_ot'], "estatus" => 2 ];
						$this -> actualizaEstatusDetOt($tmp);
				elseif($dos > 0):
						$tmp  = ["id" => $data['id_det_ot'], "estatus" => 3 ];
						$this -> actualizaEstatusDetOt($tmp);
				endif;
		}
	// **************** ACTUALIZAR ESTATUS DE ORDEN DE TRABAJO ******************
		public function actualizaEstatusDetOt($data){
			$fecha_actual = date('Y-m-d h:i:s', time());
			DB::update('UPDATE det_ot SET estatus=:estatus, finalizacion=:finalizacion
									WHERE id=:id',['estatus' => $data['estatus'],
																'finalizacion' => $fecha_actual, 
																'id' => $data['id'] 
																]);
		}

		public function verificarEstatusOT($id_ot){
			$error = 0;
			$detalle = DB::select('SELECT * FROM det_ot WHERE id_ot = ?', [$id_ot]);
			for($i=0;$i<count($detalle);$i++ ):
				if(!$detalle[$i] -> estatus === 2):
					$error++;
				endif;
			endfor;
	
			if($error === 0):
				DB::update('UPDATE ot SET  estatus=:estatus WHERE id=:id',['estatus' => 3, 'id' => $id_ot]);
			endif;
		}

		

	// ! ************************************************************************
}
