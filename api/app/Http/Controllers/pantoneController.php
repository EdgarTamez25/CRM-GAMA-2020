<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pantoneController extends Controller
{
    public function obtenerPantone(){
        return DB::select('SELECT * FROM pantones WHERE estatus = 1');
    }

    public function agregarPantone(Request $req){
        $Tintas = DB::table('pantones')->insertGetId(
                [
                    'nombre' 		=> $req -> nombre,
                    'dx' 			=> $req -> dx,
                    'estatus'  		=> $req -> estatus,
                ]
        );
        return $Tintas ? response("Agregado Correctamente",200):
                         response("Ocurrio un error por favor intentelo de nuevo", 500);
    }
}
