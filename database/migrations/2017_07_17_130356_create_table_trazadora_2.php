<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_2', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->string('numero_documento', 12);
            $table->string('orden', 2)->nullable();
            $table->char('departamento_residencia', 3)->nullable();
            $table->date('fecha_probable_parto_usada')->nullable();
            $table->string('observaciones')->nullable();
            $table->jsonb('detalle')->nullable();
            $table->integer('lote');
            $table->index(['periodo','numero_documento']);
            $table->index('numero_documento', 'idx_documento_trz_2');
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
        Schema::drop('trazadoras.trz_2');
    }
}
