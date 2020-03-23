<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id'); //Big Increments crea la tabla como Big integer y autoincremental, se puede agregar tambien como bigInteger('id',true) y pasarle true para que sea autoincremental
            $table->integer('id_vendedor')->nullable();
            $table->integer('id_cliente')->nullable();
            $table->float('enero')->nullable();
            $table->float('febrero')->nullable();
            $table->float('marzo')->nullable();
            $table->float('abril')->nullable();
            $table->float('mayo')->nullable();
            $table->float('junio')->nullable();
            $table->float('julio')->nullable();
            $table->float('agosto')->nullable();
            $table->float('septiembre')->nullable();
            $table->float('octubre')->nullable();
            $table->float('noviembre')->nullable();
            $table->float('diciembre')->nullable();
            $table->float('total_anual')->nullable();
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
        Schema::dropIfExists('ventas');
    }
}
