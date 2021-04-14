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
}
