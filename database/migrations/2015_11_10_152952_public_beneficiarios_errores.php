<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PublicBeneficiariosErrores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.beneficiarios_errores', function (Blueprint $table) {
            $table->string('clave_beneficiario',40)->primary();
            $table->longText('descripcion_errores')->nullable();
            $table->longText('valores')->nullable();
            $table->string('estado',2);
            $table->integer('periodo');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('public.beneficiarios_errores');
    }
}
