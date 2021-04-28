<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //USAR ESCRITURA SQL


class registroActividadController extends Controller
{
    
  public function AgregaResultadosActividad(Request $req){
		$resultado = DB::table('registro_actividad')->insertGetId(   //! INSERTO PRODUCTO EXISTENTE
			[
					'id_movim_sol'   =>  $req -> id_movim_sol,
					'resultado'      =>  $req -> resultado,
					'fecha'          =>  $req -> fecha,
					'hora'		       =>  $req -> hora ,
					'id_creador'     =>  $req -> id_creador
			]
		);
		return $resultado ? response('Se creo correctamente',200):
												response('Ocurrio un error intentalo mas tarde.',500);
	}

	public function ObtenerResultadosxId($id){
		$regAct = DB::select('SELECT * FROM registro_actividad WHERE id_movim_sol = ?', [$id ]);
		return $regAct ? $regAct : []; 
	}

	public function EliminaRegAct($id){
		$eliminaReg = DB::delete('DELETE FROM registro_actividad WHERE id = ?', [$id]);
		return $eliminaReg ? response('Se elimino correctamente.'):
												 response('Ocurrio un error intentalo mas tarde.',500);
	}

	

}
