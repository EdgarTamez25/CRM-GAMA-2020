<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimSolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movim_sol', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_solicitud');
            $table->integer('id_px');
            $table->integer('id_depto');
            $table->date('fecha');         
            $table->string('hora');
            $table->integer('responsable');
            $table->integer('responsable2') ->nullable();
            $table->integer('id_encargado') ->nullable();
            $table->integer('estatus') ->default(1);


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
        Schema::dropIfExists('movim_sol');
    }
}
