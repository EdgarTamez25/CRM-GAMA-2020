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

    public function index()
    {
        $data = DB::select('SELECT c.id , c.nombre, c.id_subzona, sz.nombre as nomsubzona ,z.id as idzona, z.nombre as nomzona ,
                                   c.razon_social,c.fuente,c.tipo_cliente, c.rfc,c.curp,c.id_cartera, c.nivel, ca.nombre as nomcartera
                            FROM clientes c LEFT JOIN subzonas sz ON c.id_subzona = sz.id
                                            LEFT JOIN zonas z     ON sz.id        = z.id
                                            LEFT JOIN carteras ca ON c.id_cartera = ca.id 
                            WHERE c.estatus = 1 ');
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
				$data = DB::update('UPDATE clientes SET nombre=:nombre,id_subzona=:id_subzona,tipo_cliente=:tipo_cliente,rfc=:rfc,curp=:curp, id_cartera=:id_cartera,
																								razon_social=:razon_social, nivel=:nivel,fuente=:fuente WHERE id =:id'
														,['nombre'=> $req -> nombre, 'id_subzona'=> $req -> id_subzona ,'tipo_cliente'=> $req->tipo_cliente, 'rfc'=>$req->rfc,'curp'=> $req->curp, 
															'id_cartera'=> $req->id_cartera, 'razon_social'=>$req->razon_social, 'nivel'=> $req->nivel , 'fuente'=>$req->fuente, 'id'=> $id
														]
													);
				
				return 'El cliente se actualizo correctamente';
    }
    

}
