<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\;

class departamentosController extends Controller
{
    public function Departamentos(){
        return DB::select('SELECT * FROM departamentos WHERE estatus = 1');
    }
}
