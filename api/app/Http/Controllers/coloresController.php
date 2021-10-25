<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class coloresController extends Controller
{
    public function obtenerColores(){
        return DB::select('SELECT * FROM colores WHERE estatus = 1');
    }

    public function agregarColores(Request $req){
        $Colores = DB::table('colores')->insertGetId(
                [
                    'nombre' 		    => $req -> nombre,
                    'estatus'  		    => $req -> estatus
                ]
            );
        return $Colores ? response("Agregado Correctamente",200):
                         response("Ocurrio un error por favor intentelo de nuevo", 500);
    }
    public function actualizarColores($id, Request $req){
			$data = DB::update('UPDATE colores SET nombre=:nombre, estatus=:estatus
											  WHERE id =:id',
                                            [
                                            'nombre'    => $req  -> nombre,
                                            'estatus'   => $req  -> estatus,
                                            'id'        => $id
                                            ]);
	return $actualizaOT ? response("El color se actualizo correctamente",200):
						  response("Ocurrio un error, vuelve a intentarlo mas tarde", 500);
	}
}
