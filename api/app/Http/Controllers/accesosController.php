<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// use App\User;

class accesosController extends Controller{		
	// ============================== FUNCIONES DE GAMA EXTERNO ====================================================
	public function buscarUsuarioRH($id){
		$usuario = DB::select('SELECT id, empleado, nombre 
														FROM users 
													 WHERE empleado = ?',[$id]);
		if($usuario): return $usuario; else: return $usuario = []; endif;
	}
	
	public function RHAcceso(Request $req){
		return DB::insert('INSERT INTO rh_accesos (id_usuario,fecha1,hora1,concepto,id_sucursal,id_cliente)
												VALUES(?,?,?,?,?,?)',
												[
													$req -> empleado, 
													$req -> fecha1, 
													$req -> hora1,
													$req -> concepto, 
													$req -> id_sucursal, 
													$req -> id_cliente
												]);
	}

	public function Accesos($id){
		$acceso = DB::select('SELECT a.*,
																 u.nombre, u.empleado, 
																 p.nombre as puesto 
                            FROM rh_accesos a 
															LEFT JOIN users u   ON a.id_usuario = u.empleado
                              LEFT JOIN puestos p ON u.id_puesto  = p.id
                          WHERE a.estatus = 1 AND 
															  a.id_sucursal = ?',[$id]);
		if($acceso): return $acceso; else: return $acceso = []; endif;
	}

	public function accesosAll(Request $req){
		$accesoall = DB::select('SELECT a.*,
																		u.nombre, u.empleado,
																		s.nombre as sucursal, 
																		c.nombre as cliente
															FROM rh_accesos a 
																LEFT JOIN users u      ON a.id_usuario  = u.empleado 
																LEFT JOIN sucursales s ON a.id_sucursal = s.id
																LEFT JOIN clientes c   ON a.id_cliente  = c.id
														 WHERE a.id_sucursal = ? AND 
														 		   a.fecha1 between ? AND ? 
															ORDER BY a.id DESC',[$req -> id_sucursal, $req -> fecha1, $req -> fecha2]);
		return $accesoall ? $accesoall: [];
	}
	
	public function ActualizaAcceso(Request $req){
		$UsuarioRH = DB::select('SELECT rh.id, 
																	  u.nombre, u.empleado
															FROM rh_accesos rh 
																LEFT JOIN  users u ON rh.id_usuario = u.empleado
														 WHERE rh.id_usuario =? AND 
														 			 rh.estatus = 1',[$req -> id_usuario]);
    
		if($UsuarioRH): 
			$id = $UsuarioRH[0] -> id;
			$data = DB::update('UPDATE rh_accesos 
														SET fecha2=:fecha2, 
																hora2=:hora2,
																estatus=:estatus 
													WHERE id=:id',
													[
													 'fecha2'	=> $req -> fecha2, 		
													 'hora2'	=> $req -> hora2,
													 'estatus'=> $req -> estatus, 	
													 'id' => $id	
													]
												);
				return $UsuarioRH;
		else:
			return $UsuarioRH = [];
		endif;

	}

	public function addVisitante(Request $req){
		$visitante = DB::insert('INSERT INTO rh_visitas (nombre, empresa, usuario_visita, fecha1,hora1, concepto,id_sucursal,temperatura)
												VALUES(?,?,?,?,?,?,?,?)',[$req -> nombre	        , $req -> empresa, 
																									$req -> usuario_visita  , $req -> fecha1,			 
																									$req -> hora1           , $req -> concepto,
																									$req -> id_sucursal    	, $req -> temperatura
																								]);
		return $visitante ? $visitante: $visitante =[];
	}
	
	public function Visitantes($id_sucursal){
		return DB::select('SELECT * FROM rh_visitas WHERE estatus = 1 AND id_sucursal = ?',[$id_sucursal]);
	}
	
	public function visitantesAll(Request $req){
		$visitaAll = DB::select('SELECT v.id, v.nombre, v.fecha1, v.fecha2, v.hora1, v.hora2,v.empresa,v.concepto,v.temperatura,
																		v.usuario_visita, u.nombre as nomuser
															FROM rh_visitas v LEFT JOIN users u ON v.usuario_visita = u.id
														WHERE v.id_sucursal =? AND v.fecha1 between ? AND ? ORDER BY v.id DESC',
														[$req -> id_sucursal, $req -> fecha1, $req -> fecha2]);
		if($visitaAll): return $visitaAll; else: return $visitaAll = []; endif;
	}

	public function MarcarSalida(Request $req){
		$data = DB::update('UPDATE rh_visitas SET fecha2=:fecha2, hora2=:hora2,estatus=:estatus WHERE id=:id',
													['fecha2'		=> $req -> fecha2, 		'hora2'	 => $req -> hora2,
													 'estatus'	=> $req -> estatus, 	'id'		 => $req -> id	]
												);
	}
}
