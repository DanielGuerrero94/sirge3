<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadorasHeaders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.headers', function (Blueprint $table) {
            $table->integer('lote'); 
            $table->smallInteger('trazadora');            
            $table->integer('casos_positivos');
            $table->date('fecha_generacion')->nullable();
            $table->string('hora_generacion',8)->nullable();
            $table->string('usuario_generacion',25)->nullable();
            $table->string('version_aplicativo',10)->nullable();
            $table->timestamps();
            $table->foreign('lote')->references('lote')->on('sistema.lotes');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trazadoras.headers');
    }
}
