<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class create_ot_table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ot', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_depto');
            $table->integer('id_cliente');
            $table->string('oc',50);
            $table->string('referencia',50);
            $table->date('fecha');
            $table->string('hora',10);
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
        Schema::dropIfExists('ot');
    }
}
