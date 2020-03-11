<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ciudades;

class ciudadesController extends Controller
{
    public function getAll()
    {
        $Ciudades = ciudades::all();
        return $Ciudades;
    }
}
