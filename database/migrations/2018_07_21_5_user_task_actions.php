<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTaskActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_task_actions', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->string('task_action_id');
            $table->dateTime('last_check_datetime');
            $table->boolean('finished')->default(0);
            $table->timestamps();
        });

        Schema::table('user_task_actions', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('task_action_id')->references('id')->on('task_actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_task_actions');
    }
}
