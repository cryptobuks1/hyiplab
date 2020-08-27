<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BlockioNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockio_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('network');
            $table->string('notification_id');
            $table->timestamps();
        });

        Schema::table('blockio_notifications', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blockio_notifications');
    }
}
