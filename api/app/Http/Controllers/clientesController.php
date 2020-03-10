<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\clientesModel;

class clientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data = DB::select('SELECT c.nombre, c.id_subzona, z.nombre as nomsubzona ,c.razon_social,c.fuente,c.tipo_cliente,c.rfc,c.curp,
                            c.id_cartera, ca.nombre as nomcartera
                            FROM clientes c LEFT JOIN subzonas z ON c.id_subzona = z.id
                                            LEFT JOIN carteras ca ON c.id_cartera = ca.id 
                            WHERE c.estatus = 1 ');
        return $data;
    }
    

}
