<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePucoBeneficiariosSss extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puco.beneficiarios_sss', function(Blueprint $table)
        {
            $table->bigInteger('cuil_beneficiario')->nullable();
            $table->char('tipo_documento',3);
            $table->bigInteger('numero_documento');
            $table->string('nombre_apellido',255)->nullable();
            $table->char('sexo',1)->nullable();
            $table->string('fecha_nacimiento',255)->nullable();
            $table->string('tipo_beneficiario',255)->nullable();
            $table->string('codigo_parentezco',255);
            $table->string('codigo_postal',8)->nullable();
            $table->char('id_provincia',2)->nullable();
            $table->bigInteger('cuil_titular');
            $table->integer('codigo_os')->nullable();
            $table->char('ultimo_aporte',6)->nullable();
            $table->char('cuil_valido',1)->nullable();
            $table->bigInteger('cuit_empleador');
            $table->integer('lote')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('puco.beneficiarios_sss');
    }
}
