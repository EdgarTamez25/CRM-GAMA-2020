<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    protected $table = "clientes";
    protected $fillable = array('nombre',
                                'direccion',
                                'id_ciudad',
                                'cp',
                                'id_zona',
                                'razon_social',
                                'fuente',
                                'tipo_cliente',
                                'rfc',
                                'nivel',
                                'id_cartera',
                                'tel1',
                                'ext1',
                                'tel2',
                                'ext2',
                                'contacto',
                                'contacto2',
                                'diasfact',
                                'estatus'
                                ); 
}
