<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTableEfectoresEfectores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('efectores.efectores', function ($table) {
            $table->char('hcd', 1)->default('N');
            $table->smallInteger('id_sistema_hcd')->nullable();
            $table->foreign('id_sistema_hcd')->references('id_sistema')->on('hcd.sistemas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
