<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;


use App\User;

class userController extends Controller
{		
	

	public function IniciarSesionIntegral(Request $req){
		// $cadenaEncriptada    = Crypt::encryptString(2505);              // ENCRIPTAR INFORMACION
		// $cadenaDesencriptada = Crypt::decryptString($cadenaEncriptada); // DESENCRIPTAR INFORMACIÓN
		$usuario 	 = $req -> usuario;
		$contrasenia = $req -> contrasenia;
		$Data        = []; 

		if($datos_Usuario = $this -> validaExistenciaUsuario($usuario, $contrasenia ) ):     // VALIDAR SI EL USUARIO EXISTE EN LA BD
			if($sistemas = $this -> consultaAccesosASistemas($datos_Usuario[0] -> id)):        // CONSULTAR LOS PROYECTOS A LOS QUE TIENE ACCESO
				  $sesion  = $this -> crearNuevaSession($datos_Usuario[0] -> id);                // CREAR SESION ACTIVA DEL USUARIO
					array_push($Data, $sistemas, ["keylogger" => Crypt::encryptString($sesion)], ["id"=> $datos_Usuario[0] -> id]); // FORMAR ARRAY A RETORNAR
					return $Data;
			else:
				return response("No tiene ningun acceso disponible en este momento.",500);
			endif;
		else:
			return response("Lo sentimos, este usuario no se encuentra registrado.",500);
		endif;

	}

	public function validaExistenciaUsuario($usuario, $contrasenia){
		return DB::select('SELECT * FROM users WHERE usuario = ? AND password = ? AND estatus = 1',[$usuario,$contrasenia]);
	}

