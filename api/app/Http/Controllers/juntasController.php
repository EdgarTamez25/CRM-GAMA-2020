<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class juntasController extends Controller
{
  public function addJuntas(Request $req){
		$addJuntas = DB::insert('INSERT INTO sala_juntas (fecha,hora2,hora,id_sucursal,id_usuario,concepto)
															VALUES(?,?,?,?,?,?)',[  $req -> fecha       , $req -> hora2       , $req -> hora , 
																										  $req -> id_sucursal , $req -> id_usuario  , $req -> concepto ]);
		if($addJuntas):
			return response("La junta se creo correctamente",200);
		else:
			return response("Ocurrio un problema. Intentelo nuevamente.",500);
		endif;
	}
	
	public function putJuntas($id, Request $req){
    $putJunta = DB::update('UPDATE sala_juntas SET fecha=:fecha, hora2=:hora2, hora=:hora, id_sucursal=:id_sucursal, 
    																							 id_usuario=:id_usuario,concepto=:concepto 
															WHERE id=:id',[ 'fecha'		    => $req -> fecha, 
																							'hora2'		    => $req -> hora2, 
																							'hora' 			  => $req -> hora,
																							'id_sucursal' => $req -> id_sucursal, 
																							'id_usuario'  => $req -> id_usuario, 
																							'concepto'    => $req -> concepto, 
																							'id'          => $id	
									                          ]
												);

    if($putJunta):
			return response("La junta se actualizo correctamente",200);
		else:
			return response("Ocurrio un problema. Intentelo nuevamente.",500);
		endif;
	} 

	public function salaJuntas(Request $req){
		$Junta = DB::select('SELECT sj.id, sj.fecha, sj.hora2, sj.hora, sj.id_usuario, u.nombre as nomusuario, sj.concepto, sj.estatus,
																sj.id_sucursal, s.nombre as sucursal
															FROM sala_juntas sj LEFT JOIN users u      ON u.id = sj.id_usuario 
																									LEFT JOIN sucursales s ON s.id = sj.id_sucursal 
													WHERE sj.id_sucursal = ? AND fecha between ? AND ?  
												 ORDER BY sj.id DESC',[$req -> id_sucursal, $req -> fecha1, $req -> fecha2]);

    return $Junta ? $Junta: $Junta =[];
	}


	
}
