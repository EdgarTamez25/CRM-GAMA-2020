<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipos_precios extends Model
{
    protected $table = "tipos_precios";
    protected $fillable = array('nombre','estatus');
}
