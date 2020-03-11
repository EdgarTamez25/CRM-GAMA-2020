<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\carteras;

class carterasController extends Controller
{
    public function getAll()
    {
        $Carteras = carteras::all();
        return $Carteras;
    }

		public function add(Request $request){
			$addcartera = carteras::create($request->all());
			
			if($addcartera):
				return "La Cartera se ah insertado correctamente";
			else:
				return "Ocurrio un problema al crear la cartera, por favor intentelo mas tarde.";
			endif;

		}
		
		public function update($id, Request $req){
			$data = DB::update('UPDATE carteras SET nombre=:nombre, estatus=:estatus WHERE id =:id',
													['nombre'=> $req -> nombre,'estatus'=> $req -> estatus, 'id'=> $id	]
												);
			
			return 'La Cartera se actualizo correctamente';
	}
    
}
