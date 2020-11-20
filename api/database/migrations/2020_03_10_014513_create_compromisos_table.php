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
            $table->integer('tipo'); // INTERNO  O EXTERNO
            $table->integer('id_categoria');    // PROSPECTO, QUEJAS...
            $table->date('fecha');          // FECHA INICIO DEL COMPROMISO
            $table->string('hora');           // HORA INICIO DEL COMPROMISO
            $table->date('fecha_cierre')->nullable();          // FECHA CIERRE DEL COMPROMISO
            $table->date('hora_cierre')->nullable();           // HORA CIERRE DEL COMPROMISO
            $table->integer('id_cliente');
            $table->longText('obs')->nullable(); // DEL USUARIO QUE ESTA ASIGNANDO
            $table->integer('fuente');    // PROSPECTO, QUEJAS...
            $table->longText('obs_usuario')->nullable();  // DEL VENDEDOR
            $table->integer('confirma_cita')->default(0);
            $table->integer('cumplimiento')->default(0);  // MARCA SI SE REALIZO COMPROMISO O NO
            $table->integer('estatus')->default(0);
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
