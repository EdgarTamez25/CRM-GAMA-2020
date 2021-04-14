<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proveedores extends Model
{
    protected $table = "proveedores";
    protected $fillable = array('nombre','id_zona','direccion','id_ciudad','cp','razon_social',
                                'tel1','ext1','tel2','ext1','contacto','contacto2','tipo_prov','rfc','estatus' );
}
