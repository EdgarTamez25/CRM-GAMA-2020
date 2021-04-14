<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class histrorialController extends Controller
{
	public function NumerodeOrden($id){
			$NumOrden = DB::select('SELECT numorden FROM historial WHERE id_compromiso=? AND fase_venta=5',[$id]);
			return $NumOrden;
	}

	public function VerResumen($id){
			$resumen = DB::select('SELECT id,fase_venta, fecha, hora, aceptado , obscierre
															FROM historial WHERE id_compromiso=?',[$id]);
			return $resumen;
	}

	public function Historial(Request $req){

		$resumen = DB::select('SELECT c.id, c.id_vendedor, u.nombre as nomvend FROM compromisos c 
														LEFT JOIN users u ON c.id_vendedor = u.id
													WHERE c.fecha between ? AND ?',[$req -> fecha1, $req -> fecha2]);
		// return $resumen;

		$historialxId = [];
		$prospecto=0;$xcotizar=0;$cotizado=0; $recotizar=0;$produccion=0;$xentregar=0;$erechazada=0;$finok=0;$finno=0;$cerrado=0;
		if($resumen):
			for($i=0 ; $i< count($resumen) ; $i++):
				$id_compromiso  = $resumen[$i] -> id;
				$getHistorial = DB::select('SELECT id,id_compromiso,fecha,hora,fase_venta,aceptado FROM historial 
																			WHERE id_compromiso = ? ORDER BY id',[$id_compromiso]);
				$prospecto++;
				for($j=0;$j<count($getHistorial); $j++):
						$getHistorial[$j] -> fase_venta === 2? $xcotizar++: $xcotizar;
						$getHistorial[$j] -> fase_venta === 3? $cotizado++: $cotizado;
						$getHistorial[$j] -> fase_venta === 4? $recotizar++: $recotizar;
						$getHistorial[$j] -> fase_venta === 5? $produccion++: $produccion;
						$getHistorial[$j] -> fase_venta === 6? $xentregar++: $xentregar;
						$getHistorial[$j] -> fase_venta === 7? $erechazada++: $erechazada;
						$getHistorial[$j] -> fase_venta === 8? $cerrado++: $cerrado;
						$getHistorial[$j] -> fase_venta === 8 && $getHistorial[$j] -> aceptado === 1 ? $finok++:$finok;
						$getHistorial[$j] -> fase_venta === 8 && $getHistorial[$j] -> aceptado === 0 ? $finno++:$finno;

				endfor;
			endfor;
			array_push($historialxId,$prospecto,$xcotizar,$cotizado, $recotizar,$produccion,$xentregar,$erechazada,$cerrado,$finok,$finno);
			return $historialxId;
		endif;
	}

	public function HistorialxVend(Request $req){
		$historialxVend = []; $CxV=[];// DECLARO LAS VARIABLES GLOBALES 
		// CONSULTO TODOS LOS VENDEDORES ATIVOS
		$vendedores = DB::select('SELECT id,nombre as nomvend FROM users WHERE nivel =3 AND estatus = 1'); 
		
		for($i=0 ; $i< count($vendedores) ; $i++): // GENERO CICLO POR VENDEDOR
			// CONSULTO LOS COMPROMISOS POR VENDEDOR
			$compromisos  = DB::select('SELECT id FROM compromisos WHERE fecha between ? AND ? AND id_vendedor = ?',
																	[$req -> fecha1, $req -> fecha2, $vendedores[$i] -> id]);
			
			$vend = [ "id" 					=> $vendedores[$i] -> id,  // FORMO COMPROMISOS POR VENDEDOR
								"nomvend" 		=> $vendedores[$i] -> nomvend,
								"compromisos" => $compromisos 
							];
			array_push($CxV, $vend); // INSERTO OBJETO AL ARRAY A MANIPULAR
		endfor;

		for($j=0 ; $j<count($CxV); $j++): // GENERO CICLO DEL LOS COMPROMISOS POR VENDEDOR
			$cant =0; // INICIALIZO LA CANTIDAD EN CERO
			for($k=0; $k < count($CxV[$j]['compromisos']); $k++): // ANIDO CICLO PARA TRAER TODOS LOS COMPROMISOS DE UN VENDEDOR
				$id_compromiso = $CxV[$j]['compromisos'][$k] -> id; // GUARDO EL ID DEL COMPROMISO A BUSCAR
				$Historial = DB::select('SELECT id, fase_venta FROM historial WHERE id_compromiso=? AND fase_venta=?',[$id_compromiso, $req -> fase]);
				$cant =  $cant + count($Historial); // VOY SUMANDO LA CANTIDAD DE FASES QUE HAY POR COMPROMISO
			endfor;
			$CompxCant = ["id" => $CxV[$j]['id'], "nomvend" => $CxV[$j]['nomvend'], "cantidad" => $cant ]; //FORMO OBJECT 
			array_push($historialxVend,$CompxCant); // LO INSERTO EN EL ARRAY QUE MANDARE
		endfor;
		return $historialxVend; // RETORNO RESPUESTA. 
		
	}

	public function Recotización(Request $req){
		$recotizacion = DB::select('SELECT obscierre FROM historial WHERE id_compromiso=? AND fase_venta=?',
																	[$req -> id_compromiso, $req -> fase_venta]);
		return $recotizacion;	
	}
 
}
