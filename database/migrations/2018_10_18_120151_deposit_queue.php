<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DepositQueue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_queue', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('deposit_id');
            $table->integer('type');
            $table->timestamp('available_at');
            $table->boolean('done')->default(false);
            $table->timestamps();
        });

        Schema::table('deposit_queue', function($table) {
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
        Schema::dropIfExists('deposit_queue');
    }
}
