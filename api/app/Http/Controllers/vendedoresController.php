<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Vendedores;

class vendedoresController extends Controller
{

		public function vendedores(){
			$vendedores = DB::select('SELECT u.id, u.nombre, u.correo, u.id_sucursal , s.nombre as nomsuc 
																	FROM users u LEFT JOIN sucursales s ON u.id_sucursal = s.id
																WHERE u.nivel = 3');
			return $vendedores;
		}

    public function vendxSuc($suc) {
        $vendbySuc = DB::select('SELECT u.id, u.nombre, u.correo, u.id_sucursal , s.nombre as nomsuc 
																			FROM users u LEFT JOIN sucursales s ON u.id_sucursal = s.id
																	WHERE u.id_sucursal = ? AND u.nivel = 3',[$suc] );
        return $vendbySuc;
    }
}
