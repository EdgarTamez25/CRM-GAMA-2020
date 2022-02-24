<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //USAR ESCRITURA SQL
use App\prospectos;
use App\clientes;


class prospectosController extends Controller {

	public function Prospectos(){
		return $prospectos = DB::select('select c.id, c.fuente, u.nombre as nomvend, c.nombre, 
																						c.tipo_cliente, c.nivel, c.tel1, c.contacto
																			FROM  clientes c LEFT JOIN users u ON c.fuente = u.id
																			WHERE c.prospecto = 1');
	}

	public function addProspecto(Request $req){
		$addprospecto = DB::table('clientes')->insertGetId(   //! INSERTO PRODUCTO NUEVO
			[
					'fuente' 		    => $req -> fuente,
					'nombre' 			  => $req -> nombre,
					'tipo_cliente'	=> $req -> tipo_cliente,
					'nivel'      	  => $req -> nivel,
					'tel1'     	    => $req -> tel1,
					'contacto'      => $req -> contacto,
					'prospecto'    	=> $req -> prospecto,
					'estatus'    		=> $req -> estatus,
			]
		);

		return $addprospecto ? "El prospecto se ah insertado correctamente":
													 "Ocurrio un problema al crear el prospecto, por favor intentelo mas tarde.";
	}

	public function UpdateProspecto($id, Request $req){
		$data = DB::update('UPDATE clientes SET nombre=:nombre, tipo_cliente=:tipo_cliente,
																					 nivel=:nivel, tel1=:tel1,contacto=:contacto	
												WHERE id=:id'
											,['nombre'		=> $req -> nombre, 		'tipo_cliente'	=> $req	-> tipo_cliente, 
											  'nivel'			=> $req	-> nivel,  		'tel1'					=> $req -> tel1,
											  'contacto'	=> $req -> contacto, 	'id'						=> $id 
											]
										);
	
		return 'El prospecto se actualizo correctamente';
	}

	public function PasarACliente(Request $req){
		$Convertir = DB::update('UPDATE clientes SET prospecto=:prospecto 
															WHERE id=:id',['prospecto' => $req -> prospecto, 'id' => $req -> id]);
		return "El cliente se creo correctamente.";
	}

}
