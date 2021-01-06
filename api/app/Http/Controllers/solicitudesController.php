<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //USAR ESCRITURA SQL

class solicitudesController extends Controller
{
	// !CATALOGO DE SOLICITUDES
	public function Solicitudes(Request $req){
		$solicitud = DB::select('SELECT s.id, s.id_cliente, c.nombre as nomcli, s.id_usuario, u.nombre as nomusuario, 
																	  s.fecha, s.hora, s.nota 
															FROM	solicitudes s LEFT JOIN clientes c ON s.id_cliente = c.id
																									LEFT JOIN users u    ON s.id_usuario = u.id
															WHERE s.estatus = ? AND s.fecha BETWEEN ? AND ?
														 ORDER BY s.id DESC',[ $req -> estatus, $req -> fecha1, $req -> fecha2 ]);
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
	
	// ! CONSULTAR SOLICITUDES DESARROLLO/DIGITAL/DISEÑO
	public function SolicitudesDDD(Request $req){
		$movimientos = DB::select('SELECT m.id, m.id_solicitud, m.px, m.id_px, m.id_depto, m.fecha, m.hora, m.estatus,u.nombre as nomvend, 
																			c.nombre as nomcli, us.id as id_encargado, us.usuario as encargado, us.nombre as nomencargado
																FROM movim_sol m LEFT JOIN solicitudes s ON m.id_solicitud = s.id
																							   LEFT JOIN users u       ON s.id_usuario   = u.id 
																								 LEFT JOIN clientes c    ON s.id_cliente   = c.id
																								 LEFT JOIN users us      ON m.id_encargado = us.id
															WHERE m.estatus = ? AND m.id_depto = ? AND m.fecha BETWEEN ? AND ?', 
															[ $req -> estatus, $req -> id_depto , $req -> fecha1 , $req -> fecha2]);
		// return $movimientos;

		$movimSol = [];

		for($i=0;$i<count($movimientos);$i++ ):
			if($movimientos[$i] -> px === 1):
				$existente = $this -> consultaProdExistente($movimientos[$i] -> id_px);
				$arrayTemp = $this -> formarObjecto($existente, $movimientos[$i]);
				array_push($movimSol,  $arrayTemp);
			endif;
			if($movimientos[$i] -> px === 2):
				 $Modificacion = $this -> consultaProdModif($movimientos[$i] -> id_px);
				 $arrayTemp = $this -> formarObjecto($Modificacion, $movimientos[$i]);
				array_push($movimSol, $arrayTemp);
			endif;
			if($movimientos[$i] -> px === 3):
				$Nuevos = $this -> consultaProdNuevo($movimientos[$i] -> id_px);
				$arrayTemp = $this -> formarObjecto($Nuevos, $movimientos[$i]);
				array_push($movimSol, $arrayTemp);
			endif; 
		endfor;

		return $movimSol ? $movimSol: $movimSol = [];

	}

	public function ActualizaEncargado(Request $req){
		$actualizaEncargado = DB::update('UPDATE movim_sol SET id_encargado=:id_encargado
																				WHERE id =:id',['id_encargado' => $req  ->  id_encargado,
																												'id' 		 			 => $req  -> id ]);

		return $actualizaEncargado? response("la información se guardo correctamente",200): 
											          response("Ocurrio un error, intentelo de nuevo",500);
		
	}

	public function ProcesaMovimiento(Request $req){

		$procesaMovim = DB::update('UPDATE movim_sol SET responsable2=:responsable2, estatus=:estatus
																				WHERE id =:id',['responsable2' => $req  -> responsable2,
																												'estatus'      => $req  -> estatus,
																												'id' 		 			 => $req  -> id_key
																											 ]);
		
		$this -> validaEstatusMovim($req);
		$this -> validaEstatusSolicitud($req);																								 
		return $procesaMovim? response("la información se guardo correctamente",200): 
											    response("Ocurrio un error, intentelo de nuevo",500);
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
	//! FORMA OBJETO QUE SE MANDARA EN SolicitudesDDD
	public function formarObjecto($data, $movim){
		// return $data;
		return $objetTemp = [ "id_key"			 => $movim -> id, 
													"id_solicitud" => $movim -> id_solicitud,
													"px" 					 => $movim -> px,
													"id_px" 			 => $movim -> id_px,
													"id_depto"     => $movim -> id_depto,
													"fecha"        => $movim -> fecha,
													"hora"         => $movim -> hora,
													"estatus_key"  => $movim -> estatus,
													"nomvend"      => $movim -> nomvend,
													"nomcli"       => $movim -> nomcli,
													"id_encargado" => $movim -> id_encargado,
													"encargado"    => $movim -> encargado,
													"nomencargado" => $movim -> nomencargado,
													"id"       		 => $data[0] -> id,
													"ft" 					 => $data[0] -> ft,
													"dx"					 => $data[0] -> dx,
													"id_dx"        => $movim -> px === 3 ? $data[0] -> id_dx : 0 ,
													"tipo_prod"    => $data[0] -> tipo_prod,
													"cantidad"     => $data[0] -> cantidad,
													"estatus"		   => $data[0] -> estatus
												];
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
		return DB::select('SELECT * FROM det_pantone WHERE id_dx = ? AND dx=?', [$id_pantone, $dx]);
	}

	public function obtenerAcabados($id_acabados , $dx){
		return DB::select('SELECT d.id as id_key, d.id_dx, d.dx, CAST(d.id_acabado as INT) as id, a.nombre
													FROM det_acabado d LEFT JOIN acabados a ON d.id_acabado = a.id
												WHERE d.id_dx = ? AND d.dx = ?', [$id_acabados , $dx]);

	}

	public function ActualizaModif(Request $req){
		for($i=0;$i<count($req['data']);$i++):
			DB::update('UPDATE dx_modif SET accion=:accion, valor2=:valor2
															WHERE id =:id',['accion' => $req['data'][$i]['accion'] ,
																							'valor2' => $req['data'][$i]['valor2'] , 
																							'id' 		 => $req['data'][$i]['id']  ]);
		endfor;
		
		$this -> actualizaEstatusModif($req);
		return response("la información se guardo correctamente",200);
	}

	public function actualizaEstatusModif($data){
		DB::update('UPDATE prod_modif SET estatus=:estatus 
									WHERE id=:id',['estatus' => $data['estatus'], 
																 'id' 		 => $data['id'] ]);
	}

