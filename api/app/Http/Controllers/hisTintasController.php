<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class hisTintasController extends Controller
{
    public function obtenerHisTintas(){
        return DB::select('SELECT * FROM HisTintas WHERE estatus = 1');
    }

    public function agregarHisTintas(Request $req){
        $HisTintas = DB::table('histintas')->insertGetId(
                [
                    'cant_ant' 		    => $req -> cant_ant,
                    'unidad_ant' 		=> $req -> unidad_ant,
                    'cant_act'  		=> $req -> cant_act,
                    'unidad_act'  		=> $req -> unidad_act,
                    'id_usuario'  		=> $req -> id_usuario,
                    'concepto'  		=> $req -> concepto,
                    'estatus'  		    => $req -> estatus,
                ]
        );
    return $HisTintas ? response("Agregado Correctamente",200):
                     response("Ocurrio un error por favor intentelo de nuevo", 500);
    }

    public function actualizarTintas($id, Request $req){
			$data = DB::update('UPDATE histintas SET nombre=:nombre, dx=:dx, estatus=:estatus
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
