<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class produccionController extends Controller
{
    //
    public function obtenerProduccion()
    {
        $produccion = DB::select('SELECT * FROM produccion WHERE estatus = 1');
        return $produccion;
    }

    public function ciclaProgramacion(Request $req)
    {
        if ($agregarProd->tipo_prog === 1):
            // !    EL REQUEST CONTIENE EL EL TIPO_PROG PARA EVALUAR SI ES NECESARIO CICLAR EL OBJETO "req -> programacion"
            for ($i = 0; $i < count($req->$programacion); $i++):
                $this->agregarProgramacion($programacion, $id);
                return ($id_produccion);
            endfor;

            $this->agregar_primer_registro();
            return $actualizar ? response("La Unidad se ah actualizado correctamente", 200) :
                response("Ocurrio un problema al actualizar la unidad, por favor intentelo mas tarde.", 500);
        else:
            $this->agregarProgramacion();
        endif;
    }

    public function agregarProduccion(Request $req)
    {
        // !    EL REQUEST CONTIENE UN ARRAY DE OBJETOS LLAMADO PROGRAMACION "$req -> programacion"
        // ! 1. CREO EL REGISTRO PARA LA PRODUCCION
        $agregarProd = DB::table('produccion')->insertGetId(
            [
                'id_det_ot' => $req->id_det_ot,             //! 2 RECUPERO id_det_ot del request
                'id_producto' => $req->id_producto,         //! 2 RECUPERO id_producto del request
                'cant_sol' => $req->cant_sol,               //! 2 RECUPERO cant_sol del request
                'urgencia' => $req->urgencia,               //! 2 RECUPERO urgencia del request
                'total' => total,
                'fecha_entrega' => $req->fecha_entrega,     //! 2 RECUPERO fecha_entrega del request
                'id_creador' => $req->id_creador,           //! 2 RECUPERO id_creador del request
                'creacion' => $req->creacion,               //! 2 RECUPERO creacion del request
                'finalizacion' => finalizacion,
                'tipo_prog' => $req->tipo_prog,             //! 2 RECUPERO tipo
                'estatus' => $req->estatus
            ]
        );
        $programacion = $req->programacion;                 //! 2 RECUPERO objeto programacion

        return $agregarProd ? response("Se creó el registro de producción correctamente", 200) :  //! RETORNO id_produccion
            response("Ocurrió un problema al crear el registro de producción, por favor intentelo más tarde.", 500);
    }

    // public function actualizarProduccion($id, Request $req)
    // {
    //     $actualizar = DB::update('UPDATE produccion
    //                                 SET
    //                                         id_det_ot=:id_det_ot,       id_producto=:id_producto,
    //                                         cant_sol=:cant_sol,         urgencia=:urgencia,
    //                                         total=:total,               fentrega=:fentrega,
    //                                         id_creador=:id_creador,     creacion=:creacion,
    //                                         finalizacion=:finalizacion, tipo_prog=:tipo_prog,
    //                                         estatus=:estatus
    //                                 WHERE id=:id',
    //         [
    //             'id_det_ot' => $req->id_det_ot,
    //             'id_producto' => $req->id_producto,
    //             'cant_sol' => $req->cant_sol,
    //             'urgencia' => $req->urgencia,
    //             'total' => $req->total,
    //             'fentrega' => $req->fentrega,
    //             'id_creador' => $req->id_creador,
    //             'creacion' => $req->creacion,
    //             'finalizacion' => $req->finalizacion,
    //             'tipo_prog' => $req->tipo_prog,
    //             'estatus' => $req->estatus,
    //             'id' => $req->id
    //         ]);
    //     if ($actualizar):
    //         return response("Se actualizó el registro de producción correctamente", 200);
    //     else:
    //         return response("Ocurrió un problema al actualizar el registro de producción, por favor intentelo más tarde.", 500);
    //     endif;
    // }


    //      $id_det_ot = $req->id_det_ot;              // !2. RECUPERAR ID_DET_OT
    //      $id_producto = $req->id_producto;          // !2. RECUPERAR ID_PRODUCTO
    //      $cant_sol = $req->cant_sol;                // !2. RECUPERAR CANT_SOL
    //      $urgencia = $req->urgencia;                // !2. RECUPERAR URGENCIA
    //      $fentrega = $req->fentrega;                // !2. RECUPERAR FENTREGA
    //      $id_creador = $req->id_creador;            // !2. RECUPERAR ID_CREADOR
    //      $creacion = $req->creacion;                // !2. RECUPERAR CREACION
    //      $tipo_prog = $req->tipo_prog;              // !2. RECUPERAR TIPO_PROG
    //      $programacion = $req->programacion;        // !2. RECUPERAR PARCIALIDAD

    public function agregarPrimerMov(Request $req)
    {
        $agregar = DB::table('movim_prod')->insertGetId(
            [
                'id_produccion' => $req->id_produccion,
                'id_depto' => $req->id_depto,
                'id_sucursal' => $req->id_sucursal,
                'id_producto' => $req->id_producto,
                'cant_sol' => $req->cant_sol,
                'recibidas' => $req->recibidas,
                'terminadas' => $req->terminadas,
                'creacion' => $req->creacion,
                'estatus_prod' => $req->estatus_prod,
                'estatus' => $req->estatus
            ]
        );
        if ($agregar):
            return response("Se creo el registro de produccion correctamente", 200);
        else:
            return response("Ocurrio un problema al crear el registro de produccion, por favor intentelo mas tarde.", 500);
        endif;
    }

    public function obtenerMovimProd()
    {
        $produccion = DB::select('SELECT * FROM movim_prod WHERE estatus = 1');
        return $produccion;
    }

    public function agregarMovimProd(Request $req)
    {
        $agregar = DB::table('movim_prod')->insertGetId(
            [
                'id_produccion' => $req->id_produccion,
                'id_depto' => $req->id_depto,
                'id_sucursal' => $req->id_sucursal,
                'id_producto' => $req->id_producto,
                'cant_sol' => $req->cant_sol,
                'recibidas' => $req->recibidas,
                'terminadas' => $req->terminadas,
                'creacion' => $req->creacion,
                'estatus_prod' => $req->estatus_prod,
                'estatus' => $req->estatus
            ]
        );
        if ($agregar):
            return response("Se creo el registro de produccion correctamente", 200);
        else:
            return response("Ocurrio un problema al crear el registro de produccion, por favor intentelo mas tarde.", 500);
        endif;
    }

    public function actualizarMovimProd($id, Request $req)
    {
        $actualizar = DB::update('UPDATE movim_prod
                                    SET
                                            id_produccion=:id_produccion,       id_depto=:id_depto,
                                            id_sucursal=:id_sucursal,           id_producto=:id_producto,
                                            cant_sol=:cant_sol,                 recibidas=:recibidas,
                                            terminadas=:terminadas,             creacion=:creacion,
                                            estatus_prod=:estatus_prod,         estatus=:estatus
                                    WHERE   id=:id',
            [
                'id_produccion' => $req->id_produccion,
                'id_depto' => $req->id_depto,
                'id_sucursal' => $req->id_sucursal,
                'id_producto' => $req->id_producto,
                'cant_sol' => $req->cant_sol,
                'recibidas' => $req->recibidas,
                'terminadas' => $req->terminadas,
                'creacion' => $req->creacion,
                'estatus_prod' => $req->estatus_prod,
                'estatus' => $req->estatus,
                'id' => $req->id
            ]);
        if ($actualizar):
            return response("Se actualizo el registro de movimiento de produccion correctamente", 200);
        else:
            return response("Ocurrio un problema al actualizar el registro de movimiento de produccion, por favor intentelo mas tarde.", 500);
        endif;
    }
}
