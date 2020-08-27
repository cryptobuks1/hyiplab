<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserNewField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->string('sex', 10)->after('blockio_wallet_ltc')->nullable();
            $table->string('country', 100)->after('sex')->nullable();
            $table->string('city', 100)->after('country')->nullable();
            $table->float('longitude')->after('country')->nullable();
            $table->float('latitude')->after('longitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('sex');
            $table->dropColumn('country');
            $table->dropColumn('city');
        });
    }
}
