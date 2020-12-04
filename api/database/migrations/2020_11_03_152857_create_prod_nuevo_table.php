<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdNuevoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_nuevo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_solicitud');
            $table->integer('dx');
            $table->integer('id_dx');
            $table->string('ft',50);
            $table->integer('tipo_prod');
            $table->string('cantidad',50);
            $table->integer('estatus') ->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prod_nuevo');
    }
}
