<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class compromisos extends Model
{
    protected $table = "compromisos";
    protected $fillable = array('id_vendedor',
                                'tipo_compromiso',
                                'fecha',
                                'hora',
                                'id_contacto',
                                'comentarios',
                                'id_cliente',
                                'fase_venta',
                                'estatus',
                                ); 
}
