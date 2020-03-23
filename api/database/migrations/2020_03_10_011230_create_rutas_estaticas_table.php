<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRutasEstaticasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rutas_estaticas', function (Blueprint $table) {
            $table->bigIncrements('id'); //Big Increments crea la tabla como Big integer y autoincremental, se puede agregar tambien como bigInteger('id',true) y pasarle true para que sea autoincremental
            $table->integer('id_rastreo_rutas');//En este campo se registra el rastreo de la ruta cuando la localización no cambia
            $table->dateTime('fecha');
            $table->string('latitud');
            $table->string('longitud');
            $table->dateTime('tiempo');
            $table->integer('estatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rutas_estaticas');
    }
}
