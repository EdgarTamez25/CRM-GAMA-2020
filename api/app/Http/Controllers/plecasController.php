<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class plecasController extends Controller
{
    public function Plecas(){
        return DB::select('SELECT * FROM plecas WHERE estatus = 1');
    } 
}
