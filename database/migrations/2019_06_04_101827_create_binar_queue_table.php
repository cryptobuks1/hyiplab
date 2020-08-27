<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBinarQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binar_queue', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('deposit_id');
            $table->string('user_id');
            $table->integer('left')->default(0);
            $table->float('amount', 16,     8 )->default(0);
            $table->timestamps();
        });

        Schema::table('binar_queue', function($table) {
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
        Schema::dropIfExists('binar_queue');
    }

}
