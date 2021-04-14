<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class maquinasController extends Controller
{
    public function Maquinas(){
        return DB::select('SELECT * FROM maquinas WHERE estatus = 1');
    }
		
		public function ObtenerMaquinasxOp(Request $req){
			$maquinasxOp = DB::select('SELECT mo.id,mo.id_maquina, m.nombre as maquina, mo.id_operador, u.nombre as operador, mo.fecha, mo.estatus
																	FROM  maquinax_op mo LEFT JOIN maquinas m ON mo.id_maquina = m.id
																											 LEFT JOIN users    u ON mo.id_operador = u.id
																	WHERE fecha = ?',[ $req -> fecha]);
			return $maquinasxOp ? $maquinasxOp : [];

		}

    public function AgregarMaquinasxOP(Request $req){
			$maquinaxOp = DB::table('maquinax_op')->insertGetId(  
					[
													'id_maquina' 			=> $req -> id_maquina,
													'id_operador'		 	=> $req -> id_operador,
													'fecha'    	=> $req -> fecha,
					]
			);
			
			return $maquinaxOp ? response("Agregado Correctamente",200): 
													 response("Ocurrio un error por favor intentelo de nuevo", 500);
    }

		public function EditarMaquinasxOP(Request $req){ 
			$editarMaquina = DB::update('UPDATE maquinax_op SET id_maquina=:id_maquina, id_operador=:id_operador, fecha=:fecha WHERE id=:id',
													['id_maquina' => $req -> id_maquina,
													 'id_operador'=> $req -> id_operador,
													 'fecha'			=> $req -> fecha, 
													 'id'			    => $req -> id	
												  ]
												);
			return $editarMaquina? response('Se actualizo correctamente', 200): 
														response("Ocurrio un error por favor intentelo de nuevo", 500);
		}


		public function MaquinaAsignada(Request $req){
			$prog_op = DB::select('SELECT * FROM  maquinax_op WHERE fecha = ? AND id_operador = ?',[ $req -> fecha, $req -> id_operador]);
			return $prog_op ? $prog_op: response("No hay asignaciones para ti. Pide a tu encargado que te asigne a una estación",500);

		}

		public function ProgramacionMaquina($id_maquina){
			$programacion = DB::select('SELECT  f.id, f.fecha_prog,f.id_maquina, m.nombre as maquina, f.ot, f.num_partida,
																					f.id_cliente, c.nombre as nomcli, f.id_producto, p.codigo as producto, f.cantidad,
																					f.finalizacion,f.id_pleca, pl.dientes as pleca, f.id_suaje, s.dientes as suaje, 
																					f.hora_inicio, f.hora_fin,f.urgencia, f.estatus FROM flexo_ot f 
																		LEFT JOIN maquinas m  ON f.id_maquina  = m.id
																		LEFT JOIN clientes c  ON f.id_cliente  = c.id 
																		LEFT JOIN prodxcli p  ON f.id_producto = p.id
																		LEFT JOIN plecas   pl ON f.id_pleca    = pl.id
																		LEFT JOIN suajes   s  ON f.id_suaje    = s.id
																		WHERE f.estatus = 1   AND f.id_maquina = ?',
																		[ $id_maquina ]);

			return $programacion ? $programacion: response("No hay programaciones para está maquina",500);
			
		}

		public function EliminarAsignacion($id){
			$eliminaAsignacion = DB::delete('DELETE FROM maquinax_op WHERE id = ?', [ $id]);
			return $eliminaAsignacion ? response("Se elimino correctamente",200):
															 response("Ocurrio un error amiguito, vuelve a intentarlo mas tarde", 500);
		}

		public function ValidaConservacion(Request $req){
			$validacion = DB::select('SELECT * FROM maquinax_op WHERE fecha = ?', [$req -> fecha1]);
			return $validacion ? $validacion:[]; 
		}
}   

