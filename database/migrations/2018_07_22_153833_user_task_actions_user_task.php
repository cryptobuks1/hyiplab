<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTaskActionsUserTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_task_actions', function(Blueprint $table) {
            $table->string('user_task_id');
        });

        Schema::table('user_task_actions', function(Blueprint $table) {
            $table->foreign('user_task_id')->references('id')->on('user_tasks');
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
