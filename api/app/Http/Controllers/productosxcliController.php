<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\productos;

class productosxcliController extends Controller
{		
	//! FUNCIONES PROBADAS EN ACTUALIZACION CON MRP *********************************************
    public function productosxCli($id_cliente){
        $productosxCli = DB::select('SELECT p.*,
																						c.nombre as nomcli, 
																				 		u.nombre as unidad
																			FROM prodxcli p 
																				LEFT JOIN clientes c ON p.id_cliente = c.id 
																				LEFT JOIN unidades u ON p.id_unidad  = u.id
																			WHERE id_cliente = ?', 
																			[$id_cliente]
																		);
        return $productosxCli ? response($productosxCli,200) : response([], 500); 
		}

	//  TODO EL PROCESO PARA CREAR PRODUCTO  *************** INICIO
		public function crearDetalle(Request $req){
			$creaProducto = DB::table('prodxcli')->insertGetId(
					[
						'id_cliente' 	=> $req -> id_cliente ,
						'nombre'			=> $req -> nombre ,
						'codigo'			=> $req -> codigo ,
						'descripcion' => $req -> descripcion ,
						'revision'	  => $req -> revision ,
						'url'				  => $req -> url ,
						'dx'				  => $req -> dx ,
						'id_dx'    		=> 0,
						'id_unidad'   => $req -> id_unidad
					]
			);
			return $creaProducto ? response("El producto se creo correctamente" ,200): 
														 response("Error al crear producto, intentelo mas tarde" ,500); 
		}

	// TODO EL PROCESO PARA ACUTALIZAR PRODUCTO ************ INICIO
		public function actualizaProducto($id, Request $req){
			$producto = DB::update('UPDATE prodxcli SET id_cliente=:id_cliente,nombre=:nombre, codigo=:codigo, descripcion=:descripcion,
																									revision=:revision, url=:url, id_unidad=:id_unidad, dx=:dx
																WHERE id=:id', ['id_cliente'  => $req -> id_cliente,
																								'nombre' 		  => $req -> nombre,
																								'codigo' 		  => $req -> codigo,
																								'descripcion' => $req -> descripcion,
																								'revision' 		=> $req -> revision,
																								'url' 		    => $req -> url,
																								'id_unidad'   => $req -> id_unidad,
																								'dx'   			  => $req -> dx,
																								'id' 				  => $id	]);
																								
			
			return $producto ? response("El producto se actualizo correctamente" ,200): 
													response("Ocurrio un error, intentelo mas tarde" ,500);
		}

		public function PxCxD(Request $req){
			$productosxCli = DB::select('SELECT p.id, p.nombre, p.codigo, p.descripcion,p.estatus 
																		FROM prodxcli p 
																	 WHERE dx = ? AND id_cliente = ?', 
																	 [$req -> id_depto , $req -> id_cliente]);
			return $productosxCli ? response($productosxCli,200) : response([], 500); 
		}

		


		//! *****************************************************************************************


		
	

}
