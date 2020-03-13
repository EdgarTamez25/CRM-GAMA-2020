<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class unidades extends Model
{
    protected $table = "unidades";
    protected $fillable = array('nombre','estatus');

}
