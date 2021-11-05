<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimProdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movim_prod', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_produccion');
            $table->integer('id_depto');
            $table->integer('id_sucursal');
            $table->integer('id_producto');
            $table->integer('cant_sol');
            $table->integer('recibidas')->nullable();
            $table->integer('terminadas')->nullable();
            $table->datetime('creacion');
            $table->integer('estatus_prod')->default(1);
            $table->integer('estatus')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movim_prod');
    }
}
