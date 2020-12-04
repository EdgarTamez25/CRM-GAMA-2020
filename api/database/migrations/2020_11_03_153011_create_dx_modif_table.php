<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDxModifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dx_modif', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_prod_modif');
            $table->string('concepto',50);
            $table->string('valor',100);
            $table->integer('accion')  ->nullable();
            $table->string('valor2',100) ->nullable();
            $table->string('ft',50) ->nullable();
            $table->string('valor',250) ->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dx_modif');
    }
}
