<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //USAR ESCRITURA SQL


class materialesController extends Controller
{
    public function Materiales($dx){
    	return $materiales = DB::select('SELECT * FROM materiales WHERE dx=?',[$dx]);
    } 
}
