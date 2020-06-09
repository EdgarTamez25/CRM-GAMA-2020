<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class compromisos extends Model
{
    protected $table = "compromisos";
    protected $fillable = array('id',
                                'id_vendedor',
                                'tipo_compromiso',
                                'fecha',
                                'hora',
                                'fecha_fin',
                                'hora_fin',
                                'id_contacto',
                                'comentarios',
                                'id_cliente',
                                'fase_venta',
                                'estatus',
                                ); 
}
