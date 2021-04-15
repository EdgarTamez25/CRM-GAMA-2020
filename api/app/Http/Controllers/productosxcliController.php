<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\productos;

class productosxcliController extends Controller
{
    public function productosxCli($id_cliente){
        $productosxCli = DB::select('SELECT p.id, p.id_cliente, c.nombre as nomcli, p.nombre, p.codigo, p.descripcion,
																						p.revision, p.fecha, p.url, p.dx, p.id_dx, p.estatus 
																		 	FROM prodxcli p LEFT JOIN clientes c ON p.id_cliente = c.id 
																		 WHERE id_cliente = ?', [$id_cliente]);
        return $productosxCli ? response($productosxCli,200) : response([], 500); 
		}
		
		public function PxCxD(Request $req){
			$productosxCli = DB::select('SELECT p.id, p.nombre, p.codigo, p.descripcion,p.estatus FROM prodxcli p 
																	 WHERE dx = ? AND id_cliente = ?', [$req -> id_depto , $req -> id_cliente]);
			return $productosxCli ? response($productosxCli,200) : response([], 500); 
	}

		

		//  TODO EL PROCESO PARA CREAR PRODUCTO  *************** INICIO
		public function crearDetalle(Request $req){
			if($req -> dx === 1 ):
				if($id_dx = $this->Flexografia($req -> detalle )):	// !MANDO A INSERTAR A FLEXOGRAFIA
						// return $id_dx;
					$this -> creaProducto($req, $id_dx);
					return response("El producto se creo correctamente" ,200);// !SI SE INSERTO CORRECTAMENTE RETORNO RESPUESTA
				endif; 
			endif;

			if($req -> dx === 3 ):
				if($id_dx = $this->Digital($req -> detalle )):      // !MANDO A INSERTAR A DIGITAL
					$this -> creaProducto($req,$id_dx);
					return response("El producto se creo correctamente" ,200);// !SI SE INSERTO CORRECTAMENTE RETORNO RESPUESTA
				endif;
			endif;
		}

		public function creaProducto($data , $id_dx){
			$creaProducto = DB::table('prodxcli')->insertGetId(
													[
														'id_cliente' 	=> $data -> id_cliente ,
														'nombre'			=> $data -> nombre ,
														'codigo'			=> $data -> codigo ,
														'descripcion' => $data -> descripcion ,
														'revision'	  => $data -> revision ,
														'fecha'	  		=> $data -> fecha ,
														'url'				  => $data -> url ,
														'dx'				  => $data -> dx ,
														'id_dx'    		=> $id_dx,
														// 'estatus'     => $data -> estatus
													]
											);
		}

		public function Flexografia($detalle){
			$id_flexo = DB::table('det_flexo')->insertGetId(   //! INSERTO PRODUCTO NUEVO
										[
												'id_material' 		=> $detalle['id_material'],
												'etqxrollo' 			=> $detalle['etqxrollo'],
												'med_nucleo'  		=> $detalle['med_nucleo'],
												'etqxpaso'		 		=> $detalle['etqxpaso'],
												'med_desarrollo'  => $detalle['med_desarrollo'],
												'med_eje'    			=> $detalle['med_eje'],
												'id_orientacion'  => $detalle['id_orientacion'],
												'ancho'    				=> $detalle['ancho'],
												'largo'    				=> $detalle['largo']
										]
									);
			 
			$this -> actualizaValoresMultiplesFlexo($id_flexo); //! MANDO ACTUALIZAR DETALLES DE LA CARACTERISTICAS PARA CONSERVAR EL MISMO ID
			$this -> ciclaAcabados($id_flexo, $detalle); //!GENERO CICLO PARA INSERTAR ACABADOS
			$this -> ciclaPantones($id_flexo, $detalle); //!GENERO CICLO PARA INSERTAR PANTONES
			return $id_flexo;
		}

		public function Digital($detalle){
			$id_digital = DB::table('det_digital')->insertGetId(   //! INSERTO PRODUCTO NUEVO
											[
													'id_material' 		=> $detalle["id_material"],
													'det_sobre' 			=> $detalle["id_material2"],
													'estructura'		 	=> $detalle["estructura"],
													'grosor'  				=> $detalle["grosor"],
													'ancho'    				=> $detalle["ancho"],
													'largo'    				=> $detalle["largo"],
											]
										);
			$this -> actualizaValoresMultiplesDigital($id_digital); //! MANDO ACTUALIZAR DETALLES DE LA CARACTERISTICAS PARA CONSERVAR EL MISMO ID
			$this -> ciclaAcabados($id_digital, $detalle); //!GENERO CICLO PARA INSERTAR ACABADOS
			$this -> ciclaPantones($id_digital, $detalle); //!GENERO CICLO PARA INSERTAR PANTONES
			return $id_digital;
		}
		//  TODO EL PROCESO PARA CREAR PRODUCTO **************** FIN
		
		// TODO EL PROCESO PARA ACUTALIZAR PRODUCTO ************ INICIO
		public function actualizaProducto($id, Request $req){
			$producto = DB::update('UPDATE prodxcli SET id_cliente=:id_cliente,nombre=:nombre, codigo=:codigo, descripcion=:descripcion,
																									revision=:revision,fecha=:fecha,url=:url
																WHERE id=:id', ['id_cliente'  => $req -> id_cliente,
																								'nombre' 		  => $req -> nombre,
																								'codigo' 		  => $req -> codigo,
																								'descripcion' => $req -> descripcion,
																								'revision' 		=> $req -> revision,
																								'fecha' 		  => $req -> fecha,
																								'url' 		    => $req -> url,
																								'id' 				  => $id	]);
			
			if($req -> dx === 1 ):
				$this -> actualizaFlexo( $req -> detalle);
				$this -> eliminaPantones($req -> detalle['pantonesAEliminar']);
				$this -> eliminaAcabados($req -> detalle['acabadosAEliminar']);
				$this -> ciclaPantones(  $req -> detalle['id'], $req -> detalle);
				$this -> ciclaAcabados(  $req -> detalle['id'], $req -> detalle);
				return response("El producto se creo correctamente" ,200);
			endif;

			if($req -> dx === 3 ):
				$this -> ActualizaDigital( $req -> detalle);
				$this -> eliminaPantones($req -> detalle['pantonesAEliminar']);
				$this -> eliminaAcabados($req -> detalle['acabadosAEliminar']);
				$this -> ciclaPantones(  $req -> detalle['id'], $req -> detalle);
				$this -> ciclaAcabados(  $req -> detalle['id'], $req -> detalle);
				return response("El producto se creo correctamente" ,200);
			endif;
		}
		
		public function actualizaFlexo($detalle){
			$producto = DB::update('UPDATE det_flexo SET id_material=:id_material,det_acabados=:det_acabados, etqxrollo=:etqxrollo, etqxpaso=:etqxpaso,
																									 med_nucleo=:med_nucleo,med_desarrollo=:med_desarrollo,med_eje=:med_eje,id_orientacion=:id_orientacion,
																									 ancho=:ancho,largo=:largo, det_pantones=:det_pantones
																WHERE id=:id', ['id_material'  		=> $detalle['id_material'],
																								'det_acabados' 		=> $detalle['id'],
																								'etqxrollo' 		  => $detalle['etqxrollo'],
																								'etqxpaso' 				=> $detalle['etqxpaso'],
																								'med_nucleo' 		  => $detalle['med_nucleo'],
																								'med_desarrollo' 	=> $detalle['med_desarrollo'],
																								'med_eje' 		    => $detalle['med_eje'],
																								'id_orientacion' 	=> $detalle['id_orientacion'],
																								'ancho' 		    	=> $detalle['ancho'],
																								'largo' 		    	=> $detalle['largo'],
																								'det_pantones' 		=> $detalle['id'],
																								'id' 				  	  => $detalle['id']
																							]);
		}
		
