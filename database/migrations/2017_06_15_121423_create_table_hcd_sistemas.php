<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHcdSistemas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcd.sistemas', function (Blueprint $table) {
            $table->increments('id_sistema');            
            $table->char('id_provincia',2);
            $table->string('nombre',50);
            $table->foreign('id_provincia')->references('id_provincia')->on('geo.provincias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hcd.sistemas');
    }
}
