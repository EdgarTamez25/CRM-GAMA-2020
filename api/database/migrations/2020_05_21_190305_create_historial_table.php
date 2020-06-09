<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_compromiso');
            $table->date('fecha');
            $table->time('hora');
            $table->string('numorden')->nullable()->default('');
            $table->integer('aceptado')->default(0);
            $table->integer('fase_venta');
            $table->longText('obscierre')->nullable()->default('');
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
        Schema::dropIfExists('historial');
    }
}
