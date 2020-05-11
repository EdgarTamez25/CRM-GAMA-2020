<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\compromisos;

class compromisosController extends Controller
{

		public function Compromisos(){
			$compromisos = DB::select('SELECT c.id,c.id_vendedor, v.nombre as nomvend, c.tipo_compromiso, c.id_categoria, ca.nombre as nomcatego,
																			  c.fecha, c.hora, c.fecha_fin, c.hora_fin, c.id_cliente, cli.nombre as nomcli, c.comentarios, 
																				c.fase_venta, c.id_usuario, u.nombre as nomuser, c.obs_usuario, c.cumplimiento, c.estatus
																 FROM compromisos c LEFT JOIN users v   	  ON v.id   = c.id_vendedor
																										LEFT JOIN categorias ca ON ca.id  = c.id_categoria
																										LEFT JOIN clientes  cli ON cli.id = c.id_cliente
																										LEFT JOIN users u       ON u.id   = c.id_usuario');

			return $compromisos;

		}

    public function addcompromiso(Request $request){

        $addCompromiso = DB::insert('INSERT INTO compromisos( id_vendedor, tipo_compromiso, id_categoria, fecha, hora, fecha_fin, hora_fin ,
																															id_cliente, comentarios, fase_venta, id_usuario, cumplimiento, estatus)
																				VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)',
																			[
																			 $request -> id_vendedor,  $request -> tipo_compromiso,
																			 $request -> id_categoria, $request -> fecha,
																			 $request -> hora, 				 $request -> fecha_fin,
																			 $request -> hora_fin,		 $request -> id_cliente,
																			 $request -> comentarios,  $request -> fase_venta,
																			 $request -> id_usuario ,  $request -> cumplimiento,
																			 $request -> estatus
																			]);

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
	
}
