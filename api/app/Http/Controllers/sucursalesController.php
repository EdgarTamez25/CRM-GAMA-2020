<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\sucursales;


class sucursalesController extends Controller
{
    public function getAll()
    {
        $Sucursales = sucursales::all();
        return $Sucursales;
    }

		public function add(Request $request){
			$addsucursal = sucursales::create($request->all());
			
			if($addsucursal):
				return "La sucursales se ah insertado correctamente";
			else:
				return "Ocurrio un problema al crear la sucursales, por favor intentelo mas tarde.";
			endif;

		}
		
		public function update($id, Request $req){
			$data = DB::update('UPDATE sucursales SET nombre=:nombre, estatus=:estatus WHERE id =:id',
													['nombre'=> $req -> nombre,'estatus'=> $req -> estatus, 'id'=> $id	]
												);
			
			return 'La sucursales se actualizo correctamente';
	}
}
