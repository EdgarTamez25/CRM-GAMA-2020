<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class programacionFlexoController extends Controller
{
		public function obtenerProgramacion(Request $req){
			$programaciones = DB::select('SELECT f.id, f.id_det_ot, do.id_ot, ot.id_cliente, c.nombre as nomcli, 
																				   do.id_producto, p.codigo, do.cantidad, f.fecha_prog, f.id_maquina,
																			     m.nombre as maquina, f.id_pleca, f.id_suaje, f.hora_inicio, f.hora_fin, 
																			     f.urgencia,f.creacion, f.id_creador, f.id_sucursal, f.estatus, f.finalizacion
																			FROM flexo_ot f LEFT JOIN det_ot do  ON f.id_det_ot = do.id
																						   			  LEFT JOIN ot         ON do.id_ot    = ot.id
																			                LEFT JOIN clientes c ON ot.id_cliente = c.id
																			                LEFT JOIN prodxcli p ON do.id_producto = p.id
																			                LEFT JOIN maquinas m ON f.id_maquina   = m.id
																		WHERE f.estatus = ? AND f.id_sucursal AND f.creacion BETWEEN ? AND ? ORDER BY f.urgencia DESC, f.id DESC ',
																		[$req -> estatus , $req -> fecha1 , $req -> fecha2 ]);

			return $programaciones ? $programaciones : [];
		}

    public function programacionFlexo(Request $req){
			$id_flexo = DB::table('flexo_ot')->insertGetId(   //! INSERTO PRODUCTO NUEVO
					[
									'fecha_prog' 		  => $req -> fecha_prog,
									'id_maquina' 			=> $req -> id_maquina,
									'ot'  		        => $req -> orden_trabajo,
									'num_partida'		 	=> $req -> num_partida,
									'id_cliente'      => $req -> id_cliente,
									'id_producto'    	=> $req -> id_producto,
									'cantidad'        => $req -> cantidad,
									'id_pleca'    		=> $req -> id_pleca,
									'id_suaje'    		=> $req -> id_suaje,
									'hora_inicio'    	=> $req -> hora_inicio,
									'hora_fin'    		=> $req -> hora_fin,
									'urgencia'        => $req -> urgencia
					]
				
			);
			
			return $id_flexo ? response("La programación se agrego correctamente",200): 
													response("Ocurrio un error por favor intentelo de nuevo", 500);

    }
		
		public function actualizaProgramacion($id, Request $req){
			$putPermiso = DB::update('UPDATE flexo_ot SET fecha_prog=:fecha_prog, id_maquina=:id_maquina,id_pleca=:id_pleca,
																									 id_suaje=:id_suaje, hora_inicio=:hora_inicio, hora_fin=:hora_fin,
																									 estatus=:estatus
                                	WHERE id=:id',
                              [ 'fecha_prog'	=> $req -> fecha_prog   , 'id_maquina'	=> $req -> id_maquina,
                                'id_pleca'    => $req -> id_pleca     , 'id_suaje'    => $req -> id_suaje, 
                                'hora_inicio' => $req -> hora_inicio  , 'hora_fin'    => $req -> hora_fin,     
																'estatus'     => $req -> estatus      , 'id'          => $id	
                              ]
												);
    	return $putPermiso ? response("La programación se actualizo correctamente",200):
												   response("Ocurrio un error intentelo de nuevo", 500);
		}

		public function DetalleProgramacion($id){
			$detalle = DB::select('SELECT * FROM det_flexo_ot f WHERE id_flexo_ot = ? ', [$id]);
			return $detalle ? $detalle : response('No hay datos registrados',500);
		}

		public function InicializarProgramacion(Request $req){
			$det_flexo = DB::table('det_flexo_ot')->insertGetId(   //! INSERTO PRODUCTO NUEVO
				[
								'id_flexo_ot' 		=> $req -> id,
								'id_usuario' 			=> $req -> id_usuario,
								'inicio'  		    => $req -> inicio,
				]
			);
			
			return $det_flexo ? response("Se inicializo correctamente",200): 
													response("Ocurrio un error por favor intentelo de nuevo", 500);
		}

		public function actualizarDetalle($id, Request $req){
			$putDetalle = DB::update('UPDATE det_flexo_ot SET dificultad=:dificultad, velocidad=:velocidad, id_material=:id_material, bobinas=:bobinas,
                                                   mtsxbobina=:mtsxbobina,mts_fabricados=:mts_fabricados, scrap=:scrap,ancho_bobina=:ancho_bobina,
																									 largo_bobina=:largo_bobina, id_pleca=:id_pleca, est1=:est1, cant1=:cant1, 
																																			 												     est2=:est2, cant2=:cant2,
																																																	 est3=:est3, cant3=:cant3,
																																																	 est4=:est4, cant4=:cant4,
																																																	 comentario=:comentario
										         		WHERE id=:id',
		                              [ 'dificultad'	=> $req -> dificultad   , 'velocidad'	     => $req -> velocidad,
		                                'id_material' => $req -> id_material  , 'bobinas' 		   => $req -> bobinas,
		                                'mtsxbobina' => $req -> mtsxbobina    , 'mts_fabricados' => $req -> mts_fabricados,
		                                'scrap'       => $req -> scrap        , 'ancho_bobina'   => $req -> ancho_bobina,
		                                'largo_bobina'=> $req -> largo_bobina , 'id_pleca'			 => $req -> id_pleca,
																		'est1' 				=> $req -> est1         , 'cant1'          => $req -> cant1, 
																		'est2' 				=> $req -> est2         , 'cant2'          => $req -> cant2, 
																		'est3' 				=> $req -> est3         , 'cant3'          => $req -> cant3, 
																		'est4'		 		=> $req -> est4         , 'cant4'          => $req -> cant4, 
																		'comentario'  => $req -> comentario   ,	'id'             => $id	
		                              ]
														);
    	return $putDetalle ? response("Se actualizo correctamente",200):
												   response("Ocurrio un error intentelo de nuevo", 500);
		}

		public function FinalizarOTFlexo($id, Request $req){
			$finalizacion = DB::update('UPDATE det_flexo_ot SET fin=:fin, estatus=:estatus WHERE id=:id',
                              [ 'fin'	=> $req -> fin , 'estatus' => $req -> estatus, 'id'=> $id ]
												);

			$this -> actualizarFlexoOT($req -> id_flexo_ot, $req -> fin);

    	return $finalizacion ? response("Se finalización correctamente",200):
												     response("Ocurrio un error intentelo de nuevo", 500);
		}

		public function actualizarFlexoOT($id, $fin){
			return DB::update('UPDATE flexo_ot SET estatus=:estatus WHERE id=:id',
                              [ 'estatus' => 3, 'id'=> $id ]
												);
		}

		public function cancelarOTFlexo($id){
			$cancelacion = DB::update('UPDATE flexo_ot SET estatus=:estatus WHERE id=:id',['estatus' => 4 , 'id' => $id]);
			return $cancelacion? response('Se cancelo correctamente',200): response('Ocurrio un error, intentelo mas tarde', 500);
		}
}	
