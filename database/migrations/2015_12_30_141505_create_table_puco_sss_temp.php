<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePucoSssTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puco.sss_temp', function(Blueprint $table)
        {
            $table->increments('id_osp_prueba');
            $table->text('cuil_beneficiario')->nullable();
            $table->text('tipo_documento')->nullable();
            $table->text('numero_documento')->nullable();
            $table->text('nombre_apellido')->nullable();
            $table->text('sexo')->nullable();
            $table->text('fecha_nacimiento')->nullable();
            $table->text('tipo_beneficiario')->nullable();
            $table->text('codigo_parentezco')->nullable();
            $table->text('codigo_postal')->nullable();
            $table->text('id_provincia')->nullable();
            $table->text('cuil_titular')->nullable();
            $table->text('codigo_os')->nullable();
            $table->text('ultimo_aporte')->nullable();
            $table->text('cuil_valido')->nullable();
            $table->text('cuit_empleador')->nullable();
            $table->text('lote')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('puco.sss_temp');
    }
}
