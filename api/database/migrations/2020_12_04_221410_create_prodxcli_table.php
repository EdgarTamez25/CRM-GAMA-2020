<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdxcliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodxcli', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->integer('id_producto');
            $table->integer('id_cliente');
            $table->string('nombre',100);
            $table->integer('codigo');
            $table->string('descripcion',500);
            $table->integer('revision');
            $table->date('fecha'); 
            $table->string('url',500);
            $table->integer('dx');
            $table->integer('id_dx');
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
        Schema::dropIfExists('prodxcli');
    }
}
