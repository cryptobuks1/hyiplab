<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TelegramBotMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_bot_messages', function($table) {
            $table->uuid('id')->primary();
            $table->string('sender');
            $table->string('receive');
            $table->string('bot_id');
            $table->longText('message')->nullable();
            $table->timestamps();
        });

        Schema::table('telegram_bot_messages', function($table) {
            $table->foreign('bot_id')->references('id')->on('telegram_bots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telegram_bot_messages');
    }
}
