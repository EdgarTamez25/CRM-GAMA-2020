<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produccion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_det_ot');
            $table->integer('id_producto');
            $table->integer ('cant_sol');
            $table->integer('urgencia');
            $table->integer('total');
            $table->datetime('fentrega');
            $table->integer('id_creador');
            $table->timestamps('creacion');
            $table->datetime('finalizacion')-> nullable();
            $table->integer('tipo_prog');
            $table->integer('estatus')->default(1);
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
        Schema::dropIfExists('produccion');
    }
}
