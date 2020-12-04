<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrientacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orientaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',100);
            $table->integer('activo');
            $table->integer('dx');
            $table->string('img',250);
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
        Schema::dropIfExists('orientaciones');
    }
}
