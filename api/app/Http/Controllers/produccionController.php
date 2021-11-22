<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Http\Controllers\OtroController;

class produccionController extends Controller{

    public function obtenerProgramacion(){
        $programacion = DB::select('SELECT * FROM produccion WHERE estatus = 1');
        return $programacion;
    }
	// ! ************************************************************************

        public function ciclaProgramacion(Request $req)
        {
                // return ($req->programacion[0]['depto']['id']);
                for ($i = 0; $i < count($req->programacion); $i++):
                        $id_produccion = $this->agregarProgramacion($req, $req->programacion[$i]['depto']['id'], $req->programacion[$i]['sucursal']['id']);
                        $this->agregarPrimerMov($req->programacion[$i], $id_produccion, $req->id_producto, $req->creacion);
                                                $this->actualizar_det_ot($req -> id_det_ot, $req -> creacion, 2);  // ACTUALIZAR DET_OT
                endfor;
                return response("Se programó correctamente", 200);
        }

    public function actualizaFechaProg($id_det_ot, $creacion, $estatus){
        $actualizaFechaProg = DB::update('UPDATE det_ot SET fecha_progra=:fecha_progra
                                          WHERE  id=:id',
                                          [
                                              'fecha_progra'  => $creacion,
                                              'estatus'       => $estatus,
                                              'id'            => $id_det_ot
                                          ]);
    }

    public function evaluaEstatusPartida($data){
        $uno=0; $dos=0; $prod=[];
        //consulta de objeto con los registros a evaluar
        $prod = DB::select('SELECT * FROM produccion WHERE id_det_ot =? ',
                            [
                                $data -> id_det_ot
                            ]);
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
            $tmp  = ["id" => $data['id_det_ot'], "estatus" => 1 ];
            $this -> actualizaEstatusDetOt($tmp);
        elseif($dos > 0):
            $tmp  = ["id" => $data['id_det_ot'], "estatus" => 2 ];
            $this -> actualizaEstatusDetOt($tmp);
        endif;
    }

    public function actualizaEstatusDetOt($data){
        $fecha_actual = date('Y-m-d h:i:s', time());
        DB::update('UPDATE det_ot SET estatus=:estatus, finalizacion=:finalizacion
                    WHERE id=:id',['estatus' => $data['estatus'],$fecha_actual], $data['id']);
    }

		public function actualizar_det_ot($id_det_ot, $estatus){
				DB::update('UPDATE det_ot SET estatus=:estatus WHERE id=:id',['estatus' => $estatus, 'id' => $id_det_ot]);
		}


		public function agregarProgramacion($data, $id_depto, $id_sucursal){
				// !    EL REQUEST CONTIENE UN ARRAY DE OBJETOS LLAMADO PROGRAMACION "$req -> programacion"
				// ! 1. CREO EL REGISTRO PARA LA PRODUCCION
				$agregarProg = DB::table('produccion')->insertGetId(
						[
								'id_det_ot' => $data['id_det_ot'],             //! 2 RECUPERO id_det_ot del data
								'id_producto' => $data['id_producto'],         //! 2 RECUPERO id_producto del data
								'cant_sol' => $data['cant_sol'],               //! 2 RECUPERO cant_sol del data
								'urgencia' => $data['urgencia'],               //! 2 RECUPERO urgencia del data
								'fecha_entrega' => $data['fecha_entrega'],     //! 2 RECUPERO fecha_entrega del data
								'id_creador' => $data['id_creador'],           //! 2 RECUPERO id_creador del data
								'creacion' => $data['creacion'],               //! 2 RECUPERO creacion del data
								'tipo_prog' => $data['tipo_prog'],             //! 2 RECUPERO tipo
								'cant_prog' => $data['cant_prog'],
								'id_depto' => $id_depto,
								'id_sucursal' => $id_sucursal
						]
				);
				return $agregarProg;
		}

		public function agregarPrimerMov($item, $id_produccion, $id_producto, $creacion){
				$agregar = DB::table('movim_prod')->insertGetId(
						[
								'id_produccion' => $id_produccion,
								'id_depto' => $item['depto']['id'],
								'id_sucursal' => $item['sucursal']['id'],
								'id_producto' => $id_producto,
								'cant_sol' => $item['cantidad'],
								'creacion' => $creacion
						]
				);
		}
	// ! ************************************************************************

    public function obtenerMovimProd()
    {
        $produccion = DB::select('SELECT * FROM movim_prod WHERE estatus = 1');
        return $produccion;
    }

    public function actualizarMovimProd($id, Request $req)
    {
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
																				dt.id_ot,
																				ot.id_cliente,
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
																				LEFT JOIN ot  		   	     ON dt.id_ot = ot.id
																				LEFT JOIN clientes       c ON ot.id_cliente = c.id
                                WHERE m.id_depto   = ? AND
                                        m.estatus_prod = ? AND
                                        m.creacion BETWEEN ? AND ?',
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

			$this -> actualiza_movim_anterior($req -> id_movim, $req -> enviadas);

			return $id_movim_prod? response("El producto se ha envíado correctamente.",200):
														 response("Ocurrio un error, intentelo nuevamente.",500);

		}

		public function actualiza_movim_anterior($id, $terminadas){
			$actualizar = DB::update('UPDATE movim_prod SET terminadas=:terminadas + terminadas WHERE id=:id',
            [
                'terminadas' => $terminadas,
                'id' => $id
            ]);
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

			$this -> validar_estatus_movimientos($req);
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
																			WHERE m.emisor = ? AND m.creacion BETWEEN ? AND ?',
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
		public function actualizar_estatus_produccion($data	){
		 $fecha_actual = date('Y-m-d h:i:s', time());
		 DB::update('UPDATE produccion SET finalizacion=:finalizacion, estatus=:estatus
									WHERE id =:id',['finalizacion' => $fecha_actual,
																	'estatus' => $data['estatus'],
																	'id' => $data['id']
																 ]);
		}
	// ! ************************************************************************



}
