<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\prodterminadoController; 

class entradasController extends Controller
{
		public function generar_nueva_entrada(Request $req){
			$entrada = DB::table('entradas')->insertGetId(
					[
						'id_ot'	        => $req -> id_ot,
						'id_produccion' => $req -> id_produccion,
						'id_sucursal'   => $req -> id_sucursal, 
						'id_producto'   => $req -> id_producto,         
						'cantidad'      => $req -> cantidad,
						'id_depto_envia'=> $req -> id_depto_envia,
						'id_creador'    => $req -> id_creador
					]
				);
				
			//* ACTUALIZAR MOVIMIENTO ANTERIOR ****************************************
			$movimiento = new produccionController();
			$movimiento -> actualiza_movim_anterior($req -> id_movim, $req -> cantidad, $req -> id_creador);
			
			return $entrada? response("El producto se ha envíado correctamente.",200):
												response("Ocurrio un error, intentelo nuevamente.",500);
		}

		public function obtener_entradas(Request $req){
			$entradas = DB::select('SELECT e.*,
																		ot.id_cliente, ot.oc,
																		c.nombre as nomcli,
																		s.nombre as nomsucursal,
																		p.codigo , p.id_unidad,
																		un.nombre as unidad,
																		d.nombre as deptoemisor,
																		u.nombre as nomemisor 
																FROM entradas e 
																	LEFT JOIN ot           ON e.id_ot = ot.id
																	LEFT JOIN clientes c   ON ot.id_cliente = c.id
																	LEFT JOIN sucursales s ON e.id_sucursal = s.id
																	LEFT JOIN prodxcli p   ON e.id_producto = p.id
																	LEFT JOIN unidades un  ON p.id_unidad = un.id
																	LEFT JOIN depto_por_suc d ON e.id_depto_envia = d.id
																	LEFT JOIN users u ON e.id_creador = u.id
															WHERE e.id_sucursal   = ? AND
																		e.estatus = ? AND
																		DATE(e.creacion) BETWEEN DATE(?) AND DATE(?)',
																		[
																				$req -> id_sucursal,
																				$req -> estatus,
																				$req -> fecha1, 
																				$req -> fecha2
																		]);
				return $entradas ? $entradas: [];
		}

	//! ****************** ENVIAR A PRODUCTOS TERMINADOS ***********************************
		public function anadir_producto_terminado(Request $req){
		  $validacion = $this -> validar_cantidad_solcitada($req);

			if(!$validacion['estatus']):
				return response("Solo puedes acceder" ." " .$validacion['cantidad'], 500);
			endif;

			// 1. BUSCO EN PRODUCTOS TERMINADOS SI EXISTE EL PRODUCTO QUE RECIBO
			$producto = $this -> buscar_producto_registrado($req -> id_producto);
			// 2.EVALUO SI EL PRODUCTO EXISTE O NO
			// 2.1 SI NO EXISTE CREO UN NUEVO REGISTRO.
			// 2.2 SI SI EXISTE ENTONCES SOLO SUMO LA CANTIDAD QUE RECIBO CON LA ACTUAL DEL REGISTRO.
			$resultado = !$producto ? $this -> agregar_producto_terminado($req) : 
																$this -> actualizar_producto_terminado($req -> cantidad_recibida, $producto);
			// 3. ACTUALIZO LA CANTIDAD AUTORIZADA EN EL REGISTRO DE ENTRADA.
			$this -> actualizar_cantidad_entrega($req);
			// 3.1. ACTUALIZAR LA CANTIDAD TOTAL DE PRODUCCION.
			$this -> actualizar_total_produccion($req);
			// 4. EVALUO RESPUESTA PARA RETORNAR AL FRONDEND.
			return $resultado ? response("Se añadio a productos terminados correctamente.",200):
													response("Ocurrio un error, intentelo mas tarde.",500);
		}
		
		public function validar_cantidad_solcitada($detalle){
			$cant_sol = DB::select('SELECT cant_sol FROM produccion 
															WHERE id = ?', [$detalle['id_produccion']]);

			$entradas = DB::select('SELECT sum(cantidad_recibida) as total FROM entradas
																WHERE id_produccion = ? AND id_producto = ?',
															[$detalle['id_produccion'], $detalle['id_producto'] ]);

			$Total   = $entradas[0] -> total + $detalle['cantidad_recibida'];
			$Retorno = $cant_sol[0] -> cant_sol - $entradas[0] -> total;

			if($Total <= $cant_sol[0] -> cant_sol ):
				return ["cantidad" => 0 , "estatus" => true ];
			else:
				return ["cantidad" => $Retorno , "estatus" => false ];
			endif;
		}

		// 1. BUSCO EN PRODUCTOS TERMINADOS SI EXISTE EL PRODUCTO QUE RECIBO
		public function buscar_producto_registrado($id_producto){
			$producto =DB::select('SELECT * FROM productos_terminados WHERE id = ?',[$id_producto]);
			return $producto ? $producto : false;
		}

		// 2.1 CREO UN NUEVO REGISTRO EN PRODUCTO TERMINDO.
		public function agregar_producto_terminado($data){
			$id_producto_terminado = DB::table('productos_terminados')->insertGetId(
				[
					'id_producto'   => $data['id_producto'] ,        
					'cantidad'      => $data['cantidad_recibida'],
					'id_sucursal'   => $data['id_sucursal'], 
					'id_creador'    => $data['id_creador']
				]
			);
			return $id_producto_terminado? true:false;
		}
		
		// 2.2 SUMO LA CANTIDAD QUE RECIBO CON LA ACTUAL DEL REGISTRO
		public function actualizar_producto_terminado($cantidad, $producto){
			$producto_terminado = DB::update('UPDATE productos_terminados
                                    SET cantidad=:cantidad + cantidad
                                WHERE id=:id',
            [
                'cantidad' => $cantidad,
                'id' => $producto[0] -> id
            ]);
			return $producto_terminado? true:false;
			
		}

		// 3. ACTUALIZO LA CANTIDAD AUTORIZADA EN EL REGISTRO DE ENTRADA.
		public function actualizar_cantidad_entrega($data){
			DB::update('UPDATE entradas
											SET cantidad_recibida=:cantidad_recibida,
													estatus=:estatus
									WHERE id=:id',
									[
											'cantidad_recibida' => $data['cantidad_recibida'],
											'estatus' => 1,
											'id' => $data['id_entrada']
									]);
		}
		
		// 3.1. ACTUALIZAR LA CANTIDAD TOTAL DE PRODUCCION. 
		public function actualizar_total_produccion($data){
			DB::update('UPDATE produccion
										SET total=:total + total WHERE id=:id',
									[
											'total' => $data['cantidad_recibida'],
											'id' 		=> $data['id_produccion']
									]);
		}
		
		
	//! *************************************************************************************


}
