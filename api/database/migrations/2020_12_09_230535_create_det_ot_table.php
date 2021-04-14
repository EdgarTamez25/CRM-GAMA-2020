<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetOtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_ot', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_ot');
            $table->integer('id_producto');
            $table->string ('cantidad',50);
            $table->date('fecha_progra'); 
            $table->date('fecha_entrega'); 
            $table->integer('concepto');
            $table->integer('urgencia');
            $table->string('razon',500);
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
        Schema::dropIfExists('det_ot');
    }
}
