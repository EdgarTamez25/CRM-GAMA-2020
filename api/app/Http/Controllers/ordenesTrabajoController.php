<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //USAR ESCRITURA SQL

class ordenesTrabajoController extends Controller
{
    // !CATALOGO DE ORDENES TRABAJO
	public function OrdenesTrabajo(Request $req){
		$OT = DB::select('SELECT ot.id, ot.id_depto, ot.id_cliente, c.nombre as nomcli, ot.oc, ot.referencia, 
														 ot.fecha, ot.hora, ot.estatus, ot.id_vendedor , u.nombre as nomvend
												FROM ot LEFT JOIN clientes c ON ot.id_cliente  = c.id
																LEFT JOIN users    u ON ot.id_vendedor = u.id
											WHERE ot.id_depto = ? AND ot.fecha BETWEEN ? AND ?
											ORDER BY ot.id DESC',[ $req -> id_depto, $req -> fecha1, $req -> fecha2 ]);
		return $OT ? $OT: $OT = [];
	}

	public function DetalleOT($id){
		$detalleOT = DB::select('SELECT d.id, d.id_ot, d.id_producto, p.nombre as producto, d.cantidad, d.fecha_progra, d.fecha_entrega,
																		d.concepto, d.urgencia, d.razon, d.estatus 
																FROM det_ot d LEFT JOIN prodxcli p ON d.id_producto = p.id
														 WHERE d.id_ot = ?', [ $id]);
		return $detalleOT ? $detalleOT : [];
	}

	public function CrearOT(Request $req){
		$id_ot = DB::table('ot')->insertGetId(
			[
					'id_depto'	  => $req -> id_depto,
					'id_cliente' 	=> $req -> id_cliente,
					'oc' 					=> $req -> oc,
					'referencia' 	=> $req -> referencia,
					'fecha' 			=> $req -> fecha,
					'hora' 		  	=> $req -> hora,
					'id_usuario'  => $req -> id_usuario,

			]);
		
			for($i=0;$i<count($req -> detalle); $i++):  
				$this -> insertaDetalleOT($id_ot, $req -> fecha, $req -> detalle[$i]);
			endfor;
			
			return response("La orden de trabajo se creo correctamente" ,200);
	}

	public function insertaDetalleOT($id_ot,$fecha, $detalle){
		DB::table('det_ot')->insertGetId(
			[
					'id_ot'	  			=> $id_ot,
					'id_producto' 	=> $detalle['id_producto'],
					'cantidad' 			=> $detalle['cantidad'],
					'fecha_progra' 	=> $fecha,
					'fecha_entrega' => $detalle['fecha_entrega'],
					'concepto' 		  => $detalle['concepto'],
					'urgencia'  		=> $detalle['urgencia'],
					'razon'  				=> $detalle['razon'],
			]);
	}

	public function ActualizaOT($id, Request $req){
		$actualizaOT = DB::update('UPDATE ot SET id_vendedor=:id_vendedor, oc=:oc, referencia=:referencia
																		WHERE id=:id',['id_vendedor'  => $req -> id_vendedor, 
																									 'oc'      			=> $req -> oc, 
																									 'referencia'   => $req -> referencia, 
																									 'id' 					=> $id]);


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
		$actualizaPartida = DB::update('UPDATE det_ot SET id_producto=:id_producto, cantidad=:cantidad, fecha_entrega=:fecha_entrega,
																											concepto=:concepto, urgencia=:urgencia, razon=:razon
																		WHERE id=:id',['id_producto'   => $req -> id_producto, 
																									 'cantidad'      => $req -> cantidad, 
																									 'fecha_entrega' => $req -> fecha_entrega, 
																									 'concepto'      => $req -> concepto, 
																									 'urgencia'      => $req -> urgencia, 
																									 'razon'         => $req -> razon, 
																									 'id' 					 => $req -> id]);


		return $actualizaPartida ? response("La partida se actualizo correctamente",200):
														   response("Ocurrio un error amiguito, vuelve a intentarlo mas tarde", 500);
	}
	
	

}
