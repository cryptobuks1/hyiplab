<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('currency_id');
            $table->uuid('rate_id');
            $table->uuid('user_id');
            $table->uuid('wallet_id');
            $table->string('name')->nullable();
            $table->float('daily')->default(0)->unsigned()->nullable();
            $table->float('overall')->default(0)->unsigned()->nullable();
            $table->integer('duration')->default(0)->unsigned()->nullable();
            $table->float('payout')->default(0)->unsigned()->nullable();
            $table->float('invested')->default(0)->unsigned();
            $table->float('balance', 24, 12)->default(0)->unsigned()->nullable();
            $table->boolean('reinvest')->default(0);
            $table->boolean('autoclose')->default(0);
            $table->boolean('active')->default(0);
            $table->string('condition')->default('undefined');
            $table->text('log')->nullable();
            $table->timestamps();
        });

        Schema::table('deposits', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('rate_id')->references('id')->on('rates');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('wallet_id')->references('id')->on('wallets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
}
