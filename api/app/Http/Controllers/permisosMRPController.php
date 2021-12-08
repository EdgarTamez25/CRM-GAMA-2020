<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class permisosMRPController extends Controller
{
	public function obtener_permisos_usuario($id){
		$permisos = DB::select('SELECT p.* 
															FROM permisos_mrp p
														WHERE id_usuario = ?', [ $id ]);
		return $permisos ? $permisos : [];
	}

	public function agregar_permisos_usuario(Request $req){
		$agregar_permisos = DB::insert('INSERT INTO permisos_mrp(id_usuario,master, produccion, ot, pt, entradas)
											VALUES(?,?,?,?,?,?)',[  $req -> id_usuario, 
																							$req -> master, 
																							$req -> produccion,			 
																							$req -> ot, 
																							$req -> pt,
																							$req -> entradas
																						]);
		return $agregar_permisos ? 
							response("Los permiso se agregaron correctamente.", 200):
							response("Ocurrio un error, por favor intentelo mas tarde.", 500);
	}

	public function actualizar_permisos_usuario($id, Request $req){
		$actualizar_permisos = DB::update('UPDATE permisos_mrp 
																				SET  
																					master=:master,
																					produccion=:produccion, 
																					ot=:ot,
																					pt=:pt, 
																					entradas=:entradas
																				WHERE id=:id',
																					[         
																						'master' 			=> $req -> master, 
																						'produccion'  => $req -> produccion,       
																						'ot'       		=> $req -> ot,
																						'pt'       		=> $req -> pt,       
																						'entradas'    => $req -> entradas,
																						'id'          => $id	
																					]
																			);
		return $actualizar_permisos ? 
							response("Los permiso se actualizaron  correctamente.", 200):
							response("Ocurrio un error, por favor intentelo mas tarde.", 500);
	}

}
