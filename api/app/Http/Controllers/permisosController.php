<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// use App\User;

class permisosController extends Controller{		
	
	public function buscaEmpleado($id){
		$empleado = DB::select('SELECT u.id, u.nombre, d.nombre as departamento, p.nombre as puesto
															FROM users u LEFT JOIN departamentos d ON u.id_depto  = d.id
																					 LEFT JOIN puestos p       ON u.id_puesto = p.id
														WHERE u.id = ?', [$id]);
		return $empleado ? $empleado : $empleado=[];
	}

	public function AddPermiso(Request $req){
		$addpermisos = DB::insert('INSERT INTO permisos (fecha, id_usuario, tipo_permiso, motivo, fecha1, fecha2, hora1, hora2)
												VALUES(?,?,?,?,?,?,?,?)',[  $req -> fecha			    , $req -> id_usuario, 
                                                    $req -> tipo_permiso  , $req -> motivo,			 
                                                    $req -> fecha1        , $req -> fecha2,
                                                    $req -> hora1         , $req -> hora2
                                                  ]);
		return $addpermisos ? "El permiso se agrego correctamente.": $addpermisos =[];
	}
	
	public function PutPermiso($id, Request $req){
    $putPermiso = DB::update('UPDATE permisos SET fecha=:fecha, id_usuario=:id_usuario, tipo_permiso=:tipo_permiso,
                                                  motivo=:motivo, fecha1=:fecha1,fecha2=:fecha2, hora1=:hora1,hora2=:hora2 
                                                  WHERE id=:id',
                              [ 'fecha'		     => $req -> fecha,        'id_usuario'	 => $req -> id_usuario,
                                'tipo_permiso' => $req -> tipo_permiso, 'tipo_permiso' => $req -> tipo_permiso,
                                'motivo'       => $req -> motivo,       'fecha1'       => $req -> fecha1,
                                'fecha2'       => $req -> fecha2,       'hora1'        => $req -> hora1,
                                'hora2'        => $req -> hora2,        'id'           => $id	
                              ]
												);
    return $putPermiso ? "El permiso se actualizo correctamente": $putPermiso =[];
	} 

	public function Permisos(Request $req){
		$permisos = DB::select('SELECT p.id, p.fecha,p.id_usuario, u.nombre, pt.nombre as puesto, d.nombre as departamento,
																	 p.tipo_permiso, p.motivo, p.fecha1, p.fecha2, p.hora1, p.hora2, p.id_auth
															FROM permisos p LEFT JOIN users u         ON p.id_usuario = u.id
																				      LEFT JOIN puestos pt      ON u.id_puesto  = pt.id
																				      LEFT JOIN departamentos d ON u.id_depto   = d.id
														WHERE u.id_sucursal =? AND p.fecha1 between ? AND ? 
														ORDER BY p.id DESC',[$req -> id_sucursal, $req -> fecha1, $req -> fecha2]);
    return $permisos ? $permisos: $permisos =[];
	}

  
}