	public function actualizaEstatusProdExist($data){
		DB::update('UPDATE prod_exist SET estatus=:estatus 
									WHERE id=:id',['estatus' => $data['estatus'], 
																 'id' 		 => $data['id'] ]);
	}

	public function actualizaEstatusProdNuevo($data){
		DB::update('UPDATE prod_nuevo SET estatus=:estatus 
									WHERE id=:id',['estatus' => $data['estatus'], 
																 'id' 		 => $data['id'] ]);
	}

	//! ACTUALIZAR CARACTERISTICAS ***************************************************************************
	public function ActualizaProdNuevo(Request $req){
		// return $req;
		switch ($req["dx"]) {
			case 1:
				 $this -> actualizaFlexo($req);
				break;
			case 3:
				$this -> actualizaDigital($req);
				break;
		}

		DB::update('UPDATE prod_nuevo SET ft=:ft, cantidad=:cantidad
									WHERE id =:id',['ft' 			 => $req['referencia'] ,
																	'cantidad' => $req['cantidad'] , 
																	'id' 		   => $req['id']  ]);
	}

	public function actualizaFlexo($req){
		DB::update('UPDATE det_flexo SET id_material=:id_material, etqxrollo=:etqxrollo, med_nucleo=:med_nucleo, etqxpaso=:etqxpaso, 
																		  med_desarrollo=:med_desarrollo, med_eje=:med_eje,id_orientacion=:id_orientacion, 
																			ancho=:ancho, largo=:largo
									WHERE id=:id',	['id_material'   => $req['id_material'] ,
																	'etqxrollo'      => $req['etqxrollo'] , 
																	'med_nucleo'     => $req['med_nucleo'],
																	'etqxpaso'       => $req['etqxpaso'],
																	'med_desarrollo' => $req['med_desarrollo'],
																	'med_eje'        => $req['med_eje'],
																	'id_orientacion' => $req['id_orientacion'],
																	'ancho'          => $req['ancho'],
																	'largo'          => $req['largo'],
																	'id' 		         => $req['id_dx']  ]);

		$this -> eliminaAcabado($req['id_dx']);      //!ELIMINO TODOS LOS ACABADOS QUE PERTENESCAN AL id_dx
		$this -> eliminaPantone($req['id_dx']);			 //!ELIMINO TODOS LOS PANTONES QUE PERTENESCAN AL id_dx							
		$this -> ciclaAcabados($req['id_dx'], $req); //!GENERO CICLO PARA ACABADOS
		$this -> ciclaPantones($req['id_dx'], $req); //!GENERO CICLO PARA PANTONES

		return response("la información se guardo correctamente",200);
	}

	public function actualizaDigital($req){
		DB::update('UPDATE det_digital SET id_material=:id_material, det_sobre=:det_sobre, estructura=:estructura, grosor=:grosor, 
																			ancho=:ancho, largo=:largo
									WHERE id=:id',	['id_material'   => $req['id_material'] ,
																	'det_sobre'      => $req['id_material2'] , 
																	'estructura'     => $req['estructura'],
																	'grosor'         => $req['grosor'],
																	'ancho'          => $req['ancho'],
																	'largo'          => $req['largo'],
																	'id' 		         => $req['id_dx']  ]);

		$this -> eliminaAcabado($req['id_dx']);      //!ELIMINO TODOS LOS ACABADOS QUE PERTENESCAN AL id_dx
		$this -> eliminaPantone($req['id_dx']);			 //!ELIMINO TODOS LOS PANTONES QUE PERTENESCAN AL id_dx							
		$this -> ciclaAcabados($req['id_dx'], $req); //!GENERO CICLO PARA ACABADOS
		$this -> ciclaPantones($req['id_dx'], $req); //!GENERO CICLO PARA PANTONES

		return response("la información se guardo correctamente",200);
	}
	//! ******************************************************************************************************

	public function ciclaAcabados($id_dx, $detalle){
		for($i=0;$i<count($detalle['acabados']); $i++):  
			$this -> insertarAcabado($id_dx, $detalle['acabados'][$i]['id'], $detalle['dx']);
		endfor;
	}

	public function ciclaPantones($id_dx, $detalle){
		for($i=0;$i<count($detalle['pantones']); $i++):  
			$this -> insertarPantone($id_dx, $detalle['pantones'][$i], $detalle['dx']);
		endfor;
	}

	public function eliminaAcabado($id_dx){
		DB::delete('DELETE FROM det_acabado WHERE id_dx=?',[$id_dx]);
	}

	public function eliminaPantone($id_dx){
		DB::delete('DELETE FROM det_pantone WHERE id_dx=?',[$id_dx]);
	}

	public function insertarAcabado($id_dx, $id_acabado, $dx){ 
		$acabado = DB::table('det_acabado')->insertGetId(
				[
						'dx'				 => $dx,
						'id_acabado' => $id_acabado,
						'id_dx'      => $id_dx,
				]
		);
	}
	public function insertarPantone($id_dx, $pantone, $dx){ 
		$pantone = DB::table('det_pantone')->insertGetId(
				[
						'dx'				=> $dx,
						'pantone' 	=> $pantone,
						'id_dx'     => $id_dx,
				]
		);
	}

	public function MovimSol(Request $req){
		$movim = DB::select('SELECT * FROM movim_sol WHERE id_px =? AND px=? ORDER BY id DESC',[$req -> id_px, $req -> px]);
		return $movim ? $movim: $movim = [];
	}

	public function EnviarSol(Request $req){
		for($i=0;$i<count($req['deptos']); $i++):  
			DB::table('movim_sol')->insertGetId(
				[
						'id_solicitud' 	=> $req['id_solicitud'],
						'px'						=> $req['px'],
						'id_px'    		  => $req['id_px'],
						'id_depto'      => $req['deptos'][$i]['id'],
						'fecha'					=> $req['fecha'],
						'hora'					=> $req['hora'],
						'responsable'   => $req['id_usuario']
				]
			);
		endfor;
		

		if($req['px'] === 1): $this -> actualizaEstatusProdExist($req); endif;
		if($req['px'] === 2): $this -> actualizaEstatusModif($req)    ; endif;
		if($req['px'] === 3): $this -> actualizaEstatusProdNuevo($req); endif;
		
		$this -> validaEstatusSolicitud($req);
		return response("la información se guardo correctamente",200);

	}

	public function FinalizaProdExist(Request $req){
		$this -> actualizaEstatusProdExist($req);
	  $this -> validaEstatusSolicitud($req);
		return response("la información se guardo correctamente",200);
	}
 
	public function EliminarMovim(Request $req){
		$deleteMovim = DB::delete('DELETE FROM movim_sol WHERE id= ?',[$req -> id_delete]);

		if($req -> px === 1): $this -> actualizaEstatusProdExist($req); endif;
		if($req -> px === 2): $this -> actualizaEstatusModif($req)    ; endif;
		if($req -> px === 3): $this -> actualizaEstatusProdNuevo($req); endif;
		
		$this -> validaEstatusSolicitud($req);
		return response("la información se guardo correctamente",200);
	}

	public function validaEstatusMovim($data){
		$uno=0; $dos=0; $tres=0;
		$movim = DB::select('SELECT * FROM movim_sol WHERE id_solicitud =? AND id_px=? ', [$data -> id_solicitud, $data -> id]);
	
		for($i=0;$i<count($movim); $i++): 
			if($movim[$i] -> estatus === 1 ):
				$uno++;
			elseif($movim[$i] -> estatus === 2):
				$dos++;
			elseif($movim[$i] -> estatus === 3):
				$tres++;
			endif;
		endfor;
		
		if($uno > 0):
			$objetTemp = ["id" => $data -> id, "estatus" => 2];	$objetTemp2 = [ "data" => $objetTemp];
			if($data -> px === 1): $this -> actualizaEstatusProdExist($objetTemp2['data']); endif;
			if($data -> px === 2): $this -> actualizaEstatusModif($objetTemp2['data'])    ; endif;
			if($data -> px === 3): $this -> actualizaEstatusProdNuevo($objetTemp2['data']); endif;
		elseif($dos > 0):
			$objetTemp = ["id" => $data -> id, "estatus" => 2];	$objetTemp2 = [ "data" => $objetTemp];
			if($data -> px === 1): $this -> actualizaEstatusProdExist($objetTemp2['data']); endif;
			if($data -> px === 2): $this -> actualizaEstatusModif($objetTemp2['data'])    ; endif;
			if($data -> px === 3): $this -> actualizaEstatusProdNuevo($objetTemp2['data']); endif;
		elseif($tres > 0):
			$objetTemp = ["id" => $data -> id, "estatus" => 3];$objetTemp2 = [ "data" => $objetTemp];
			if($data -> px === 1): $this -> actualizaEstatusProdExist($objetTemp2['data']); endif;
			if($data -> px === 2): $this -> actualizaEstatusModif($objetTemp2['data'])    ; endif;
			if($data -> px === 3): $this -> actualizaEstatusProdNuevo($objetTemp2['data']); endif;
		endif;
	}

  // TODO ******************** FUNCIONES PARA VALIDAR ESTATUS DE SOLICITUD ***************************
	// TODO ********************************************************************************************
	public function	validaEstatusSolicitud($data){
		$cero=0;$uno=0;$dos=0; $tres=0; $cuatro=0;
	  $detalle = $this -> DetalleSolicitud($data['id_solicitud']);

		if(!$detalle): 
			$this -> actualizaEstatusSolicitud($data['id_solicitud'],1);
			return ;
		endif;

		for($i=0;$i<count($detalle); $i++): 
			if($detalle[$i] -> estatus === 0):
				$cero++;
			elseif($detalle[$i] -> estatus === 1):
				$uno++;
			elseif($detalle[$i] -> estatus === 2):
				$dos++;
			elseif($detalle[$i] -> estatus === 3):
				$tres++;
			elseif($detalle[$i] -> estatus === 4):
				$cuatro++;
			endif;
		endfor;
		
		if($cero > 0):
			$this -> actualizaEstatusSolicitud($data['id_solicitud'],1);
		elseif($uno > 0):
			$this -> actualizaEstatusSolicitud($data['id_solicitud'],1);
		elseif($dos > 0):
			 $this -> actualizaEstatusSolicitud($data['id_solicitud'],2);
		elseif($tres > 0):
			 $this -> actualizaEstatusSolicitud($data['id_solicitud'],3);
		elseif($cuatro > 0):
			 $this -> actualizaEstatusSolicitud($data['id_solicitud'],4);
		endif;

	}

	public function actualizaEstatusSolicitud($id_solicitud, $estatus){
		 DB::update('UPDATE solicitudes SET estatus=:estatus 
									WHERE id=:id',['estatus' => $estatus, 'id' => $id_solicitud]);
		
	}

}