	public function consultaAccesosASistemas($id){
		return DB::select('SELECT a.id, a.id_sistema, s.nombre, s.foto, s.path, s.estatus  
												FROM accesos a LEFT JOIN sistemas s ON a.id_sistema = s.id    
											WHERE a.id_usuario = ? AND a.estatus = 1',[$id]);
	}

	public function crearNuevaSession($id_usuario){
		return DB::table('sesiones')->insertGetId([ 'id_usuario' => $id_usuario ]);
	}


	public function validaSesionActiva( Request $req){
		$key = Crypt::decryptString($req -> id); 
		$session = DB::select('SELECT * FROM sesiones WHERE id = ? ',[$key]);
		return $session ? $session : response('Lo sentimos está sesión no existe',500);
	}

	public function consultaInfoUsuario($id){
		return DB::select('SELECT * FROM users WHERE id=?',[$id]);
	}

	public function consultaNivelSistema($dataUsuario){
		return DB::select('SELECT * FROM accesos 
												WHERE id_usuario = ? AND id_sistema=?',
												[$dataUsuario['id'], $dataUsuario['sistema'] ]);
	}

	public function obtenerDatosUsuario(Request $req){
		$Data = [];
		$usuario      = $this -> consultaInfoUsuario($req -> id);
		if($req -> sistema != 0):
			$nivelSistema = $this -> consultaNivelSistema($req);
		endif;
		$sistemas     = $this -> consultaAccesosASistemas($req -> id);
		$datosUsuario = ["id"          => $usuario[0] -> id, 
										 "empleado"    => $usuario[0] -> empleado,
										 "nombre" 	   => $usuario[0] -> nombre, 
										 "correo" 	   => $usuario[0] -> correo,
										 "id_sucursal" => $usuario[0] -> id_sucursal,
										 "id_puesto"   => $usuario[0] -> id_puesto,
										 "id_depto"    => $usuario[0] -> id_depto,
										 "nivel"  => $req -> sistema != 0 ? $nivelSistema[0] -> id_nivel : []
										];
		$Data = ["datosUsuario" => $datosUsuario, "sistemas" => $sistemas  ];
		// array_push($Data, $usuario, $sistemas); // FORMAR ARRAY A RETORNAR
		return  $Data ? $Data: response("Ocurrio un error intentelo mas tarde",500);

	}

	public function CerrarSesion(Request $req){
		$id = Crypt::decryptString($req -> id); 
		$DeleteSession = DB::delete('DELETE FROM sesiones WHERE id = ?',[$id]);
		return $DeleteSession ? response('Sesion Cerrada', 200): response('ERROR AL CERRAR SESION', 500);
	}

	public function agregarUsuario(Request $req){
		if($this->validaEmail($req -> correo)): //REVISO QUE EL USUARIO NO EXISTA
			return response("Lo sentimos, este empleado ya se encuentra registrado",500);
		endif;
		
		if($this->validaUsuarioAdd($req -> usuario)):
			return response("Lo sentimos, este usuario ya esta en uso.",500);
		endif;

		$id_usuario = DB::table('users')->insertGetId(   //! INSERTO PRODUCTO EXISTENTE
			[
					'empleado'    =>  $req -> empleado,
					'nombre' 			=>  $req -> nombre,
					'usuario' 		=>  $req -> usuario,
					'password'    =>  $req -> password,
					'correo'      =>  $req -> correo,
					'id_sucursal'	=>  $req -> id_sucursal,
					'id_puesto'   =>  $req -> id_puesto,
					'id_depto'    =>  $req -> id_depto,
			]
		);


		if($id_usuario):
			if(count($req -> accesos) > 0):
				$this -> agregarAccesosUsuario($id_usuario, $req -> accesos);
			endif;
			return response("El usuario se ah insertado correctamente",200);
		else:
			return response("Ocurrio un problema al crear el usuario, por favor intentelo mas tarde.",500);
		endif;
	}

	public function catalogoUsuarios(){
			$data = DB::select('SELECT u.id, u.empleado, u.nombre, u.usuario, u.password, u.correo, u.nivel, 
																 u.id_sucursal, s.nombre as nomsuc, u.id_depto, d.nombre as nomdepto, 
															   u.id_puesto, p.nombre as nompuesto, u.estatus
													FROM users u 	LEFT JOIN sucursales s 	ON u.id_sucursal = s.id
																				LEFT JOIN puesto_por_depto p 		ON u.id_puesto 	= p.id
																				LEFT JOIN depto_por_suc d 	ON u.id_depto  	= d.id');
			return $data;
	}

	public function agregarAccesosUsuario($id_usuario, $accesos){
		for($i=0;$i<count($accesos); $i++):  //! GENERO UN CICLO EN EL ARRAY QUE RECIBO.
			DB::table('accesos')->insertGetId(   //! INSERTO PRODUCTO EXISTENTE
				[
						'id_usuario'  =>  $id_usuario,
						'id_sistema' 	=>  $accesos[$i]['id_sistema'] ,
						'id_nivel'    =>  $accesos[$i]['id_nivel'] 
				]
			);
		endfor;
	}

	public function actualizarUsuario($id, Request $req){
		
		if($this->validaUsuarioUp($req -> usuario, $id)):
			return response("Lo sentimos, este usuario ya esta en uso.",500);
		endif;

		$usuario = DB::update('UPDATE users SET empleado=:empleado, nombre=:nombre,usuario=:usuario, password=:password,correo=:correo, 
													 id_sucursal=:id_sucursal,id_puesto=:id_puesto,id_depto=:id_depto
											WHERE id =:id',
											[ 'empleado'   => $req -> empleado,
												'nombre'		 => $req -> nombre, 
												'usuario'		 => $req -> usuario, 
												'password'	 => $req -> password, 
												'correo'		 => $req -> correo,
												'id_sucursal'=> $req -> id_sucursal, 
												'id_puesto'	 => $req -> id_puesto, 
												'id_depto'	 => $req -> id_depto, 
												'id'				 => $id	
											]
										);

		// if($usuario):
			if(count($req -> accesosAEdit) > 0):
				$this -> eliminarAccesosUsuarios($req -> accesosAEdit);
			endif; 

			if(count($req -> accesos) > 0):
				$this -> agregarAccesosUsuario($id, $req -> accesos );
			endif;

			return response("El usuario se ah actualizado correctamente",200);
		// 	return response("El usuario se ah actualizado correctamente",200);
		// else:
			// return response("Ocurrio un problema al actualizar el usuario, por favor intentelo mas tarde.",500);
		// endif;
		
	}

	public function eliminarAccesosUsuarios($accesos){
		for($i=0;$i<count($accesos); $i++):
		  DB::delete('DELETE FROM accesos WHERE id = ?',[$accesos[$i]]);
		endfor;
	}




// FUNCIONES PROVADAS >>>>







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
