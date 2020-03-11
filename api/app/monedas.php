<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class monedas extends Model
{
    protected $table = "monedas";
    protected $fillable = array('codigo','nombre', 'tipo_cambio','estatus'); 
}
