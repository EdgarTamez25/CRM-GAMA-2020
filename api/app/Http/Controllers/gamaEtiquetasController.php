<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class gamaEtiquetasController extends Controller
{
	public function modulosActivos(){
		$modulos = DB::select('SELECT * FROM pagina_arranque WHERE estatus = 1 ');

    return $modulos ? $modulos: $modulos =[];
	}
}
