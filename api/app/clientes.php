<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    protected $table = "clientes";
    protected $fillable = array('nombre',
                                'id_subzona',
                                'estatus',
                                'razon_social',
                                'fuente',
                                'tipo_cliente',
                                'rfc',
                                'curp',
                                'nivel',
                                'id_cartera',
                                ); 
}
