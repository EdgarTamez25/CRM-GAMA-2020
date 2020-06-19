<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Prueba;

class pruebasController extends Controller
{
    public function get( Request $req){
        // return Prueba::first(); // TE TRAE EL PRIMER REGISTRO DE LA BD
        // return Prueba::all(); // TE TRAE TODOS LOS REGISTROS DE LA BD
        // return Prueba::where('nivel', 3)->first(); // TE TRAE EL PRIMER ELEMENTO POR CONDICION
        // return Prueba::find(3);// TE TRAE EL ID QUE SOLICITES
        // return Prueba::all(); // CONSULTAR TODOS LOS REGISTROS DE LA TABLA
        // return Prueba::where(['nivel' => 3, 'id_sucursal' => 2])->get(); // CONSULTA POR CONDICION
        
        return Prueba::create([
            'nombre'      =>  $req -> nombre,
            'password'    =>  bcrypt($req -> password),
            'correo'      => $req -> correo,
            'nivel'       =>  $req -> nivel,
            'id_sucursal' => $req -> id_sucursal,
            'foto'        => 'foto.png',
            'estatus'     => 1
        ]);

    }

    public function getId($id){
        
    }

    public function post(Request $req){
        return Prueba::create([
            'nombre'      =>  $req -> nombre,
            'password'    =>  bcrypt($req -> password),
            'correo'      => $req -> correo,
            'nivel'       =>  $req -> nivel,
            'id_sucursal' => $req -> id_sucursal,
            'foto'        => 'foto.png',
            'estatus'     => 1
        ]);


    }

    public function put($id, Resquest $req){
        
    }
}
