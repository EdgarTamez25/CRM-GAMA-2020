<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class sistemasController extends Controller
{
    public function obtenerSistemas(){
        return DB::select('SELECT * FROM sistemas');
    }

    public function AccesosASistemas($id){
    	$accesos = DB::select('SELECT a.id, a.id_usuario, a.id_sistema, a.id_nivel, s.nombre as nomsistema, n.nombre as nomnivel 
    							FROM accesos a LEFT JOIN sistemas s ON a.id_sistema = s.id
    										   LEFT JOIN niveles  n ON a.id_nivel   = n.id
    						   WHERE a.id_usuario = ?',[$id]);
   		return $accesos ? $accesos : [];
    }

}
