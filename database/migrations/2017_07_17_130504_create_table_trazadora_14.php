<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora14 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_14', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->char('cuie', 6);
            $table->string('numero_documento', 12);
            $table->string('orden', 2)->nullable();
            $table->date('fecha_defuncion')->nullable();
            $table->date('fecha_auditoria_muerte')->nullable();
            $table->date('fecha_parto_o_interrupcion_embarazo')->nullable();
            $table->string('diagnostico', 4)->nullable();
            $table->bigInteger('id_registro_provincial')->nullable();
            $table->bigInteger('id_registro')->nullable();
            $table->integer('lote');
            $table->index(['periodo','cuie','numero_documento']);
            $table->index('numero_documento', 'idx_documento_trz_14');
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
        Schema::drop('trazadoras.trz_14');
    }
}
