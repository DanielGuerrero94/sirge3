<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableChatMensajes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat.mensajes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_conversacion')->nullable();
            $table->integer('id_usuario')->nullable();
            $table->text('mensaje')->nullable();
            $table->char('leido',1)->default('N')->nullable();

        });

        \DB::statement(" ALTER TABLE chat.mensajes ADD COLUMN fecha timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone;"); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chat.mensajes');
    }
}
