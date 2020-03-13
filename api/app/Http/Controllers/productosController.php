<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\productos;

class productosController extends Controller
{
    public function getAll()
    {
        $Productos = productos::all();
        return $Productos;
		}
		
		public function getcatalogo()
		{
			$CatProvedores = DB::select('SELECT p.codigo, p.nombre, p.descripcion, p.obs, p.foto, p.estatus, p.tipo_producto,
																					p.id_linea, l.nombre as nomlin, p.id_proveedor, prov.nombre as nomprov,
																					p.id_unidad, u.nombre as nomunidad
																	FROM productos p LEFT JOIN lineas_prods l 	ON p.id_linea 		= l.id
																									 LEFT JOIN proveedores prov ON p.id_proveedor = prov.id 
																									 LEFT JOIN unidades u       ON p.id_unidad    = u.id
																	WHERE p.estatus = 1');
		}

		public function add(Request $request){
			$addprovedor = proveedores::create($request->all());
			
			if($addprovedor):
				return "El productos se ah insertado correctamente";
			else:
				return "Ocurrio un problema al crear el productos, por favor intentelo mas tarde.";
			endif;

		}
		
		public function update($id, Request $req){
			$data = DB::update('UPDATE productos SET nombre=:nombre, estatus=:estatus WHERE id =:id',
													['nombre'=> $req -> nombre,'estatus'=> $req -> estatus, 'id'=> $id	]
												);
			
			return 'El productos se actualizo correctamente';
	}
}
