<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\User;

class userController extends Controller
{		

	public function IniciarSesion(Request $req){
		$correo 	= $req -> correo;
		$usuario 	= $req -> usuario;
		$contrasenia = $req -> contrasenia;
		$Usuarios =[];

		if($Usuario = DB::select('SELECT * FROM users WHERE correo = ? AND password = ? OR usuario = ? AND password = ? AND estatus = 1'
			,[$correo,$contrasenia,$usuario,$contrasenia])):

			if($Usuario[0] -> nivel === 3 || $Usuario[0] -> nivel === 4 || $Usuario[0] -> nivel === 8 ):
				return $Usuario = [];
			endif;

			return $Usuario;
		else:
			return 	$Usuarios;
		endif;

	}

	public function SesionPermisos(Request $req){
		$correo 	= $req -> correo;
		$usuario 	= $req -> usuario;
		$contrasenia = $req -> contrasenia;
		$Usuarios =[];

		if($Usuario = DB::select('SELECT u.id, u.nombre, u.nivel, u.id_sucursal,s.nombre as sucursal, u.permisos FROM users u 
																LEFT JOIN sucursales s ON u.id_sucursal = s.id 
														  WHERE u.correo = ?  AND u.password = ? OR 
																	  u.usuario = ? AND u.password = ? AND 
																	  u.estatus = 1 AND u.permisos = 1'
			,[$correo,$contrasenia,$usuario,$contrasenia])):

			return $Usuario;
		else:
			return 	$Usuarios;
		endif;

	}

	public function SesionProgramacionFlexo(Request $req){
		$correo 	   = $req -> correo;
		$usuario 	   = $req -> usuario;
		$contrasenia = $req -> contrasenia;

		$Usuario = DB::select('SELECT u.id, u.nombre, u.usuario, u.flexo_prog FROM users u 
																WHERE u.correo = ? AND u.password = ? OR 
																		 u.usuario = ? AND u.password = ? AND u.estatus = 1 AND u.flexo_prog > 0'
													,[$correo,$contrasenia,$usuario,$contrasenia]);
		return $Usuario ? $Usuario: [];
	}

	public function getAll() {
			return $Usuarios = User::all();
	}
	
	public function getcatalogo(){
		$data = DB::select('SELECT u.id, u.nombre, u.usuario, u.password, u.correo, u.nivel, 
															 u.id_sucursal, s.nombre as nomsuc, u.id_depto, d.nombre as nomdepto, 
														   u.id_puesto, p.nombre as nompuesto, u.foto, u.estatus
												FROM users u 	LEFT JOIN sucursales s 	ON u.id_sucursal = s.id
																			LEFT JOIN puestos p 		ON u.id_puesto 	= p.id
																			LEFT JOIN departamentos d 	ON u.id_depto  	= d.id');
		return $data;
	}

	public function add(Request $request){
		//REVISO QUE EL USUARIO NO EXISTA
		if($this->validaEmail($request -> correo)):
			$error = [ "error" 	=> true,"mensaje" => "Lo sentimos, este empleado ya se encuentra registrado"];
			return $error;
		endif;
		
		if($this->validaUsuarioAdd($request -> usuario)):
			$error = [ "error" 	=> true,"mensaje" => "Lo sentimos, este usuario ya esta en uso."];
			return $error;
		endif;


		$addusuario = User::create($request->all());
		if($addusuario):
			return "El usuario se ah insertado correctamente";
		else:
			return "Ocurrio un problema al crear el usuario, por favor intentelo mas tarde.";
		endif;
	}
	
	public function update($id, Request $req){
		
		if($this->validaUsuarioUp($req -> usuario, $id)):
			$error = [ "error" 	=> true,"mensaje" => "Lo sentimos, este usuario ya esta en uso."];
			return $error;
		endif;

		$data = DB::update('UPDATE users SET nombre=:nombre,usuario=:usuario, password=:password,correo=:correo, 
																				nivel=:nivel, id_sucursal=:id_sucursal, foto=:foto, id_depto=:id_depto, id_puesto=:id_puesto
												WHERE id =:id',
												['nombre'			=> $req -> nombre, 
													'usuario'		=> $req -> usuario, 
													'password'	=> $req -> password, 
													'correo'		=> $req-> correo,
													'nivel'			=>$req -> nivel, 
													'id_sucursal'=> $req -> id_sucursal, 
													'foto'			=> $req-> foto, 
													'id_depto'	=> $req-> id_depto, 
													'id_puesto'	=> $req-> id_puesto, 
													'id'=> $id	
												]
											);
		
		return 'El usuario se actualizo correctamente';
	}

	public function delete($id){
		$deleteUsuario = DB::delete('DELETE FROM users WHERE id = ?',[$id]);
		return "Usuario Eliminado Correctamente";
	}

	public function choferesAll(){
		$choferes = DB::select('SELECT id, nombre, usuario, correo FROM users WHERE nivel=4');
		return $choferes;
	}

	public function estatusUser( Request $req){
		return DB::update('UPDATE users SET estatus=:estatus WHERE id=:id',['estatus' => $req-> estatus, 'id' => $req -> id]);
	}
	// ============================== FUNCIONES QUE SE EJECUTAN INTERNAMENTE =======================================
	
	public function validaEmail($correo){
		return DB::select('SELECT correo FROM users WHERE correo = ?',[$correo]);
	}

	public function validaUsuarioAdd($usuario){
		return DB::select('SELECT usuario FROM users WHERE usuario = ?',[$usuario]);
	}

	public function validaUsuarioUp($usuario, $id){
		return DB::select('SELECT usuario FROM users WHERE usuario = ? AND id != ?',[$usuario, $id]);
	}

	public function obtenerOperadores(Request $req){
		$operadores = DB::select('SELECT u.id, u.nombre, u.usuario, u.flexo_prog FROM users u WHERE u.flexo_prog = 2 AND u.estatus = 1');
		return $operadores? $operadores : [];
	}
	
}
