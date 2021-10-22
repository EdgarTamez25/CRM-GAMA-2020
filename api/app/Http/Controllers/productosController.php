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

		public function ProdxClixDeptos(Request $req)
		{
			$productos = DB::select('SELECT nombre, codigo FROM prodxcli WHERE id_cliente = ? AND dx',[$req -> id_cliente, $req -> dx]);
			return $productos;
		}
		
		// public function getcatalogo(){
		// 	$CatProductos = DB::select('SELECT p.id,p.codigo, p.nombre, p.descripcion, p.obs, p.foto, p.estatus, p.tipo_producto,
		// 																			p.id_linea, l.nombre as nomlin, p.id_proveedor, prov.nombre as nomprov,
		// 																			p.id_unidad, u.nombre as nomunidad
		// 															FROM productos p LEFT JOIN lineas_prods l 	ON p.id_linea 		= l.id
		// 																							 LEFT JOIN proveedores prov ON p.id_proveedor = prov.id 
		// 																							 LEFT JOIN unidades u       ON p.id_unidad    = u.id
		// 															WHERE p.estatus = 1');
		// 	return $CatProductos;
		// }

		public function getcatalogo(){
			return  DB::select('SELECT p.id, p.codigo, p.nombre, p.descripcion, p.obs, p.foto, p.estatus, p.tipo_producto,p.cantidad,
																				 p.id_linea, l.nombre as nomlin, p.id_unidad, u.nombre as nomunidad,
																			IFNULL( ( SELECT pr.precio FROM precios pr WHERE predeterminado =1 AND id_producto = p.id), "0.00") AS precio,
																			IFNULL( ( SELECT m.codigo  FROM precios pr LEFT JOIN monedas m ON pr.id_moneda = m.id 
																									WHERE pr.predeterminado =1 AND id_producto = p.id), "") AS codmoneda,
																			IFNULL( ( SELECT prov.nombre FROM precios pr 
																										LEFT JOIN proveedores prov ON  pr.id_proveedor = prov.id 
																								WHERE predeterminado =1 AND id_producto = p.id), "Sin proveedor") AS nomprov,
																			IFNULL( ( SELECT DISTINCT(prov.id) FROM proveedores prov 
																										LEFT JOIN precios pr ON pr.id_proveedor = prov.id 
																								WHERE pr.predeterminado = 1 AND prov.nombre = nomprov),"0") AS id_proveedor
															FROM productos p LEFT JOIN lineas_prods l 	ON p.id_linea 		= l.id
																									 LEFT JOIN unidades u       ON p.id_unidad    = u.id') ;
<<<<<<< HEAD
		
			// return response()->json($CatProductos);
		}

		public function getcatalogoxId($id){
			return  DB::select('SELECT p.id, p.codigo, p.nombre, p.descripcion, p.obs, p.foto, p.estatus, p.tipo_producto,p.cantidad,
																				 p.id_linea, l.nombre as nomlin, p.id_unidad, u.nombre as nomunidad,
																			IFNULL( ( SELECT pr.precio FROM precios pr WHERE predeterminado =1 AND id_producto = p.id), "0.00") AS precio,
																			IFNULL( ( SELECT m.codigo  FROM precios pr LEFT JOIN monedas m ON pr.id_moneda = m.id 
																									WHERE pr.predeterminado =1 AND id_producto = p.id), "") AS codmoneda,
																			IFNULL( ( SELECT prov.nombre FROM precios pr 
																										LEFT JOIN proveedores prov ON  pr.id_proveedor = prov.id 
																								WHERE predeterminado =1 AND id_producto = p.id), "Sin proveedor") AS nomprov,
																			IFNULL( ( SELECT DISTINCT(prov.id) FROM proveedores prov 
																										LEFT JOIN precios pr ON pr.id_proveedor = prov.id 
																								WHERE pr.predeterminado = 1 AND prov.nombre = nomprov),"0") AS id_proveedor
															FROM productos p LEFT JOIN lineas_prods l 	ON p.id_linea 		= l.id
																									 LEFT JOIN unidades u       ON p.id_unidad    = u.id
														WHERE  p.id_linea =?',[$id]) ;
		
			// return response()->json($CatProductos);
=======
		
			// return response()->json($CatProductos);
		}

		public function getcatalogoxId($id){
			return  DB::select('SELECT p.id, p.codigo, p.nombre, p.descripcion, p.obs, p.foto, p.estatus, p.tipo_producto,p.cantidad,
																				 p.id_linea, l.nombre as nomlin, p.id_unidad, u.nombre as nomunidad,
																			IFNULL( ( SELECT pr.precio FROM precios pr WHERE predeterminado =1 AND id_producto = p.id), "0.00") AS precio,
																			IFNULL( ( SELECT m.codigo  FROM precios pr LEFT JOIN monedas m ON pr.id_moneda = m.id 
																									WHERE pr.predeterminado =1 AND id_producto = p.id), "") AS codmoneda,
																			IFNULL( ( SELECT prov.nombre FROM precios pr 
																										LEFT JOIN proveedores prov ON  pr.id_proveedor = prov.id 
																								WHERE predeterminado =1 AND id_producto = p.id), "Sin proveedor") AS nomprov,
																			IFNULL( ( SELECT DISTINCT(prov.id) FROM proveedores prov 
																										LEFT JOIN precios pr ON pr.id_proveedor = prov.id 
																								WHERE pr.predeterminado = 1 AND prov.nombre = nomprov),"0") AS id_proveedor
															FROM productos p LEFT JOIN lineas_prods l 	ON p.id_linea 		= l.id
																									 LEFT JOIN unidades u       ON p.id_unidad    = u.id
														WHERE  p.id_linea =?',[$id]) ;
		
			// return response()->json($CatProductos);
>>>>>>> AE
		}

		public function add(Request $request){
			$addproducto = productos::create($request->all());
			
			if($addproducto):
				return "El productos se ah insertado correctamente";
			else:
				return "Ocurrio un problema al crear el productos, por favor intentelo mas tarde.";
			endif;

		}
		
		public function update($id, Request $req){
			$data = DB::update('UPDATE productos SET codigo=:codigo, nombre=:nombre, descripcion=:descripcion, id_linea=:id_linea,
																							 tipo_producto=:tipo_producto, cantidad=:cantidad, id_unidad=:id_unidad,
																							 obs=:obs, foto=:foto, estatus=:estatus 
													WHERE id =:id',
													['codigo' 		 	 => $req -> codigo,
													 'nombre' 		 	 => $req -> nombre,
													 'descripcion' 	 => $req -> descripcion,
													 'id_linea' 		 => $req -> id_linea,
													 'tipo_producto' => $req -> tipo_producto,
													 'cantidad'  		 => $req -> cantidad,
													 'id_unidad' 		 => $req -> id_unidad,
													 'obs' 					 => $req -> obs,
													 'foto' 				 => $req -> foto,
													 'estatus' 			 => $req -> estatus, 
													 'id'	  			 	 => $id	
													 ]
												);
			
			return 'El productos se actualizo correctamente';
	}
}
