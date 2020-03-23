<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->bigIncrements('id'); //Big Increments crea la tabla como Big integer y autoincremental, se puede agregar tambien como bigInteger('id',true) y pasarle true para que sea autoincremental
            $table->string('nombre');
            $table->string('tel1')->nullable();
            $table->string('tel2')->nullable();
            $table->string('tel3')->nullable();
            $table->string('correo')->nullable();
            $table->longText('obs')->nullable();
            $table->string('departamento')->nullable();
            $table->dateTime('cumpleanios')->nullable();
            $table->integer('id_proveedor')->nullable();
            $table->integer('id_cliente')->nullable();
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
        Schema::dropIfExists('contactos');
    }
}
