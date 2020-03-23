<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRastreoRutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rastreo_rutas', function (Blueprint $table) {
            $table->bigIncrements('id'); //Big Increments crea la tabla como Big integer y autoincremental, se puede agregar tambien como bigInteger('id',true) y pasarle true para que sea autoincremental
            $table->integer('id_rastreo');
            $table->string('latitud');
            $table->string('longitud');
            $table->integer('flujo_rastreo');//Este campo es referido a los puntos que conforman la ruta (1 cada min o por definir)
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
        Schema::dropIfExists('rastreo_rutas');
    }
}
