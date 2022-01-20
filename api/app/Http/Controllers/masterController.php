<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //USAR ESCRITURA SQL

class masterController extends Controller
{

	public function obtener_datos_monitor(Request $req){
		$master = DB::select('SELECT do.*,
																 p.codigo,p.id_unidad, 
																 u.nombre as unidad,
																 us.nombre as solicitante,
																 c.nombre as nomcli,
																 ot.id_cliente,  ot.id_solicitante, 
																 ot.id_solicitud, ot.oc, 
																 usr.nombre as creador
														FROM det_ot do 
															LEFT JOIN ot 	       ON do.id_ot          = ot.id
															LEFT JOIN users usr  ON ot.id_creador     = usr.id
															LEFT JOIN prodxcli p ON do.id_producto    = p.id
															LEFT JOIN unidades u ON p.id_unidad       = u.id
															LEFT JOIN clientes c ON ot.id_cliente     = c.id
															LEFT JOIN users   us ON ot.id_solicitante = us.id
														WHERE do.estatus = ? AND 
														      ot.fecha BETWEEN ? AND ? 
															ORDER BY do.id 
															DESC',
														[ 
															$req -> estatus, 
														  $req -> fecha1, 
															$req -> fecha2 
														]);

		return $master ? $master : [];
	}

		// **************** PROGRAMACON ********************************************

			public function ciclaProgramacion(Request $req){
					// return ($req->programacion[0]['depto']['id']);
				for ($i = 0; $i < count($req->programacion); $i++):
												$id_produccion = $this->agregarProgramacion($req, $req->programacion[$i]['depto']['id'], $req->programacion[$i]['sucursal']['id']);
												$this->agregarPrimerMov($req->programacion[$i], $id_produccion, $req->id_producto, $req->creacion);
																																				$this->actualizaFechaProg($req -> id_det_ot, $req -> creacion, 2);  // ACTUALIZAR DET_OT
				endfor;
				return response("Se programó correctamente", 200);
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

			public function actualizaFechaProg($id_det_ot, $creacion, $estatus){
				$actualizaFechaProg = DB::update('UPDATE det_ot SET fecha_progra=:fecha_progra, estatus=:estatus
															WHERE  id=:id',
															[
																	'fecha_progra'  => $creacion,
																	'estatus'       => $estatus,
																	'id'            => $id_det_ot
															]);
			}
    // ! ************************************************************************

		// **************** DISTRIBUCION ********************************************
			
		public function obtener_distribucion_programacion(Request $req){
			$producciones = DB::select('SELECT p.*,
			  																 s.nombre as nomsucursal
																		FROM produccion p
																			LEFT JOIN sucursales s ON p.id_sucursal = s.id
																	WHERE p.id_det_ot = ? AND p.id_producto = ?',
																	[
																		$req -> id_det_ot , 
																		$req -> id_producto
																	]);
			return $producciones ? $producciones : [];
		}

		public function obtener_distribucion_movimientos(Request $req){

			$distinct = DB::select("SELECT DISTINCT m.id_depto
																FROM movim_prod m 
															WHERE id_produccion = ?",[$req -> id]);

			$movimientos = [];
			for($i=0;$i<count($distinct);$i++ ):
				$data = $this -> obtener_movimientos($req -> id , $distinct[$i] -> id_depto);
				array_push($movimientos, $data);
			endfor;

			return $movimientos;
		}

		public function obtener_movimientos($id_produccion, $id_depto){
			$movim = DB::select('SELECT m.terminadas, m.estatus_prod, 
																	d.nombre as nomdepto 
														FROM movim_prod m 
															LEFT JOIN depto_por_suc d ON m.id_depto = d.id 
													 WHERE id_produccion = ? AND id_depto = ?',	[$id_produccion, $id_depto]);

			$terminado = 0; 
			$estatus_prod = 5; 
			$departamento = $movim[0] -> nomdepto;

			for($i=0;$i<count($movim);$i++ ):
				if($estatus_prod > $movim[$i] -> estatus_prod):
					$estatus_prod = $movim[$i] -> estatus_prod;
				endif;
				$terminado = $terminado + $movim[$i] -> terminadas;
			endfor;
			
			return [
							"terminadas"   => $terminado, 
							"estatus_prod" => $estatus_prod,
							"departamento" => $departamento
						 ];
		}




			
	
		// ! ************************************************************************
}
