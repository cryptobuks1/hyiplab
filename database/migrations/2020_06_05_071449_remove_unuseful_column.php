<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnusefulColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('blockio_wallet_btc');
            $table->dropColumn('blockio_wallet_ltc');
            $table->dropColumn('blockio_wallet_doge');
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
            $table->dropColumn('rank_id');
            $table->dropColumn('left_line');
            $table->dropColumn('left_line_sum');
            $table->dropColumn('right_line_sum');
            $table->dropColumn('refback');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
