<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class prospectos extends Model
{
    protected $table = "clientes";
    protected $fillable = array('fuente',
                                'nombre',
                                'tipo_cliente',
                                'nivel',
                                'tel1',
                                'contacto',
                                'prospecto',
                                'estatus'
,                                ); 
}
