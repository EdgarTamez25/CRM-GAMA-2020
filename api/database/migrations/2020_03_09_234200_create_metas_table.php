<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metas', function (Blueprint $table) {
            $table->bigIncrements('id'); //Big Increments crea la tabla como Big integer y autoincremental, se puede agregar tambien como bigInteger('id',true) y pasarle true para que sea autoincremental
            $table->integer('id_vendedor');
            $table->integer('id_cliente');
            $table->float('enero');
            $table->float('febrero');
            $table->float('marzo');
            $table->float('abril');
            $table->float('mayo');
            $table->float('junio');
            $table->float('julio');
            $table->float('agosto');
            $table->float('septiembre');
            $table->float('octubre');
            $table->float('noviembre');
            $table->float('diciembre');
            $table->float('total_anual');
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
        Schema::dropIfExists('metas');
    }
}
