<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TelegramWebhooksInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_webhooks_info', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('telegram_webhook_id');
            $table->string('url');
            $table->boolean('has_custom_certificate');
            $table->integer('pending_update_count');
            $table->integer('last_error_date')->nullable();
            $table->string('last_error_message')->nullable();
            $table->integer('max_connections')->nullable();
            $table->text('allowed_updates')->nullable();
            $table->timestamps();
        });

        Schema::table('telegram_webhooks_info', function($table) {
            $table->foreign('telegram_webhook_id')->references('id')->on('telegram_webhooks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telegram_webhooks_info');
    }
}
