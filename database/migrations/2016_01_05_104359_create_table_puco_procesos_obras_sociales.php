<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePucoProcesosObrasSociales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puco.procesos_obras_sociales', function(Blueprint $table)
        {
            $table->integer('lote')->nullable();
            $table->integer('periodo');
            $table->char('periodo',1)->default('N');
            $table->foreign('lote')
            ->references('lote')
            ->on('sistema.lotes');             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('puco.procesos_obras_sociales');
    }
}
