<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\categorias;

class categoriasController extends Controller
{
    public function categorias(){
        $categorias = DB::select('SELECT * FROM categorias');
        return $categorias;
    }
}
