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
            $table->integer('cant_sol');
            $table->integer('urgencia');
            $table->integer('total');
            $table->date('fecha_entrega');
            $table->integer('id_creador');
            $table->date('creacion');
            $table->date('finalizacion')->nullable();
            $table->integer('tipo_prog');
            $table->integer('cant_prog');
            $table->integer('id_depto');
            $table->integer('id_sucursal');
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
