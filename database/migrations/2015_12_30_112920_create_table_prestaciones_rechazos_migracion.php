<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePrestacionesRechazosMigracion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestaciones.rechazos_migracion', function (Blueprint $table) {
            $table->increments('id');           
            $table->char('estado', 1)->nullable();
            $table->string('efector', 14)->nullable();
            $table->string('numero_comprobante', 50)->nullable();
            $table->string('codigo_prestacion', 11)->nullable();
            $table->string('subcodigo_prestacion', 3)->nullable();
            $table->float('precio_unitario')->nullable();
            $table->date('fecha_prestacion')->nullable();
            $table->string('clave_beneficiario', 16)->nullable();
            $table->char('tipo_documento', 3)->nullable();
            $table->char('clase_documento', 1)->nullable();
            $table->string('numero_documento', 14)->nullable();
            $table->smallInteger('orden')->nullable();
            $table->integer('lote')->nullable();
            $table->string('datos_reportables')->nullable();                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prestaciones.rechazos_migracion');
    }
}
