<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class carteras extends Model
{
    protected $table = "carteras";
    protected $fillable = array('nombre', 'estatus' ); 

}
