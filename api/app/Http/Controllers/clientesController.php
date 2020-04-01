<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\clientes;

class clientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function catClientes()
    {
        $data = DB::select('SELECT c.id , c.nombre, c.direccion, c.id_zona, z.nombre as nomzona, c.razon_social,
																	 c.fuente,c.tipo_cliente, c.rfc,c.id_cartera, c.nivel, ca.nombre as nomcartera
                            FROM clientes c LEFT JOIN zonas 		z ON c.id_zona = z.id
                                            LEFT JOIN carteras ca ON c.id_cartera = ca.id 
                            WHERE c.estatus = 1');
        return $data;
    }

    public function add(Request $request){
			$addcliente = clientes::create($request->all());
			
			if($addcliente):
				return "El Cliente se ah insertado correctamente";
			else:
				return "Ocurrio un problema al crear el cliente, por favor intentelo mas tarde.";
			endif;

    }

    public function update($id, Request $req){
				$data = DB::update('UPDATE clientes SET nombre=:nombre,
																								direccion=:direccion,
																								id_zona=:id_zona,
																								tipo_cliente=:tipo_cliente,
																								rfc=:rfc,
																								id_cartera=:id_cartera,
																								razon_social=:razon_social, 
																								nivel=:nivel,
																								fuente=:fuente 
															WHERE id=:id'
														,['nombre'				=> $req -> nombre, 
															'direccion'     => $req -> direccion,
															'id_zona'       => $req -> id_zona,
															'tipo_cliente'	=> $req	-> tipo_cliente, 
															'rfc'						=> $req	-> rfc,
															'id_cartera'		=> $req	-> id_cartera, 
															'razon_social'	=> $req	-> razon_social, 
															'nivel'					=> $req	-> nivel , 
															'fuente'				=> $req	-> fuente, 
															'id'						=> $id
														]
													);
				
				return 'El cliente se actualizo correctamente';
    }
    

}
