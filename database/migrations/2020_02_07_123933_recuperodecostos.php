<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Recuperodecostos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('efectores.efectores', function (Blueprint $table) {
		$table->char('recupera_costos', 1)->default('N');
		$table->char('osp', 1)->default('N');
		$table->char('pami', 1)->default('N');
		$table->char('os_directo', 1)->default('N');
		$table->char('otro', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('efectores.efectores', function (Blueprint $table) {
		$table->dropColumn('recupera_costos');
		$table->dropColumn('osp');
		$table->dropColumn('pami');
		$table->dropColumn('os_directo');
		$table->dropColumn('otro');
        });
    }
}
