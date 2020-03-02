<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDiccionariosDiccionario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diccionarios.diccionario', function (Blueprint $table) {
            $table->string('ejemplo', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diccionarios.diccionario', function (Blueprint $table) {
		$table->dropColumn('ejemplo');
        });
    }
}
