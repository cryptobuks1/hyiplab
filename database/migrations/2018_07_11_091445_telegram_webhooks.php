<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TelegramWebhooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_webhooks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('telegram_bot_id');
            $table->string('url')->unique();
            $table->string('certificate')->nullable();
            $table->integer('max_connections')->nullable();
            $table->text('allowed_updates')->nullable();
            $table->timestamps();
        });

        Schema::table('telegram_webhooks', function($table) {
            $table->foreign('telegram_bot_id')->references('id')->on('telegram_bots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telegram_webhooks');
    }
}
