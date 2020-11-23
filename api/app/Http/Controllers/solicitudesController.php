<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //USAR ESCRITURA SQL

class solicitudesController extends Controller
{
	// !CATALOGO DE SOLICITUDES
	public function Solicitudes(){
		$solicitud = DB::select('SELECT s.id, s.id_cliente, c.nombre as nomcli, s.id_usuario, u.nombre as nomusuario, 
																	  s.fecha, s.hora, s.nota 
															FROM	solicitudes s LEFT JOIN clientes c ON s.id_cliente = c.id
																									LEFT JOIN users u    ON s.id_usuario = u.id');
		
		return $solicitud ? $solicitud: $solicitud = [];
	}

	//! CONSULTAR DETALLE DE LA SOLICITUD
	public function DetalleSolicitud($id){
		// ! IR A DET_SOL PARA OBTENER TODOS LOS PRODUCTOS DE LA SOLICITUD
		$detalle = DB::select('SELECT * FROM	det_sol WHERE id_solicitud = ?', [$id]);
		$detSol = [];

		for($i=0;$i<count($detalle);$i++ ):
			if($detalle[$i] -> px === 1):
				$existente = $this -> consultaProdExistente($detalle[$i] -> id_px);
				array_push($detSol,  $existente[0]);
			endif;
			if($detalle[$i] -> px === 2):
				$Modificacion = $this -> consultaProdModif($detalle[$i] -> id_px);
				array_push($detSol, $Modificacion[0]);
			endif;
			if($detalle[$i] -> px === 3):
				$Nuevos = $this -> consultaProdNuevo($detalle[$i] -> id_px);
				array_push($detSol, $Nuevos[0]);
			endif; 
		endfor;
		
		return $detSol ? $detSol: $detSol = [];
	}

	//! OBTENER MODIFICACIONES DE UNA SOLICITUD
	public function Modificaciones($id){
			return  DB::select('SELECT * FROM dx_modif WHERE id_prod_modif =?',[$id]);
	}

	// ! OBTENER CARACTERISTICAS POR FORMULARIO
	public function Caracteristicas(Request $req){
		switch ($req['dx'] ) {
			case 1:
				return $this -> Flexografia($req['id_dx'], $req['dx'] );
				break;
			case 3:
				return $this -> Digital($req['id_dx'], $req['dx'] );
				break;
		}
	}

	// TODO -> CONSULTAS CORRESPONDIENTES AL DETALLE DE SOLICITUD ******************
	// TODO ************************************************************************
	public function consultaProdExistente($id_px){
		return DB::select('SELECT * FROM prod_exist WHERE id =?',[$id_px]);
	}
	public function consultaProdModif($id_px){
		return DB::select('SELECT * FROM prod_modif WHERE id =?',[$id_px]);
	}
	public function consultaProdNuevo($id_px){
		return DB::select('SELECT * FROM prod_nuevo WHERE id =?',[$id_px]);
	}
	// TODO ************************************************************************


	// TODO CARACTERISTICAS POR FORMULARIO******************************************
	// TODO ************************************************************************
	public function Flexografia($id_dx, $dx){
		$arrayTemporal = [];

		$flexo    = DB::select('SELECT * FROM det_flexo WHERE id =?',[$id_dx]);
		$pantones = $this -> obtenerPantones($flexo[0] -> det_pantones, $dx);
		$acabados = $this -> obtenerAcabados($flexo[0] -> det_acabados, $dx);
		$arrayTemporal = ["id" 					   => $flexo[0] -> id, 
										  "id_material"    => $flexo[0] -> id_material,
										  "det_acabados"   => $flexo[0] -> det_acabados,
										  "etqxrollo"      => $flexo[0] -> etqxrollo,
										  "etqxpaso" 		   => $flexo[0] -> etqxpaso,
										  "med_nucleo" 	   => $flexo[0] -> med_nucleo, 
										  "med_desarrollo" => $flexo[0] -> med_desarrollo,
										  "med_eje" 			 => $flexo[0] -> med_eje,
										  "id_orientacion" => $flexo[0] -> id_orientacion,
										  "ancho" 			 	 => $flexo[0] -> ancho,
										  "largo" 			   => $flexo[0] -> largo,
										  "det_pantones"   => $flexo[0] -> det_pantones,
										  "pantones" 		   => $pantones,
										  "acabados" 		   => $acabados
										  ];

		return $arrayTemporal;


	}

	public function Digital($id_dx, $dx){
		$arrayTemporal = [];

		$digital       = DB::select('SELECT * FROM det_digital WHERE id =?',[$id_dx]);
		$pantones      = $this -> obtenerPantones($digital[0] -> det_pantones, $dx);
		$acabados      = $this -> obtenerAcabados($digital[0] -> det_acabados, $dx);
		$arrayTemporal = ["id" 					 => $digital[0] -> id, 
										  "id_material"  => $digital[0] -> id_material,
										  "det_sobre"    => $digital[0] -> det_sobre,
										  "det_pantones" => $digital[0] -> det_pantones,
										  "det_acabados" => $digital[0] -> det_acabados, 
										  "estructura"   => $digital[0] -> estructura,
										  "grosor" 			 => $digital[0] -> grosor,
										  "ancho" 			 => $digital[0] -> ancho,
										  "largo" 			 => $digital[0] -> largo,
										  "pantones" 		 => $pantones,
										  "acabados" 		 => $acabados
										  ];

		return $arrayTemporal;
	}
	// TODO ************************************************************************


	public function obtenerPantones($id_pantone, $dx){
		return DB::select('SELECT * FROM det_pantone WHERE id_dx = ? AND dx', [$id_pantone, $dx]);
	}

	public function obtenerAcabados($id_acabados , $dx){
		return DB::select('SELECT d.id as id_key, d.id_dx, d.dx, CAST(d.id_acabado as INT) as id, a.nombre
													FROM det_acabado d LEFT JOIN acabados a ON d.id_acabado = a.id
												WHERE d.id_dx = ? AND d.dx', [$id_acabados , $dx]);

	}


	public function ActualizaModif(Request $req){
		for($i=0;$i<count($req['data']);$i++):
			DB::update('UPDATE dx_modif SET accion=:accion, valor2=:valor2
															WHERE id =:id',['accion' => $req['data'][$i]['accion'] ,
																							'valor2' => $req['data'][$i]['valor2'] , 
																							'id' 		 => $req['data'][$i]['id']  ]);
		endfor;
		
		$this -> actualizaEstatusModif($req['id']);
		return response("la información se guardo correctamente",200);
	}

	public function actualizaEstatusModif($id){
		DB::update('UPDATE prod_modif SET estatus=:estatus WHERE id=:id',['estatus' => 2, 'id' => $id]);
	}

}


