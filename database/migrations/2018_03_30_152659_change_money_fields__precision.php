<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMoneyFieldsPrecision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('wallets', function (Blueprint $table) {
            $table->decimal('balance', 24,12)->default(0)->nullable()->unsigned()->change();
        });

        Schema::table('rates', function (Blueprint $table) {
            $table->decimal('min', 24,12)->default(0)->nullable()->unsigned()->change();
            $table->decimal('max', 24,12)->default(0)->nullable()->unsigned()->change();
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->decimal('balance', 24,12)->default(0)->nullable()->unsigned()->change();
            $table->decimal('invested', 24,12)->default(0)->unsigned()->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('amount', 24,12)->unsigned()->change();
        });

        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->decimal('amount', 24,12)->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //обратно уже не сработает все равно, только дропая столбец, что возможно только при обнулении самого проекта..

    }
}
