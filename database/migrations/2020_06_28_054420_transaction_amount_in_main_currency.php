<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransactionAmountInMainCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->float('main_currency_amount', 24, 12)->after('amount')->default(0);
        });

        Schema::table('currencies', function (Blueprint $table) {
            $table->boolean('main_currency')->after('code')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('main_currency_amount');
        });

        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn('main_currency');
        });
    }
}
