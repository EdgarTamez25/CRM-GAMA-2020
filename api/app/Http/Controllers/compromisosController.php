<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\compromisos;

class compromisosController extends Controller
{
		
		public function Compromisos(Request $req){
			
			return DB::select('SELECT c.id,c.id_vendedor, v.nombre as nomvend, c.tipo, c.id_categoria, ca.nombre as nomcatego,
																			c.fecha, c.hora,c.fecha_cierre, c.hora_cierre,  c.id_cliente, cli.nombre as nomcli, c.obs,
																			c.fuente, u.nombre as creador, c.obs_usuario, c.confirma_cita,c.cumplimiento, c.estatus
													FROM compromisos c LEFT JOIN users v   	   ON v.id   = c.id_vendedor
																						 LEFT JOIN categorias ca ON ca.id  = c.id_categoria
																						 LEFT JOIN clientes  cli ON cli.id = c.id_cliente
																						 LEFT JOIN users u       ON u.id   = c.fuente 
												WHERE  c.fecha BETWEEN ? AND ? ORDER BY c.id DESC' ,[ $req -> fecha1 , $req -> fecha2]);
		}

    public function addcompromiso(Request $req){
																				
			$id = DB::table('compromisos')->insertGetId(
				[ 'id_vendedor'  => $req -> id_vendedor , 'tipo' 			 => $req -> tipo ,
					'id_categoria' => $req -> id_categoria, 'id_cliente' => $req -> id_cliente, 
					'fecha' 			 => $req -> fecha			  , 'hora' 		 	 => $req -> hora,		   
					'obs'  			   => $req -> obs				  , 'fuente'     => $req -> fuente
				]
			);

			if($id):
				return response("El compromiso se creo correctamente",200);
			else:
				return response("Ocurrio un problema. Intentelo nuevamente.",500);
			endif;

		
		}

		public function putcompromiso($id, Request $req){
			$updateCompromiso = DB::update('UPDATE compromisos SET  id_vendedor=:id_vendedor,
																															tipo=:tipo,
																															id_categoria=:id_categoria,
																															id_cliente=:id_cliente, 
																															fecha=:fecha,
																															hora=:hora,
																															obs=:obs,
																															fuente=:fuente
																			WHERE id=:id'
																						,['id_vendedor'				=> $req -> id_vendedor, 
																							'tipo'   						=> $req -> tipo,
																							'id_categoria'      => $req -> id_categoria,
																							'id_cliente'				=> $req	-> id_cliente, 
																							'fecha'							=> $req	-> fecha,
																							'hora'							=> $req	-> hora, 
																							'obs'								=> $req	-> obs , 
																							'fuente'						=> $req	-> fuente, 
																							'id'								=> $id
																							]
																			);
			if($updateCompromiso):
				return response("El compromiso se actualizo correctamente",200);
			else:
				return response("Ocurrio un problema. Intentalo nuevamente.",500);
			endif;
		}

		public function FaseVenta(Request $req){
			$id_compromiso = $req -> id; 
			$fecha 				 = $req -> fecha; 
			$hora 				 = $req -> hora; 
			$fase_venta 	 = $req -> fase_venta;
			$numorden      = $req -> numorden;
			$aceptado      = $req -> aceptado;
			$obscierre     = $req -> obscierre;

			if($hisorial = $this->Historial($id_compromiso, $fecha, $hora, $fase_venta, $numorden, $aceptado,$obscierre)):
				$PutCompromiso = DB::update('UPDATE compromisos SET fase_venta=:fase_venta 
																			WHERE id=:id',[ 'fase_venta' => $fase_venta, 'id' => $id_compromiso]);
				return "Fase de venta actualizada";
			endif; 
		}


		//================================ FUNCIONES QUE SE EJECUTAN INTERNAMENTE =======================================
		public function Historial($id_compromiso, $fecha, $hora, $fase_venta, $numorden, $aceptado,$obscierre ){
			$historial = DB::insert('INSERT INTO historial(id_compromiso,fecha,hora,fase_venta,numorden,aceptado,obscierre)
																	VALUES(?,?,?,?,?,?,?)',[$id_compromiso, $fecha, $hora, $fase_venta,$numorden,$aceptado,$obscierre]);
			return $historial;
		}
}
