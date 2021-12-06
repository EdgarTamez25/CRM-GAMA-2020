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

// ! ************************************************************************

// **************** PRODUCTO TERMINADO **************************************
public function obtener_productos_terminados(Request $req){
  $productos_terminados = DB::select('SELECT pt.* ,
                                             p.codigo,
                                             u.nombre as unidad,
                                             s.nombre as nomsucursal
                                        FROM productos_terminados pt
                                          LEFT JOIN prodxcli p   ON pt.id_producto = p.id
                                          LEFT JOIN unidades u   ON p.id_unidad = u.id
                                          LEFT JOIN sucursales s ON pt.id_sucursal = s.id
                            WHERE pt.id_sucursal   = ?', [ $req -> id_sucursal ]);
    return $productos_terminados ? $productos_terminados: [];
}

// **************** DESCONTAR CANTIDAD DE EXISTENCIA **************************************

  public function descontar_cantidad_inventario($id, $cantidad_salida){
      $existencia  = $this -> obtener_existencia_producto($id, $cantidad_salida);
      if($existencia):
        $producto_terminado = DB::update('UPDATE productos_terminados
                                      SET cantidad=:cantidad
                                  WHERE id=:id',
              [
                  'cantidad' => $existencia,
                  'id' => $id
              ]);
        return $producto_terminado? true:false;
      else:
        return false;
      endif;
      
  }

  public function obtener_existencia_producto($id, $cantidad_salida ){
    $total = DB::select('SELECT cantidad FROM productos_terminados WHERE id=?', [$id]);
    if($total[0] -> cantidad > $cantidad_salida):
      $nueva_existencia = $total[0] -> cantidad - $cantidad_salida;
      return $nueva_existencia;
    else:
      return 0;
    endif;
  }





}
