<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class userController extends Controller
{		
    public function getAll() {
        $Usuarios = User::all();
        return $Usuarios;
		}
		
		public function getcatalogo(){
			$data = DB::select('SELECT u.id, u.nombre, u.password, u.correo, u.nivel, u.id_sucursal, s.nombre as nomsuc, u.foto
														FROM users u LEFT JOIN sucursales s ON u.id_sucursal = s.id');
			return $data;
		}
		
		public function add(Request $request){
			//REVISO QUE EL USUARIO NO EXISTA
			if($this->validaEmail($request -> correo)):
				return "Lo sentimos, este usuario ya se encuentra registrado";
			endif;

			$addusuario = User::create($request->all());
    		if($addusuario):
				return "El usuario se ah insertado correctamente";
			else:
				return "Ocurrio un problema al crear el usuario, por favor intentelo mas tarde.";
			endif;
		}

		public function update($id, Request $req){
			$data = DB::update('UPDATE users SET nombre=:nombre, password=:password,correo=:correo, 
																					nivel=:nivel, id_sucursal=:id_sucursal, foto=:foto
													WHERE id =:id',
													['nombre'=> $req -> nombre,'password'=> $req -> password, 'correo'=> $req-> correo,
													 'nivel'=>$req -> nivel, 'id_sucursal'=> $req -> id_sucursal, 'foto'=> $req-> foto, 
													 'id'=> $id	
													]
												);
			
			return 'El usuario se actualizo correctamente';
		}

	// ============================== FUNCIONES QUE SE EJECUTAN INTERNAMENTE =======================================
	
	public function validaEmail($correo){
		return DB::select('SELECT correo FROM users WHERE correo = ?',[$correo]);
	}
}
