<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TelegramBotEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_bot_events', function($table) {
            $table->uuid('id')->primary();

            $table->integer('update_id');
            $table->integer('message_id');

            $table->integer('from_id');
            $table->boolean('from_is_bot')->default(false);
            $table->string('from_first_name')->nullable();
            $table->string('from_last_name')->nullable();
            $table->string('from_username')->nullable();
            $table->string('from_language_code')->default('en');

            $table->integer('chat_id');
            $table->string('chat_first_name')->nullable();
            $table->string('chat_last_name')->nullable();
            $table->string('chat_username')->nullable();
            $table->string('chat_type');

            $table->integer('date');

            $table->string('text')->nullable();

            $table->string('bot_keyword')->nullable();
            $table->string('bot_id');
            $table->string('webhook_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telegram_bot_events');
    }
}
