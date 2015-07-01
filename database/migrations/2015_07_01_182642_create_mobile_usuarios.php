<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile.usuarios', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->string('nombre' , 200);
            $table->string('apellido' , 200);
            $table->char('sexo' , 1);
            $table->char('tipo_documento' , 3);
            $table->string('numero_documento' , 14);
            $table->date('fecha_nacimiento');
            $table->string('email' , 254)->unique();
            $table->string('pass' , 32);
            $table->string('celular')->nulleable();
            $table->char('id_provincia' , 2);
            $table->string('domicilio')->default('NO REGISTRADO');
            $table->char('validado')->default('N');
            $table->string('uniqueid' , 32)->unique();

            $table->timestamp('creado')->default(DB::raw('now()::timestamp(0)'));
            $table->timestamp('modificado');
            $table->timestamp('validado'):

            $table->foreing('sexo')->references('sigla')->on('sistema.sexos');
        });

        DB::statement('ALTER TABLE mobile.usuarios DROP CONSTRAINT usuarios_pkey;');

        Schema::create('mobile.usuarios' , function (Blueprint $table) {
            $table->primary(['tipo_documento','numero_documento','sexo','email'])
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mobile.usuarios');
    }
}
