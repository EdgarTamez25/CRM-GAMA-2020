<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\unidades;

class unidadesController extends Controller
{

    public function obtenerUnidades()
    {
        return DB::select('SELECT * FROM unidades WHERE estatus = 1');
    }

    public function agregarUnidades(Request $request){
        $unidades = DB::table('unidades')->insertGetId(
                [
                    'nombre' 		    => $req -> nombre,
                    'estatus'  		    => $req -> estatus
                ]
        );
        $unidades ? response("La unidad se creo Correctamente",200):
        response("Ocurrio un error por favor intentelo de nuevo", 500);
    }

    public function actualizarUnidades($id, Request $req){
        $data = DB::update('UPDATE unidades SET nombre=:nombre, estatus=:estatus
                                            WHERE id =:id',
                                            [
                                            'nombre'=> $req -> nombre,
                                            'estatus'=> $req -> estatus,
                                            'id'=> $id
                                            ]);
	return $data ?  response("La unidad se actualizo Correctamente",200):
				    response("Ocurrio un error, vuelve a intentarlo mas tarde", 500);
    }
}

