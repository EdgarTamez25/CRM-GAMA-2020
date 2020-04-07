<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\monedas;

class monedasController extends Controller
{
    public function getAll()
    {
        $Monedas = monedas::all();
        return $Monedas;
		}

		public function add(Request $request){
			$addmoneda = monedas::create($request->all());
			
			if($addmoneda):
				return "La Moneda se ah insertado correctamente";
			else:
				return "Ocurrio un problema al crear la Moneda, por favor intentelo mas tarde.";
			endif;

		}
		
		public function update($id, Request $req){
			$data = DB::update('UPDATE monedas SET codigo=:codigo,nombre=:nombre, tipo_cambio=:tipo_cambio, estatus=:estatus 
														WHERE id =:id',
													['codigo'=>$req ->codigo ,'nombre'=> $req -> nombre,'estatus'=> $req -> estatus, 'id'=> $id	]
												);
			
			return 'La Moneda se actualizo correctamente';
	}

	public function predeterminado($id){
		//BUSCO TODOS LOS PRECIOS POR EL ARTICULO A ACTUALIZAR
		
		$cambioAUno = DB::update('UPDATE monedas SET predeterminado= 1  WHERE id =:id', ['id'=>$id]);

		$cambioAcero = DB::update('UPDATE monedas SET predeterminado= 0  WHERE id !=:id', ['id' => $id]);

		return "La moneda predeterminada se actualizo correctamente.";
		
	}

	public function getPredeterminada(){
		$predeterminad = DB::select('SELECT * FROM monedas WHERE predeterminado = 1');
		return $predeterminad;
	}

}
