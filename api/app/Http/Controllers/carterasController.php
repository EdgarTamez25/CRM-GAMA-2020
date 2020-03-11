<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\carteras;

class carterasController extends Controller
{
    public function getAll()
    {
        $Carteras = carteras::all();
        return $Carteras;
    }

    
}
