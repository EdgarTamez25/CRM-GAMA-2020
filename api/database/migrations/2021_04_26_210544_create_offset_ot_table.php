<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffsetOtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offset_ot', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_det_ot');
            $table->integer('id_maquina') -> nullable();
            $table->integer('id_sucursal');
            $table->integer('urgencia');
            $table->datetime('creacion');
            $table->integer('id_creador');
            $table->datetime('finalizacion')-> nullable();
            $table->integer('estatus') ->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offset_ot');
    }
}
