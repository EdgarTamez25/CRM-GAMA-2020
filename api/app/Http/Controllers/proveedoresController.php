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
			$CatProvedores = DB::select('SELECT p.id, p.nombre, p.id_zona, z.nombre as nomzona, p.razon_social, 
																					p.tipo_prov, p.rfc, p.curp
																	FROM proveedores p LEFT JOIN zonas z ON p.id_zona = z.id
																	WHERE p.estatus = 1');
			return $CatProvedores;
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
			$data = DB::update('UPDATE proveedores SET nombre=:nombre, id_zona=:id_zona, razon_social=:razon_social, tipo_prov=:tipo_prov, 
																								 rfc=:rfc, curp=:curp,estatus=:estatus
													WHERE id =:id',
													['nombre'				=> $req -> nombre, 
													 'id_zona'			=> $req -> id_zona,
													 'razon_social' => $req -> razon_social,
													 'tipo_prov' 		=> $req -> tipo_prov,
													 'rfc' 					=> $req -> rfc,
													 'curp' 				=> $req -> curp,
													 'estatus'			=> $req -> estatus, 'id'=> $id	]
												);
			
			return 'El proveedor se actualizo correctamente';
	}
}
