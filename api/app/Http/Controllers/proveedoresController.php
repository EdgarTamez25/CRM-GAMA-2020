<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\proveedores;

class proveedoresController extends Controller
{
    public function getAll()
    {
        $Proveedores = proveedores::all();
        return $Proveedores;
		}
		
		public function getcatalogo()
		{
			$CatProvedores = DB::select('SELECT p.nombre, p.id_subzona, z.nombre as nomzona, p.razon_social, 
																					p.tipo_prov, p.rfc, p.curp, p.id_precio  
																	FROM proveedores p LEFT JOIN subzonas z ON p.id_subzona = z.id
																	WHERE p.estatus = 1');
		}

		public function add(Request $request){
			$addprovedor = proveedores::create($request->all());
			
			if($addprovedor):
				return "El proveedor se ah insertado correctamente";
			else:
				return "Ocurrio un problema al crear el proveedor, por favor intentelo mas tarde.";
			endif;

		}
		
		public function update($id, Request $req){
			$data = DB::update('UPDATE proveedores SET nombre=:nombre, estatus=:estatus WHERE id =:id',
													['nombre'=> $req -> nombre,'estatus'=> $req -> estatus, 'id'=> $id	]
												);
			
			return 'El proveedor se actualizo correctamente';
	}
}
