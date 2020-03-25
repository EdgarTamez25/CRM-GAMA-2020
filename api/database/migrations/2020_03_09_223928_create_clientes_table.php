<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id'); //Big Increments crea la tabla como Big integer y autoincremental, se puede agregar tambien como bigInteger('id',true) y pasarle true para que sea autoincremental
            $table->string('nombre');
            $table->integer('id_subzona')->nullable();
            $table->string('direccion')->nullable();
            $table->string('razon_social')->nullable();
            $table->integer('fuente');//id del vendedor : quien registró al cliente
            $table->integer('tipo_cliente');
            $table->string('rfc')->nullable();
            $table->string('curp')->nullable();
            $table->integer('nivel')->nullable();
            $table->integer('id_cartera')->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
