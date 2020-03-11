<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\zonas;


class zonasController extends Controller
{
    public function getAll()
    {
        $Zonas = zonas::all();
        return $Zonas;
    }

    public function getcatalogo()
    {  $Catalogo = DB::select('SELECT z.id, z.nombre,z.estatus, z.id_ciudad, c.nombre as nomciudad, e.nombre as nomestado
																FROM zonas z LEFT JOIN ciudades c ON z.id_ciudad = c.id
																						 LEFT JOIN estados e  ON c.id_estado = e.id
                							WHERE z.estatus = 1 ');
        return $Catalogo;
		}
		
		public function add(Request $request){
			$addzona = zonas::create($request->all());
			
			if($addzona):
				return "La Zona se ah insertado correctamente";
			else:
				return "Ocurrio un problema al crear la zona, por favor intentelo mas tarde.";
			endif;

		}
		
		public function update($id, Request $req){
			$data = DB::update('UPDATE zonas SET nombre=:nombre,id_ciudad=:id_ciudad, estatus=:estatus
														WHERE id =:id',
													['nombre'=> $req -> nombre, 'id_ciudad'=> $req -> id_ciudad, 'estatus'=> $req -> estatus, 'id'=> $id	]
												);
			
			return 'La Zona se actualizo correctamente';
	}

    
}
