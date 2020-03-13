<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proveedores extends Model
{
    protected $table = "proveedores";
    protected $fillable = array('nombre','id_subzona','estatus','razon_social','tiopo_prov','rfc','curp','id_precio');
}
