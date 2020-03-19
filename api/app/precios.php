<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class precios extends Model
{
    protected $table = "precios";
    protected $fillable = array('id_producto','id_proveedor', 'tipo_precio','iva','id_moneda','estatus' ); 
}
