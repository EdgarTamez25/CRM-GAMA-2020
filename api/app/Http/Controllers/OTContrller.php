<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //USAR ESCRITURA SQL

class OTContrller extends Controller
{
    // !CATALOGO DE ORDENES TRABAJO
	public function OrdenesTrabajo(Request $req){
		$OT = DB::select('SELECT ot.id, ot.id_cliente, c.nombre as nomcli, ot.id_solicitud,  ot.oc,
														 ot.fecha, ot.hora, ot.estatus, ot.id_solicitante , u.nombre as solicitante,
														 ot.id_creador, us.nombre as creador
												FROM ot LEFT JOIN clientes c ON ot.id_cliente     = c.id
																LEFT JOIN users    u ON ot.id_solicitante = u.id
																LEFT JOIN users   us ON ot.id_creador     = us.id
											WHERE ot.estatus = ? AND ot.fecha BETWEEN ? AND ?
											ORDER BY ot.id DESC',[ $req -> estatus, $req -> fecha1, $req -> fecha2 ]);
		return $OT ? $OT: $OT = [];
	}

	public function DetalleOT($id){
		$detalleOT = DB::select('SELECT d.id, d.partida, d.id_ot, d.id_producto, p.codigo as producto, d.cantidad, p.id_unidad,u.nombre as unidad,
																		d.fecha_progra, d.fecha_entrega, d.concepto, d.urgencia, d.razon, d.estatus 
																FROM det_ot d 
																	LEFT JOIN prodxcli p ON d.id_producto = p.id
																	LEFT JOIN unidades u ON p.id_unidad   = u.id
																WHERE d.id_ot = ?', [ $id]);
		return $detalleOT ? $detalleOT : [];
	}

	public function CrearOT(Request $req){
		$id_ot = DB::table('ot')->insertGetId(
			[
				  'id_cliente' 	   => $req -> id_cliente,
					'id_solicitante' => $req -> id_solicitante,
					'id_solicitud' 	 => $req -> id_solicitud,
					'oc' 					   => $req -> oc,
					'fecha' 			   => $req -> fecha,
					'hora' 		  	   => $req -> hora,
					'id_creador'     => $req -> id_creador,
			]);

		if($req -> sistema === 'CRM-GAMA'):
			for($i=0;$i<count($req -> detalle); $i++):  
				$this -> insertaDetalleOT($id_ot, $i+1, $req -> fecha, $req -> hora, $req -> detalle[$i]);
			endfor;
			$this -> actualizaEstatusSolicitud($req -> id_solicitud, $req -> fecha_procesado);
		endif; 

		if($req -> sistema === 'MRP'):
			for($i=0;$i<count($req -> detalle); $i++):  
				$this -> insertaDetalleOT2($id_ot, $i+1, $req -> fecha, $req -> hora, $req -> detalle[$i]);
			endfor;
		endif;



		return $id_ot? response("La orden de trabajo se creo correctamente" ,200):
									 response("Ocurrio un error, intentelo mas tarde." ,500);
	}

	public function insertaDetalleOT($id_ot,$partida,$fecha, $hora, $detalle){
		DB::table('det_ot')->insertGetId(
			[
					'id_ot'	  			=> $id_ot,
					'id_producto' 	=> $detalle['id_producto'],
					'partida'	  		=> $partida,
					'cantidad' 			=> $detalle['cantidad'],
					'concepto' 		  => $detalle['concepto']['id'],
					'urgencia'  		=> $detalle['urgencia']['id'],
					'razon'  				=> $detalle['razon'],
					'fecha_entrega' => $detalle['fecha'],     
					'creacion'      => $fecha.' '.$hora,
			]);
	}

	public function insertaDetalleOT2($id_ot,$partida,$fecha, $hora, $detalle){
		DB::table('det_ot')->insertGetId(
			[
					'id_ot'	  			=> $id_ot,
					'id_producto' 	=> $detalle['producto']['id'],
					'partida'	  		=> $partida,
					'cantidad' 			=> $detalle['cantidad'],
					'concepto' 		  => $detalle['concepto']['id'],
					'urgencia'  		=> $detalle['urgencia']['id'],
					'fecha_entrega' => $detalle['fecha'],     
					'creacion'      => $fecha.' '.$hora,
			]);
	}

	public function ActualizaOT($id, Request $req){
		// HASTA EL MOMENTO SOLO SE ACTUALIZA EL OC
		$actualizaOT = DB::update('UPDATE ot SET  oc=:oc WHERE id=:id',['oc' => $req -> oc, 'id' => $id]);
		return $actualizaOT ? response("La orden de trabajo se actualizo correctamente",200):
													response("Ocurrio un error amiguito, vuelve a intentarlo mas tarde", 500);
	}


	public function AgregarPartidaOT(Request $req){
		$agregarPartida = DB::table('det_ot')->insertGetId(
											[
													'id_ot'	  			=> $req -> id_ot,
													'id_producto' 	=> $req -> id_producto,
													'cantidad' 			=> $req -> cantidad,
													'fecha_progra' 	=> $req -> fecha_progra,
													'fecha_entrega' => $req -> fecha_entrega,
													'concepto' 		  => $req -> concepto,
													'urgencia'  		=> $req -> urgencia,
													'razon'  				=> $req -> razon
											]);

		return $agregarPartida ? response("La partida se agrego correctamente",200):
														response("Ocurrio un error amiguito, vuelve a intentarlo mas tarde", 500);
	}

	public function EliminarPartidaDetOT($id){
		$eliminaPartida = DB::delete('DELETE FROM det_ot WHERE id = ?', [ $id]);
		return $eliminaPartida ? response("La partida se elimino correctamente",200):
														 response("Ocurrio un error amiguito, vuelve a intentarlo mas tarde", 500);
	}

	public function ActualizaPartidaDetOT(Request $req){
		$actualizaPartida = DB::update('UPDATE det_ot SET cantidad=:cantidad, concepto=:concepto, 
																											urgencia=:urgencia, razon=:razon,
																											fecha_entrega=:fecha_entrega
																		WHERE id=:id',[
																									 'cantidad'      => $req -> cantidad, 
																									 'concepto'      => $req -> concepto, 
																									 'urgencia'      => $req -> urgencia, 
																									 'razon'         => $req -> razon, 
																									 'fecha_entrega' => $req -> fecha_entrega, 
																									 'id' 					 => $req -> id
																								  ]);


		return $actualizaPartida ? response("La partida se actualizo correctamente",200):
														   response("Ocurrio un error amiguito, vuelve a intentarlo mas tarde", 500);
	}


	public function actualizaEstatusSolicitud($id_solicitud, $fecha_procesado){
		DB::update('UPDATE solicitudes SET procesado=:procesado, estatus=:estatus, fecha_procesado=:fecha_procesado
									WHERE id=:id', ['procesado' => 1 ,
																	'estatus'   => 3 ,
																	'fecha_procesado' => $fecha_procesado,
																	'id' 				=> $id_solicitud]);
	}

	public function ActualizaUrgenciaDetOT($id, Request $req){
		 DB::update('UPDATE det_ot SET urgencia=:urgencia WHERE id=:id',['urgencia' => $req -> urgencia, 'id' => $req -> id]);
	}
}
