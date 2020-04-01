<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    protected $table = "clientes";
    protected $fillable = array('nombre',
                                'direccion',
                                'id_zona',
                                'estatus',
                                'razon_social',
                                'fuente',
                                'tipo_cliente',
                                'rfc',
                                'nivel',
                                'id_cartera',
                                ); 
}
