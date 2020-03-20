<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\precios;

class preciosController extends Controller
{
    public function getAll(){
        $Precios = precios::all();
        return $Precios;
		}

		public function getcatalogo(){
			$CatPrecios = DB::select('SELECT p.id, p.nombre, p.id_zona, z.nombre as nomzona, p.razon_social, 
																					p.tipo_prov, p.rfc, p.curp
																	FROM precios p LEFT JOIN zonas z ON p.id_zona = z.id
																	WHERE p.estatus = 1');
			return $CatPrecios;
		}

		public function preciosxId($id){
			$preciosxid = DB::select('SELECT p.id, p.id_producto, prod.codigo, prod.nombre as nomprod, p.id_proveedor, prov.nombre as nomprov, 
																		   p.tipo_precio, tp.nombre as nomtipo_precio, p.id_moneda, m.codigo as cod_moneda, p.estatus, p.predeterminado,
																			 p.precio, p.produccion, p.pje_admin, p.costo_admin,p.total
																FROM precios p LEFT JOIN productos prod 	ON p.id_producto  = prod.id
																					     LEFT JOIN proveedores prov ON p.id_proveedor = prov.id
																							 LEFT JOIN tipos_precios tp ON p.tipo_precio  = tp.id 
																							 LEFT JOIN monedas m        ON P.id_moneda    = m.id
																WHERE p.id_producto = ?', [$id]);
				return $preciosxid;
		}

		
		public function mp_producto(){
			$mp_producto = DB::select('SELECT pr.id_producto as id, pr.precio, p.nombre,p.codigo,p.descripcion, prov.nombre as nomprov
																		FROM  precios pr LEFT JOIN  productos p ON pr.id_producto = p.id 
																										 LEFT JOIN proveedores prov ON p.id_proveedor = prov.id
																	WHERE pr.estatus = 1 AND pr.precio > 0 AND p.tipo_producto = 1');
			return $mp_producto;
		}

		public function detalle_productos($id){
			$det_producto = DB::select('SELECT dt.id_producto as id, p.nombre, p.codigo, p.descripcion, prov.nombre as nomprov, pr.precio 
																		FROM det_prods dt LEFT JOIN productos p ON  dt.id_producto = p.id
																			LEFT JOIN proveedores prov ON p.id_proveedor = prov.id
																			LEFT JOIN precios pr ON dt.id_precio = pr.id
																	WHERE dt.id_precio = ?',[$id]);
			return $det_producto;
		}
		

		public function add(Request $request){
			// INSERTO EN LA TABLA DE PRECIOS
			$precioxproducto = precios::create($request->all());
			
			if($request -> tipo_producto === 2):   // VALIDO SI EL TIPO DE PRODUCTO ES PRODUCTO FINAL
				$detalle   = $request -> detalle; 	 // CREO UNA VARIABLE PARA GUARDAR EL DETALLE
				$id_precio = $precioxproducto -> id; // GUARDO EL ID DEL PRECIO CREADO

				$contador  = 0;

				for($i=0 ; $i< count($request -> detalle) ; $i++):
					$id_producto = $detalle[$i]['id']; // OBTENGO EL ID DEL PRODUCTO EN LA POSICION i 
					$insertDetalle = $this->detalleProducto($id_precio, $id_producto); //MANDO A INSERTAR EL DETALLE
					
					if($insertDetalle != 1): 
						 $contador++; // SI LA PETICION RESPONSE FALSO AGREGO EL PROBLEMA AL ARRAY
					endif;
				endfor;

				if($contador === 0):
					return "El precio por producto se ha registrado correctamente.";
				endif;
			else:
				return "El precio de la materia prima se ha registrado correctamente. ";
			endif;
		}
		
		public function update($id, Request $req){
			$data = DB::update('UPDATE precios SET nombre=:nombre, id_zona=:id_zona, razon_social=:razon_social, tipo_prov=:tipo_prov, 
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

	//================================ FUNCIONES QUE SE EJECUTAN INTERNAMENTE =======================================
		public function detalleProducto($id_precio, $id_producto){
				$det_producto = DB::insert('INSERT INTO det_prods(id_producto, id_precio )
														VALUES(?,?)', [$id_producto,$id_precio  ]);
				return $det_producto;
		}
}
