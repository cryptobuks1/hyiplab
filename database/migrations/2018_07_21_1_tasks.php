<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->float('reward_amount')->default(0);
            $table->string('reward_payment_system_id')->nullable();
            $table->string('reward_currency_id')->nullable();
            $table->integer('duration')->default(0);
            $table->timestamps();
        });

        Schema::table('tasks', function(Blueprint $table) {
            $table->foreign('reward_payment_system_id')->references('id')->on('payment_systems');
            $table->foreign('reward_currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
