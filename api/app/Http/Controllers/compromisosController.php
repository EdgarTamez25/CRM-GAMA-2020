<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\compromisos;

class compromisosController extends Controller
{

		public function Compromisos(){
			$compromisos = DB::select('SELECT c.id,c.id_vendedor, v.nombre as nomvend, c.tipo_compromiso, c.id_categoria, ca.nombre as nomcatego,
																			  c.fecha, c.hora, c.fecha_fin, c.hora_fin, c.id_cliente, cli.nombre as nomcli, c.comentarios, 
																				c.fase_venta, c.id_usuario, u.nombre as nomuser, c.obs_usuario, c.cumplimiento, c.estatus
																 FROM compromisos c LEFT JOIN users v   	  ON v.id   = c.id_vendedor
																										LEFT JOIN categorias ca ON ca.id  = c.id_categoria
																										LEFT JOIN clientes  cli ON cli.id = c.id_cliente
																										LEFT JOIN users u       ON u.id   = c.id_usuario
																ORDER BY c.id DESC');

			return $compromisos;

		}

    public function addcompromiso(Request $req){
																				
				$id = DB::table('compromisos')->insertGetId(
					['id_vendedor'  => $req -> id_vendedor,  'tipo_compromiso' => $req -> tipo_compromiso,
					 'id_categoria' => $req -> id_categoria, 'fecha' 					 => $req -> fecha,
					 'hora' 			  => $req -> hora, 				 'fecha_fin'			 => $req -> fecha_fin,
					 'hora_fin' 		=> $req -> hora_fin,		 'id_cliente' 		 => $req -> id_cliente,
					 'comentarios'  => $req -> comentarios,  'fase_venta' 		 => $req -> fase_venta,
					 'id_usuario'   => $req -> id_usuario ,  'cumplimiento' 	 =>$req -> cumplimiento,
					 'estatus' 		  => $req -> estatus]
				);

				$fecha 				 = $req -> fechaActual; 
				$hora 				 = $req -> horaActual; 
				$fase_venta 	 = $req -> fase_venta;
				$numorden      = $req -> numorden;
				$aceptado      = $req -> aceptado;
				$obscierre     = $req -> obscierre;
				
				$hisorial = $this->Historial($id, $fecha, $hora, $fase_venta, $numorden, $aceptado,$obscierre);
				return "El compromiso se ha creado correctamente";
				
		}

		public function putcompromiso($id, Request $req){
			$updateCompromiso = DB::update('UPDATE compromisos SET id_vendedor=:id_vendedor,
																															tipo_compromiso=:tipo_compromiso,
																															id_categoria=:id_categoria,
																															fecha=:fecha,
																															hora=:hora,
																															fecha_fin=:fecha_fin,
																															hora_fin=:hora_fin,
																															id_cliente=:id_cliente, 
																															comentarios=:comentarios,
																															id_usuario=:id_usuario,
																															estatus=:estatus
																			WHERE id=:id'
																						,['id_vendedor'				=> $req -> id_vendedor, 
																							'tipo_compromiso'   => $req -> tipo_compromiso,
																							'id_categoria'      => $req -> id_categoria,
																							'fecha'							=> $req	-> fecha,
																							'hora'							=> $req	-> hora, 
																							'fecha_fin'         => $req -> fecha_fin,
																							'hora_fin'					=> $req -> hora_fin,
																							'id_cliente'				=> $req	-> id_cliente, 
																							'comentarios'				=> $req	-> comentarios , 
																							'id_usuario'				=> $req	-> id_usuario, 
																							'estatus' 				  => $req -> estatus,
																							'id'								=> $id
																							]
																			);

				return 'El compromiso se actualizo correctamente';
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
