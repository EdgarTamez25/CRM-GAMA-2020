<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\unidades;

class unidadesController extends Controller
{
    public function obtenerUnidades()
    {
        $Unidad = unidades::all();
        return $Unidad;
    }

		public function agregarUnidades(Request $request){
			$addunidad = unidades::create($request->all());

			if($addunidad):
				return "La Unidad se ah insertado correctamente";
			else:
				return "Ocurrio un problema al crear la unidad, por favor intentelo mas tarde.";
			endif;

		}

		public function actualizarUnidades($id, Request $req){
			$data = DB::update('UPDATE unidades SET nombre=:nombre, estatus=:estatus WHERE id =:id',
													['nombre'=> $req -> nombre,'estatus'=> $req -> estatus, 'id'=> $id	]
												);

			return 'La Unidad se actualizo correctamente';
	}
}
