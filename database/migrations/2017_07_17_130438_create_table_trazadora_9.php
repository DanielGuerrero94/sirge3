<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_9', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->string('numero_documento', 12);
            $table->jsonb('detalle')->nullable();
            $table->integer('lote');
            $table->index(['periodo','numero_documento']);
            $table->index('numero_documento', 'idx_documento_trz_9');
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
        Schema::drop('trazadoras.trz_9');
    }
}
