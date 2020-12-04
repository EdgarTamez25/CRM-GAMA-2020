<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\productos;

class productosxcliController extends Controller
{
    public function productosxCli($id_cliente){
        $productosxCli = DB::select('SELECT * FROM prodxcli WHERE id_cliente = ?', [$id_cliente]);
        return $productosxCli ? response($productosxCli,200) : response([], 500); 
    }
}
