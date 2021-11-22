<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\;

class departamentosController extends Controller
{
    public function Departamentos(){
        return DB::select('SELECT * FROM departamentos WHERE estatus = 1');
    }

    public function obtener_deptos_por_suc($id){
        $deptos = DB::select('SELECT d.*
																	FROM depto_por_suc d 
															WHERE d.id_sucursal = ?', [$id]);
				
				return $deptos ? $deptos : [];
    }
}
