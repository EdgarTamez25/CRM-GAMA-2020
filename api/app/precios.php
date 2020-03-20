<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class precios extends Model
{
    protected $table = "precios";
    protected $fillable = array('id_producto',
                                'id_proveedor', 
                                'tipo_precio',
                                'id_moneda',
																'estatus',
																'precio',
																'produccion',
																'pje_admin',
																'costo_admin',
                                'total',
                                'predeterminado'
                                ); 
}
