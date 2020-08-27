<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaskCoefficients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_coefficients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('task_id');
            $table->integer('min_minutes')->default(0);
            $table->integer('max_minutes')->default(0);
            $table->float('reward_coefficient');
            $table->timestamps();
        });

        Schema::table('task_coefficients', function (Blueprint $table) {
            $table->foreign('task_id')->references('id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_coefficients');
    }
}
