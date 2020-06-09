<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    protected $table = "clientes";
    protected $fillable = array('nombre',
                                'direccion',
                                'id_zona',
                                'razon_social',
                                'fuente',
                                'tipo_cliente',
                                'rfc',
                                'nivel',
                                'id_cartera',
                                'tel1',
                                'tel2',
                                'contacto',
                                'diasfact',
                                'estatus',
                                ); 
}
