<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompromisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compromisos', function (Blueprint $table) {
            $table->bigIncrements('id'); //Big Increments crea la tabla como Big integer y autoincremental, se puede agregar tambien como bigInteger('id',true) y pasarle true para que sea autoincremental
            $table->integer('id_vendedor');
            $table->integer('tipo_compromiso');//cita, reunion...
            $table->dateTime('fecha');
            $table->dateTime('hora');
            $table->integer('id_contacto');
            $table->longText('comentarios')->nullable();
            $table->integer('id_cliente');
            $table->integer('fase_venta');//0=sin compromiso, 1=sin cotizar, 2=prospecto, 3=cotizacion, 4=rechazado, 5=aceptado, 6=entregado, 7=finalizado
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
        Schema::dropIfExists('compromisos');
    }
}
