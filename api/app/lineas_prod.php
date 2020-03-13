<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lineas_prod extends Model
{
    protected $table = "lineas_prods";
    protected $fillable = array('nombre', 'estatus' ); 
    
}
