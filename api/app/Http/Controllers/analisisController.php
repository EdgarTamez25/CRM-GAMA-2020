<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class analisisController extends Controller
{
    public function obtener_analisis_produccion(Request $req){
				$data=[];
				$produccion=[];

        // $seguimiento = DB::select('SELECT p.id as id_produccion, 
				// 																 p.id_producto, 
				// 																 p.id_sucursal, 
				// 																 p.creacion
        //                             FROM produccion p
        //                           WHERE p.id_sucursal = ? AND
				// 													      p.creacion BETWEEN ? AND ?', 
				// 													[$req -> id_sucursal, $req -> fecha1, $req -> fecha2]);
				
				$total = DB::select('SELECT count(*) as total
															FROM produccion 
														WHERE id_sucursal = ? AND
																	creacion BETWEEN DATE(?) AND DATE(?)',
													 [$req -> id_sucursal, $req -> fecha1, $req -> fecha2]);

				$depto = DB::select('SELECT DISTINCT(m.id_depto),d.nombre as departamento
																FROM movim_prod m LEFT JOIN depto_por_suc d ON m.id_depto = d.id
															WHERE m.id_sucursal = ? AND m.creacion BETWEEN DATE(?) AND DATE(?) ',
															[$req -> id_sucursal, $req -> fecha1, $req -> fecha2]);
				
				for($i=0 ; $i<count($depto); $i++):

					$xrecibir = DB::select('SELECT count(DISTINCT(id_produccion)) as xrecibir FROM movim_prod 
																WHERE estatus_prod = 0  AND 
																			id_depto = ? AND
																			id_sucursal = ? AND
																			creacion BETWEEN DATE(?) AND DATE(?)',
															[$depto[$i] -> id_depto, $req -> id_sucursal, $req -> fecha1, $req -> fecha2]
					);

					$pendiente = DB::select('SELECT count(DISTINCT(id_produccion)) as pendiente FROM movim_prod 
																	WHERE estatus_prod = 1  AND 
																				id_depto = ? AND
																				id_sucursal   = ? AND
																				creacion BETWEEN DATE(?) AND DATE(?)',
																[$depto[$i] -> id_depto, $req -> id_sucursal, $req -> fecha1, $req -> fecha2]);
					
					$produciento = DB::select('SELECT count(DISTINCT(id_produccion)) as produciento FROM movim_prod 
																WHERE estatus_prod = 2  AND 
																			id_depto = ? AND
																			id_sucursal   = ? AND
																			creacion BETWEEN DATE(?) AND DATE(?)',
															[$depto[$i] -> id_depto, $req -> id_sucursal, $req -> fecha1, $req -> fecha2]);

					$terminado = DB::select('SELECT count(DISTINCT(id_produccion)) as terminado FROM movim_prod 
															WHERE estatus_prod = 3  AND 
																		id_depto = ? AND
																		id_sucursal   = ? AND
																		creacion BETWEEN DATE(?) AND DATE(?)',
														[$depto[$i] -> id_depto, $req -> id_sucursal, $req -> fecha1, $req -> fecha2]);

						// "produccion" => $produccion,
						// "total_partidas" => $total,
						// "departamentos" => $departamentos,
						$produccion = [
							"Departamento" => $depto[$i] 			-> departamento,
							"Por_recibir"  => $xrecibir[0]    -> xrecibir, 
							"Pendiente"    => $pendiente[0]   -> pendiente, 
							"Produciento"  => $produciento[0] -> produciento,
							"Terminado"    => $terminado[0]   -> terminado
						];

					array_push($data,$produccion, );
				endfor;

				array_push($data, $total[0]);				 
        return $data;

    }
}
