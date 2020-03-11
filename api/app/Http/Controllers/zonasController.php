<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\zonas;


class zonasController extends Controller
{
    public function getAll()
    {
        $Zonas = zonas::all();
        return $Zonas;
    }

    
}
