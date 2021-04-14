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
		
		public function getcatalogo()	{
			$CatProvedores = DB::select('SELECT p.id, p.nombre, p.id_zona, z.nombre as nomzona, p.razon_social, p.tipo_prov, 
																				  p.rfc, p.direccion, p.cp, p.id_ciudad, cty.nombre as ciudad, e.nombre as estado, 
																					pv.nombre as pais, p.tel1, p.ext1, p.tel2, p.ext2, p.contacto,p.contacto2, p.estatus
																	FROM proveedores p LEFT JOIN zonas z 		  ON p.id_zona = z.id
																										 LEFT JOIN ciudades cty ON p.id_ciudad = cty.id
																										 LEFT JOIN estados e 	  ON cty.id_estado = e.id
																										 LEFT JOIN paises pv 	  ON e.id_pais = pv.id');
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
																								 tel1=:tel1, ext1=:ext1, tel2=:tel2, ext2=:ext2, contacto=:contacto,
																								 contacto2=:contacto2, rfc=:rfc, direccion=:direccion, id_ciudad=:id_ciudad,cp=:cp,
																								 estatus=:estatus
													WHERE id =:id',
													['nombre'				=> $req -> nombre, 			 'id_zona'	 => $req -> id_zona,
													 'razon_social' => $req -> razon_social, 'tipo_prov' => $req -> tipo_prov,
													 'tel1' 				=> $req -> tel1,         'ext1' 		 => $req -> ext1, 
													 'tel2' 		 		=> $req -> tel2, 				 'ext2' 		 => $req -> ext2, 
													 'contacto' 		=> $req -> contacto,     'contacto2' => $req -> contacto2,
													 'rfc' 					=> $req -> rfc, 				 'direccion' => $req -> direccion,
													 'id_ciudad' 		=> $req -> id_ciudad, 	 'cp' 					=> $req -> cp,
													 'estatus'			=> $req -> estatus, 		 'id'=> $id	]
												);
			
			return 'El proveedor se actualizo correctamente';
	}

	public function cambiaEstatusP( Request $req){
		return DB::update('UPDATE proveedores SET estatus=:estatus WHERE id=:id',['estatus' => $req-> estatus, 'id' => $req -> id]);
	}
}
