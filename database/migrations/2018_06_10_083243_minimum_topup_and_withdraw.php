<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MinimumTopupAndWithdraw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_systems', function (Blueprint $table) {
            $table->json('minimum_topup')->nullable()->default(null);
            $table->json('minimum_withdraw')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_systems', function (Blueprint $table) {
            $table->dropColumn('minimum_topup');
            $table->dropColumn('minimum_withdraw');
        });
    }
}
