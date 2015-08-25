<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes.solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('referencia')->nullable();
            $table->integer('usuario_solicitante');
            $table->timestamp('fecha_solicitud');
            $table->date('fecha_estimada_solucion');
            $table->integer('prioridad');
            $table->integer('tipo');
            $table->text('descripcion_solicitud');
            $table->integer('estado')->default(1);
            $table->integer('usuario_asignacion')->nullable();
            $table->timestamp('fecha_asignacion')->nullable();
            $table->date('fecha_solucion')->nullable();
            $table->text('descripcion_solucion')->nullable();
            $table->timestamps();

            $table->foreign('usuario_solicitante')->references('id_usuario')->on('sistema.usuarios');
            $table->foreign('usuario_asignacion')->references('id_usuario')->on('sistema.usuarios');
            $table->foreign('tipo')->references('id')->on('solicitudes.tipo_solicitud');
            $table->foreign('estado')->references('id')->on('solicitudes.estados');
            $table->foreign('prioridad')->references('id')->on('solicitudes.prioridades');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('solicitudes.solicitudes');
    }
}
