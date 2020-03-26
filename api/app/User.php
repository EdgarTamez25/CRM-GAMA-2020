<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    protected $fillable = array(
                                'nombre','password','correo'
                                ,'nivel','id_sucursal','foto','estatus'
                               );
}



