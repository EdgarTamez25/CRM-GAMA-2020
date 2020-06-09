<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_compromiso');
            $table->integer('id_chofer');
            $table->date('fecha_entrega');
            $table->string('hora_entrega');
            $table->string('nummovim')->nullable();
            $table->string('numfac')->nullable();
            $table->longtext('obs')->nullable();
            $table->integer('estatus')->default(0);
            $table->date('fecha_cierre')->nullable();
            $table->string('hora_cierre')->nullable();
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
        Schema::dropIfExists('entregas');
    }
}
