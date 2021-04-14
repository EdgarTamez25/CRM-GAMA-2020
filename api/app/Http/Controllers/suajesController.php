<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class suajesController extends Controller
{
    public function Suajes(){
        return DB::select('SELECT * FROM suajes WHERE estatus = 1');
    }
}
