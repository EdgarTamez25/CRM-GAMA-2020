<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class nivelController extends Controller
{
   public function obtenerNiveles(){
       return DB::select('SELECT * FROM niveles');
   }
}
