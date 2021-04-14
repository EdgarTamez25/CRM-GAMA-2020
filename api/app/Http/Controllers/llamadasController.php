<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// use App\User;

class llamadasController extends Controller{		

	public function addLLamada(Request $req){
		$addllamada = DB::insert('INSERT INTO llamadas (nombre,dedonde,telefono,correo,motivo,fecha,hora,id_sucursal )
												VALUES(?,?,?,?,?,?,?,?)',[  $req -> nombre , $req -> dedonde , $req -> telefono  , $req -> correo,			 
	                                              		$req -> motivo , $req -> fecha   , $req -> hora      , $req -> id_sucursal	 
	                                          		 ]);
		return $addllamada ? "La llamada se agrego correctamente.": $addllamada =[];
	}
	
	public function putLLamadas($id, Request $req){
    $putllamada = DB::update('UPDATE llamadas SET nombre=:nombre, dedonde=:dedonde, telefono=:telefono, 
    																							correo=:correo,motivo=:motivo WHERE id=:id',
                              [ 'nombre'	=> $req -> nombre  ,  'dedonde'	=> $req -> dedonde,
                                'telefono'=> $req -> telefono,  'correo'  => $req -> correo,
                                'motivo'  => $req -> motivo  ,  'id'      => $id	
                              ]
												);
    return $putllamada ? "La llamada se actualizo correctamente": $putllamada =[];
	} 

	public function llamadas(Request $req){
		$llamadas = DB::select('SELECT * FROM llamadas 
															WHERE id_sucursal = ? AND fecha between ? AND ? 
														ORDER BY id DESC',[$req -> id_sucursal, $req -> fecha1, $req -> fecha2]);
    return $llamadas ? $llamadas: $llamadas =[];
	}

  
}
