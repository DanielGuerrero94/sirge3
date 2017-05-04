<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSolicitudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes.solicitudes', function($table)
        {
            $table->bigInteger('id_adjunto');
            $table->foreign('id_adjunto')->references('id_adjunto')->on('solicitudes.adjuntos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudes.solicitudes', function($table)
        {
            $table->dropColumn('id_adjunto');
        });
    }
}
