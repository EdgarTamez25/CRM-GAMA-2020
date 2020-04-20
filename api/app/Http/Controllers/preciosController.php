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
			$mp_producto = DB::select('SELECT pr.id_producto as id, pr.precio, p.nombre,p.codigo,p.descripcion, prov.nombre as nomprov, m.codigo as moneda
																		FROM  precios pr LEFT JOIN productos p ON pr.id_producto = p.id 
																										 LEFT JOIN proveedores prov ON p.id_proveedor = prov.id
																										 LEFT JOIN monedas m     ON  pr.id_moneda = m.id
																	WHERE pr.estatus = 1 AND pr.predeterminado = 1 AND p.tipo_producto = 1');
			return $mp_producto;
		}

		public function detalle_productos($id){
			$det_producto = DB::select('SELECT dt.id as id_key, dt.id_producto as id, p.nombre, p.codigo, p.descripcion, prov.nombre as nomprov, pr.precio 
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
		
		public function update($id, Request $request){
			// ACTUALIZO EN PRECIOS 
			$putPrecios = DB::update('UPDATE precios SET id_producto=:id_producto, id_proveedor=:id_proveedor, tipo_precio=:tipo_precio, id_moneda=:id_moneda, 
																								 	 precio=:precio, produccion=:produccion, pje_admin=:pje_admin, costo_admin=:costo_admin, total=:total
																WHERE id=:id',
																	[	$request -> id_producto, $request -> id_proveedor,
																		$request -> tipo_precio, $request -> id_moneda,
																		$request -> precio,      $request -> produccion,
																		$request -> pje_admin,   $request -> costo_admin,
																		$request -> total,       $id	
																	]
															);
			
			if($request -> tipo_producto === 2):   		// VALIDO SI EL TIPO DE PRODUCTO ES PRODUCTO FINAL
				$detalle   	= $request -> detalle; 	 		// CREO UNA VARIABLE PARA GUARDAR EL DETALLE
				$detABorrar = $request -> detalleActual;	// VARIABLE DEL DETALLE QUE CONSULTE

				for($a=0; $a< count($detABorrar); $a++):// CICLO PARA ELIMINAR REGISTROS EXISTENTES
					$borrarDetalle = $this->borrarDetalleProducto($detABorrar[$a]); //MANDO A ELIMINAR REGISTRO POR SU ID
				endfor;
			
				for($i=0 ; $i< count($detalle) ; $i++):
					$id_producto = $detalle[$i]['id']; // OBTENGO EL ID DEL PRODUCTO EN LA POSICION i 
					$insertDetalle = $this->detalleProducto($id, $id_producto); //MANDO A INSERTAR EL DETALLE
				endfor;
				
				return "El precio por producto se ha registrado correctamente.";
			else: 
				return "El precio por producto se ha registrado correctamente.";
			endif;
			
		}

		public function predeterminado(Request $request){
			//BUSCO TODOS LOS PRECIOS POR EL ARTICULO A ACTUALIZAR
			$productos = DB::select('SELECT id,id_producto FROM precios WHERE id_producto = ?',[$request -> id_producto]);

			for($i=0 ; $i< count($productos) ; $i++):
				if( $productos[$i] -> id === $request -> id_precio): 

					$cambiaAUno = DB::update('UPDATE precios SET predeterminado=:predeterminado 
															WHERE id=:id', // REPRESENTA EL ID DEL PRECIO
														['predeterminado'  => 1 , 
														 'id'=> $request -> id_precio 
														]);
													
				else:
					$cambiaACero = DB::update('UPDATE precios SET predeterminado=:predeterminado 
															WHERE id=:id', // REPRESENTA EL ID DEL PRECIO
														['predeterminado'  => 0 , 
														 'id'=> $productos[$i] -> id 
														]);
				endif;
			endfor;

			if($cambiaAUno):
				return "Precio predeterminado correctamente.";
			endif;
		}

	//================================ FUNCIONES QUE SE EJECUTAN INTERNAMENTE =======================================
		public function detalleProducto($id_precio, $id_producto){
				$det_producto = DB::insert('INSERT INTO det_prods(id_producto, id_precio, estatus )
														VALUES(?,?,?)', [$id_producto,$id_precio,1]);
				return $det_producto;
		}
		
		public function borrarDetalleProducto($id){ // ELIMINA LOS REGISTROS DEL DETALLE DEL PRODUCTO
			$productoEliminado = DB::delete('DELETE FROM det_prods WHERE id=?',[$id]);
			return $productoEliminado;
		}
}
