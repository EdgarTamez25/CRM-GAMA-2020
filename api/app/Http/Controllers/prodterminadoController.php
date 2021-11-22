<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class prodterminadoController extends Controller
{
  
// **************** PRODUCTO TERMINADO **************************************
  public function agregar_producto_terminado(Request $req){
    $id_producto_terminado = DB::table('productos_terminados')->insertGetId(
      [
        'id_ot'					=> $req -> id_ot,
        'id_produccion' => $req -> id_produccion,
        'id_sucursal'   => $req -> id_sucursal, 
        'id_producto'   => $req -> id_producto,         
        'cantidad'      => $req -> cantidad,
        'id_depto_envia'=> $req -> id_depto_envia,
        'id_creador'    => $req -> id_creador
      ]
    );

    $this -> actualiza_movim_anterior($req -> id_movim, $req -> cantidad);
    return $id_producto_terminado? response("El producto se ha envíado correctamente.",200):
                                  response("Ocurrio un error, intentelo nuevamente.",500);
  }

  public function actualiza_movim_anterior($id, $terminadas){
    $actualizar = DB::update('UPDATE movim_prod SET terminadas=:terminadas + terminadas WHERE id=:id',
          [
              'terminadas' => $terminadas,
              'id' => $id
          ]);
  }
// ! ************************************************************************

// **************** PRODUCTO TERMINADO **************************************
public function obtener_productos_terminados(Request $req){
  $productos_terminados = DB::select('SELECT pt.*,
                                   ot.id_cliente, ot.oc,
                                   c.nombre as nomcli,
                                   s.nombre as nomsucursal,
                                   p.codigo , p.id_unidad,
                                   un.nombre as unidad
                              FROM productos_terminados pt 
                                LEFT JOIN ot           ON pt.id_ot = ot.id
                                LEFT JOIN clientes c   ON ot.id_cliente = c.id
                                LEFT JOIN sucursales s ON pt.id_sucursal = s.id
                                LEFT JOIN prodxcli p   ON pt.id_producto = p.id
                                LEFT JOIN unidades un  ON p.id_unidad = un.id
                            WHERE pt.id_sucursal   = ? AND
                                  pt.estatus = ?',
                                  [
                                      $req -> id_sucursal,
                                      $req -> estatus,
                                  ]);
    return $productos_terminados ? $productos_terminados: [];
  }


}
