<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //USAR ESCRITURA SQL


class acabadosController extends Controller
{
    public function Acabados($dx){
    	return $acabados = DB::select('SELECT * FROM acabados WHERE dx=?',[$dx]);
    } 
}
