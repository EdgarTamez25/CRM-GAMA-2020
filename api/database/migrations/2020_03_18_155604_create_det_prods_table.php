<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetProdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_prods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cantidad')->nullable();
            $table->integer('id_producto');
            $table->integer('id_precio');
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
        Schema::dropIfExists('det_prods');
    }
}