		public function ActualizaDigital($detalle){
			$producto = DB::update('UPDATE det_digital SET id_material=:id_material, det_sobre=:det_sobre, estructura=:estructura,grosor=:grosor,
																									   ancho=:ancho,largo=:largo, det_pantones=:det_pantones, det_acabados=:det_acabados
																WHERE id=:id', ['id_material'  		=> $detalle ['id_material'],
																								'det_sobre' 		  => $detalle ['id_material2'],
																								'estructura' 			=> $detalle ['estructura'],
																								'grosor' 					=> $detalle ['grosor'],
																								'ancho' 		    	=> $detalle ['ancho'],
																								'largo' 		    	=> $detalle ['largo'],
																								'det_pantones' 		=> $detalle ['id'],
																								'det_acabados' 		=> $detalle ['id'],
																								'id' 				  	  => $detalle ['id']
																							 ]);
		}
		// TODO EL PROCESO PARA ACTUALIZAR PRODUCTO *********** FIN

		// !FUNCIONES PARA INSERTAR VALORES MULTIPLES ****** INICIO
		public function actualizaValoresMultiplesFlexo($id_flexo){
			DB::update('UPDATE det_flexo SET det_acabados=:det_acabados,det_pantones=:det_pantones
			WHERE id=:id', ['det_acabados' => $id_flexo,'det_pantones' => $id_flexo,'id' => $id_flexo	]);
		}
		public function actualizaValoresMultiplesDigital($id_digital){
			DB::update('UPDATE det_digital SET det_acabados=:det_acabados,det_pantones=:det_pantones
			WHERE id=:id', ['det_acabados' => $id_digital,'det_pantones' => $id_digital,'id' => $id_digital	]);
		}
		public function ciclaAcabados($id_dx, $detalle){
			// return $detalle;
			for($i=0;$i<count($detalle['acabados']); $i++):  
				$this -> insertarAcabado($id_dx, $detalle['acabados'][$i]['id'], $detalle['dx'] );
			endfor;
		}
		public function ciclaPantones($id_dx, $detalle){
			for($i=0;$i<count($detalle['pantones'] ); $i++):  
				$this -> insertarPantone($id_dx, $detalle['pantones'][$i], $detalle['dx']);
			endfor;
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
		public function eliminaPantones($pantones){
			for($i=0;$i<count($pantones); $i++):  
				DB::delete('DELETE FROM det_pantone WHERE id = ?', [ $pantones[$i]['id']]);
			endfor;
			
		}
		public function eliminaAcabados($acabados){
			for($i=0;$i<count($acabados); $i++):  
				DB::delete('DELETE FROM det_acabado	 WHERE id = ?', [ $acabados[$i]['id_key']]);
			endfor;
		}
		// !FUNCIONES PARA INSERTAR VALORES MULTIPLES ****** FIN

}
