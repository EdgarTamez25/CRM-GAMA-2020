<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proveedores extends Model
{
    protected $table = "proveedores";
    protected $fillable = array('nombre','id_zona','estatus','razon_social','tipo_prov','rfc','direccion',
                                'tel1','tel2','contacto');
}
