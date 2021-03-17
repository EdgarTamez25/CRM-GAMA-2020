<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class programacionFlexoController extends Controller
{
		public function obtenerProgramacion(Request $req){
			$programaciones = DB::select('SELECT f.id, f.fecha_prog,f.id_maquina, m.nombre as maquina, f.ot, f.num_partida,
																					 f.id_cliente, c.nombre as nomcli, f.id_producto, p.codigo as producto, f.cantidad,
																					 f.finalizacion,f.id_pleca, f.id_suaje, s.dientes as suaje, 
																					 f.hora_inicio, f.hora_fin, f.urgencia, f.estatus FROM flexo_ot f 
																			LEFT JOIN maquinas m  ON f.id_maquina  = m.id
																			LEFT JOIN clientes c  ON f.id_cliente  = c.id 
																			LEFT JOIN prodxcli p  ON f.id_producto = p.id
																			LEFT JOIN suajes   s  ON f.id_suaje    = s.id
																		WHERE f.estatus = ? AND f.fecha_prog BETWEEN ? AND ? ORDER BY f.urgencia DESC, f.id DESC ',
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
			$putPermiso = DB::update('UPDATE flexo_ot SET fecha_prog=:fecha_prog, id_maquina=:id_maquina, ot=:ot, num_partida=:num_partida,
                                                   id_cliente=:id_cliente,id_producto=:id_producto, cantidad=:cantidad,id_pleca=:id_pleca,
																									 id_suaje=:id_suaje, hora_inicio=:hora_inicio, hora_fin=:hora_fin, urgencia=:urgencia
                                	WHERE id=:id',
                              [ 'fecha_prog'	=> $req -> fecha_prog   , 'id_maquina'	=> $req -> id_maquina,
                                'ot' 					=> $req -> orden_trabajo, 'num_partida' => $req -> num_partida,
                                'id_cliente'  => $req -> id_cliente   , 'id_producto' => $req -> id_producto,
                                'cantidad'    => $req -> cantidad     , 'id_pleca'    => $req -> id_pleca,
                                'id_suaje'    => $req -> id_suaje     , 'hora_inicio' => $req -> hora_inicio,
																'hora_fin'    => $req -> hora_fin     , 'urgencia'    => $req -> urgencia,
																'id'          => $id	
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
			return DB::update('UPDATE flexo_ot SET finalizacion=:finalizacion, estatus=:estatus WHERE id=:id',
                              [ 'finalizacion'	=> $fin, 'estatus' => 3, 'id'=> $id ]
												);
		}

		public function cancelarOTFlexo($id){
			$cancelacion = DB::update('UPDATE flexo_ot SET estatus=:estatus WHERE id=:id',['estatus' => 2 , 'id' => $id]);
			return $cancelacion? response('Se cancelo correctamente',200): response('Ocurrio un error, intentelo mas tarde', 500);
		}
}	
