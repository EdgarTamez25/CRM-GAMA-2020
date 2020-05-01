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
            $table->integer('tipo_compromiso'); // INTERNO  O EXTERNO
            $table->integer('id_categoria');    // PROSPECTO, QUEJAS...
            $table->date('fecha');          // FECHA DEL COMPROMISO
            $table->date('hora');           // HORA DEL COMPROMISO
            $table->integer('id_contacto');  
            $table->integer('id_cliente');
            $table->longText('comentarios')->nullable(); // DEL USUARIO QUE ESTA ASIGNANDO
            $table->integer('fase_venta');//0=sin compromiso, 1=sin cotizar, 2=prospecto, 3=cotizacion, 4=rechazado, 5=aceptado, 6=entregado, 7=finalizado
            $table->integer('enruta') ->nullable()
            $table->integer('id_usuario');
            $table->longText('obs_usuario')->nullable();  // DEL VENDEDOR
            $table->integer('cumplimiento');  // MARCA SI SE REALIZO COMPROMISO O NO
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
