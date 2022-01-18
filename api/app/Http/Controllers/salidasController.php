<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\prodterminadoController; 


class salidasController extends Controller
{
    public function generar_nueva_salida(Request $req){
			//* ACTUALIZAR EXISTENTE EN PRODUCTO TERMINADO ****************************************
			$prod_terminado = new prodterminadoController();
			$estatus = $prod_terminado -> descontar_cantidad_inventario($req -> id_pt, $req -> cantidad);
			$salida = null;

			if($estatus):
				$salida = DB::table('salidas')->insertGetId(
							[
									'id_sucursal'   => $req -> id_sucursal, 
									'id_producto'   => $req -> id_producto,         
									'cantidad'      => $req -> cantidad,
									'referencia'    => $req -> referencia,
									'id_creador'    => $req -> id_creador
							]
					);
			else:
				return response("El almacén no cuenta con la cantidad suficiente para procesar la salida", 500);
			endif;

			if($salida && $estatus):
					return response("La salida del producto se proceso correctamente.", 200);
			else:
					return response("Ocurrio un error, intentelo nuevamente.",500);
			endif;
    }  


		public function obtener_salidas_almacen(Request $req){
			$salidas = DB::select('SELECT s.*, 
																		p.codigo, 
																		un.nombre as unidad,
																	  sc.nombre as nomsucursal, 
																		u.nombre as usuario
															FROM salidas s
																LEFT JOIN prodxcli p ON s.id_producto = p.id
																LEFT JOIN unidades un on p.id_unidad  = un.id
																LEFT JOIN sucursales sc ON s.id_sucursal = sc.id
																LEFT JOIN users u ON s.id_creador = u.id
														WHERE DATE(s.creacion) BETWEEN DATE(?) AND DATE(?) AND s.id_sucursal = ?',
														[$req -> fecha1 , 
															$req -> fecha2,
															$req -> id_sucursal
														]);
			return $salidas ? $salidas : [];
		}
}
