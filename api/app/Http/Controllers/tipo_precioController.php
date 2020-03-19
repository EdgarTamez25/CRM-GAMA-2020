<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tipos_precios;

class tipo_precioController extends Controller
{
    public function getAll()
    {
        $TiposPrecios = tipos_precios::all();
        return $TiposPrecios;
    }

		public function add(Request $request){
			$addTipoPrecio = tipos_precios::create($request->all());
			
			if($addTipoPrecio):
				return "El tipo de precio se ha agregado exitosamente";
			else:
				return "Ocurrio un problema al crear el tipo de precio definido, por favor intentelo mas tarde.";
			endif;

		}
		
		public function update($id, Request $req){
			$data = DB::update('UPDATE tipos_precios SET nombre=:nombre, estatus=:estatus WHERE id =:id',
													['nombre'=> $req -> nombre,'estatus'=> $req -> estatus, 'id'=> $id	]
												);
			return 'El tipo de precio se agregó correctamente';
	}
}
