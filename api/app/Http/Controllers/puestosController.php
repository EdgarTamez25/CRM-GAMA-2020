<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\;

class puestosController extends Controller
{
    public function Puestos(){
        return DB::select('SELECT * FROM puestos WHERE estatus = 1');
    }


    public function obtener_puestos_por_depto($id){
        $puestos = DB::select('SELECT * FROM puesto_por_depto 
                                WHERE id_depto = ? AND estatus = 1', [$id]);
        
        return $puestos? $puestos:[];
    }
}
