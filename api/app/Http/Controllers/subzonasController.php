<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\subzonas;

class subzonasController extends Controller
{

    public function SubzonaxZona($id )
    {
        $subZona = DB::select('SELECT * FROM subzonas WHERE id_zona = ? ',[$id]);
        return $subZona;
    }

}
