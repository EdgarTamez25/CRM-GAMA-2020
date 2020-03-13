<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\lineas_prod;

class lineas_prodController extends Controller
{
    public function getAll()
    {
        $Linea = lineas_prod::all();
        return $Linea;
    }

		public function add(Request $request){
			$addlinea = lineas_prod::create($request->all());
			
			if($addlinea):
				return "La línea se ah insertado correctamente";
			else:
				return "Ocurrio un problema al crear la línea, por favor intentelo mas tarde.";
			endif;

		}
		
		public function update($id, Request $req){
			$data = DB::update('UPDATE lineas_prods SET nombre=:nombre, estatus=:estatus WHERE id =:id',
													['nombre'=> $req -> nombre,'estatus'=> $req -> estatus, 'id'=> $id	]
												);
			
			return 'La línea se actualizo correctamente';
	}
}
