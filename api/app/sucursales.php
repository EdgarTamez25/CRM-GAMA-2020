<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sucursales extends Model
{
    protected $table = "sucursales";
    protected $fillable = array('nombre','estatus');
}
