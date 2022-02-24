<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// catalogo_tipo_cambio
// obtener_tipo_cambio
// agregar_tipo_cambio
// editar_tipo_cambio

class tipocambioController extends Controller{

    public function catalogo_tipo_cambio(){
        $clientes = DB::select('SELECT * FROM tipo_cambio WHERE estatus = 1');
        return $clientes ? $clientes:[];
    }

    public function obtener_tipo_cambio(Request $req){
        $cambio = DB::select('SELECT * FROM tipo_cambio 
                                WHERE estatus = 1 AND fecha=?',
                            [$req -> fecha]);
        return $cambio;
        return $cambio ? $cambio : response('No hay tipo de cambio añadido', 500);
    }

    public function agregar_tipo_cambio(Request $req){
        $id_tipo_cambio = DB::table('tipo_cambio')->insertGetId(
        [
                // 'nombre' 	 => $req -> nombre,
                'cambio'     => $req -> cambio,
                'fecha'      => $req -> fecha,
                'id_creador' => $req -> id_creador,
        ]);

				return $id_tipo_cambio ? response('El tipo de cambio se agrego correctamente', 200):
																 response('Ocurrio un error intentelo mas tarde.', 500);
		}

		public function editar_tipo_cambio($id, Request $req){
			$actualizacion = DB::update('UPDATE tipo_cambio SET cambio=:cambio, id_actualiza=:id_actualiza
														WHERE id=:id',['cambio' 		  => $req -> cambio,  		 
																						'id_actualiza' => $req -> id_creador,
																					  'id' => $id]);
			
			return $actualizacion ? response('El tipo de cambio se actualizo correctamente', 200):
														    response('Ocurrio un error intentelo mas tarde.', 500);
    }

    // public function editar_tipo_cambio(Request $req){

    // }
}
