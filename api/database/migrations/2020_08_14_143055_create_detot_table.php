<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detot', function (Blueprint $table) {
            $table->bigIncrements(id);
            $table->integer('id_ot');
            $table->integer('id_producto');
            $table->date('fecha_pro');
            $table->string('hora_pro',5);
            $table->integer('cantidad');
            $table->string('obs',500);
            $table->integer('prioridad');
            $table->date('fecha_ent');
            $table->string('hora_ent',5);
            $table->integer('tipo');
            $table->string('ciclo',20);
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
        Schema::dropIfExists('detot');
    }
}
