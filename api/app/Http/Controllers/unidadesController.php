<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\unidades;

class unidadesController extends Controller
{
    public function obtenerUnidades()
    {
				return DB::select('SELECT * FROM unidades WHERE estatus = 1');
    }

    public function agregarUnidades(Request $req)
    {
        $agregar = DB::table('unidades')->insertGetId(
            [
                'nombre' => $req->nombre,
                'estatus' => $req->estatus
            ]
        );
        return $agregar ? response("La Unidad se ah insertado correctamente", 200) :
            response("Ocurrio un problema al crear la unidad, por favor intentelo mas tarde.", 500);
    }

    public function actualizarUnidades($id, Request $req)
    {
        $actualizar = DB::update('UPDATE unidades SET nombre=:nombre, estatus=:estatus
                                            WHERE id =:id',
            [
                'nombre' => $req->nombre,
                'estatus' => $req->estatus,
                'id' => $id
            ]);
        return $actualizar ? response("La Unidad se ah actualizado correctamente", 200) :
            response("Ocurrio un problema al actualizar la unidad, por favor intentelo mas tarde.", 500);
    }
}
