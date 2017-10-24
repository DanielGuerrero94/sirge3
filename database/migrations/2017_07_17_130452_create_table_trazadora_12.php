<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora12 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_12', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->char('cuie', 6);
            $table->string('numero_documento', 12);
            $table->date('fecha_diagnostico_histologico')->nullable();
            $table->char('diagnostico', 1)->nullable();
            $table->date('fecha_inicio_tratamiento')->nullable();
            $table->bigInteger('id_registro_provincial')->nullable();
            $table->bigInteger('id_registro')->nullable();
            $table->integer('lote');
            $table->index(['periodo','cuie','numero_documento']);
            $table->index('numero_documento', 'idx_documento_trz_12');
            //$table->foreign('numero_documento')->references('numero_documento')->on('trazadoras.beneficiarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trazadoras.trz_12');
    }
}
