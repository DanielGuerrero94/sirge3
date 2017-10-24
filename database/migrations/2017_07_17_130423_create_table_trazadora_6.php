<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_6', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->char('cuie', 6);
            $table->string('numero_documento', 12);
            $table->date('fecha_diagnostico')->nullable();
            $table->date('fecha_denuncia')->nullable();
            $table->string('cardiopatia_detectada', 3)->nullable();
            $table->bigInteger('id_registro_provincial')->nullable();
            $table->bigInteger('id_registro')->nullable();
            $table->integer('lote');
            $table->index(['periodo','cuie','numero_documento']);
            $table->index('numero_documento', 'idx_documento_trz_6');
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
        Schema::drop('trazadoras.trz_6');
    }
}
