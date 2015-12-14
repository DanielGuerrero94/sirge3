<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePssTipoPrestacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pss.tipo_prestacion', function(Blueprint $table)
        {
            $table->char('tipo_prestacion', 2)->primary();
            $table->string('descripcion',50);
            $table->string('icono',30)->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pss.tipo_prestacion');
    }
}
