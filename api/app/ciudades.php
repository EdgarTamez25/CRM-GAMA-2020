<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ciudades extends Model
{
    protected $table = "ciudades";
    protected $fillable = array('nombre', 'id_estado', 'estatus' ); 

}
