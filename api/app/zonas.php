<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class zonas extends Model
{
    protected $table = "zonas";
    protected $fillable = array('nombre', 'id_ciudad', 'estatus' ); 
}
