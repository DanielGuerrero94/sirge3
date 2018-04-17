<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisionPrestacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dr.revision_prestaciones', function (Blueprint $table) {
            $table->integer('id_prestacion')->primary();
            $table->integer('lote');
	    $table->jsonb('validos')->nullable();
	    $table->jsonb('ausentes')->nullable();
	    $table->jsonb('errores')->nullable();
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
        Schema::drop('dr.revision_prestaciones');
    }
}
