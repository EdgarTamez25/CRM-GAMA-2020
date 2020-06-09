<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class entregasController extends Controller
{
	public function EntregarProducto(Request $req){

		  $id_compromiso = $req -> id; 
			$fecha 				 = $req -> fecha; 
			$hora 				 = $req -> hora; 
			$fase_venta 	 = $req -> fase_venta;
			$numorden      = $req -> numorden;
			$aceptado      = $req -> aceptado;
		
		if($historial = $this->Historial($id_compromiso, $fecha, $hora, $fase_venta, $numorden, $aceptado)):
			$Entregar = DB::insert('INSERT INTO entregas (id_compromiso,id_chofer, fecha_entrega, hora_entrega,numfac)
																VALUES(?,?,?,?,?)', [
																											$req -> id,
																											$req -> id_chofer,
																											$req -> fecha_entrega,
																											$req -> hora_entrega,
																											$req -> numfac
																										]);

			$PutCompromiso = DB::update('UPDATE compromisos SET fase_venta=:fase_venta, estatus=:estatus
																	   WHERE id=:id',[ 'fase_venta' => $fase_venta, 'estatus' => 0, 'id' => $id_compromiso]);

				return "La entrega se guardo correctamente.";
		endif;
	}

	public function FaseVenta(Request $req){
			$id_compromiso = $req -> id; 
			$fecha 				 = $req -> fecha; 
			$hora 				 = $req -> hora; 
			$fase_venta 	 = $req -> fase_venta;
			$numorden      = $req -> numorden;
			$aceptado      = $req -> aceptado;
			
			if($historial = $this->Historial($id_compromiso, $fecha, $hora, $fase_venta, $numorden, $aceptado)):
					$PutCompromiso = DB::update('UPDATE compromisos SET fase_venta=:fase_venta 
																																			WHERE id=:id',[ 'fase_venta' => $fase_venta, 'id' => $id_compromiso]);
					return "Fase de venta actualizada";
			endif; 
	}

	public function Entregabyid(Request $req){
		$entregasxId = DB::select('SELECT e.id_chofer, u.nombre, e.numfac, e.fecha_entrega, e.hora_entrega, e.estatus, e.obs
																	FROM entregas e LEFT JOIN users u ON e.id_chofer = u.id
																WHERE e.id_compromiso = ? AND e.estatus = ?;',[$req -> id, $req -> estatus]);
		return $entregasxId;
	}


	//================================ FUNCIONES QUE SE EJECUTAN INTERNAMENTE =======================================
	public function Historial($id_compromiso, $fecha, $hora, $fase_venta, $numorden, $aceptado ){
			$historial = DB::insert('INSERT INTO historial(id_compromiso,fecha,hora,fase_venta,numorden,aceptado)
																															VALUES(?,?,?,?,?,?)',[$id_compromiso, $fecha, $hora, $fase_venta,$numorden,$aceptado]);
			return $historial;
	}
}
