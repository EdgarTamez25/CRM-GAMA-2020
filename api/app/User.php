<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    protected $fillable = array(
                                'empleado',
                                'nombre',
                                'password',
                                'correo',
                                'usuario',
                                'nivel',
                                'id_sucursal',
                                'foto',
                                'estatus',
                                'id_depto',
                                'id_puesto'
                               );

   
}



