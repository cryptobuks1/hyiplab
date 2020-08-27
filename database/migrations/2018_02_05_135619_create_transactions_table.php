<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('type_id');
            $table->uuid('user_id');
            $table->uuid('currency_id');
            $table->uuid('rate_id')->nullable();
            $table->uuid('deposit_id')->nullable();
            $table->uuid('wallet_id');
            $table->uuid('payment_system_id')->nullable();
            $table->float('amount');
            $table->string('source')->nullable();
            $table->string('result')->nullable();
            $table->string('batch_id')->nullable();
            $table->float('commission')->nullable();
            $table->boolean('approved')->default(false);
            $table->mediumText('log')->nullable(); // what for?...
            $table->timestamps();
        });

        Schema::table('transactions', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('type_id')->references('id')->on('transaction_types');
            $table->foreign('payment_system_id')->references('id')->on('payment_systems');
            $table->foreign('wallet_id')->references('id')->on('wallets');
            $table->foreign('rate_id')->references('id')->on('rates');
            $table->foreign('deposit_id')->references('id')->on('deposits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
