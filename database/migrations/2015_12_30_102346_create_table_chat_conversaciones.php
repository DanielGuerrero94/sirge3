<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableChatConversaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat.conversaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        \DB::statement(" ALTER TABLE chat.conversaciones ADD COLUMN usuarios integer[], ADD CONSTRAINT UNIQUE (usuarios);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chat.conversaciones');
    }
}
