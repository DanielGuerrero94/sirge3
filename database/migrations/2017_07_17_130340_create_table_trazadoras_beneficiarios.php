<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadorasBeneficiarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.beneficiarios', function (Blueprint $table) {
            $table->string('numero_documento', 12);
            $table->char('clave_beneficiario', 16)->nullable();
            $table->string('tipo_documento', 5)->nullable();
            $table->char('clase_documento', 1)->nullable();
            $table->string('apellido', 40)->nullable();
            $table->string('nombre', 40)->nullable();
            $table->char('sexo', 1)->nullable();
            $table->date('fecha_nacimiento')->nullable();
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
        Schema::drop('trazadoras.beneficiarios');
    }
}
