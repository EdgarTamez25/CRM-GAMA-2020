<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class tintasController extends Controller
{
    public function obtenerTintas(){
        return DB::select('SELECT * FROM tintas WHERE estatus = 1');
    }

    public function agregarTintas(Request $req){
        $Tintas = DB::table('tintas')->insertGetId(
                [
                    'nombre' 		=> $req -> nombre,
                    'dx' 			=> $req -> dx,
                    'estatus'  		=> $req -> estatus,
                ]
        );

    return $Tintas ? response("Agregado Correctamente",200):
                     response("Ocurrio un error por favor intentelo de nuevo", 500);
    }

    public function actualizarTintas($id, Request $req){
			$data = DB::update('UPDATE tintas SET nombre=:nombre, dx=:dx, estatus=:estatus
											  WHERE id =:id',
                                            [
                                            'nombre'    => $req  -> nombre,
                                            'dx'        => $req  -> dx,
                                            'estatus'   => $req  -> estatus,
                                            'id'        => $id
                                            ]);
	return $actualizaOT ? response("La tinta se actualizo correctamente",200):
						  response("Ocurrio un error, vuelve a intentarlo mas tarde", 500);
	}
}
