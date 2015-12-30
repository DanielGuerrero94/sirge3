<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePucoBeneficiariosOsp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puco.beneficiarios_osp', function(Blueprint $table)
        {
            $table->string('tipo_documento', 3);
            $table->bigInteger('numero_documento'); 
            $table->string('nombre_apellido',50);
            $table->char('sexo',1);
            $table->integer('codigo_os')->nullable();
            $table->string('codigo_postal',8);
            $table->char('id_provincia',2)->nullable();
            $table->char('tipo_afiliado',1);
            $table->integer('lote');
            $table->foreign('codigo_os')
            ->references('codigo_osp')
            ->on('puco.obras_sociales');
            $table->foreign('tipo_documento')
            ->references('tipo_documento')
            ->on('sistema.tipo_documento');                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('puco.beneficiarios_osp');
    }
}
