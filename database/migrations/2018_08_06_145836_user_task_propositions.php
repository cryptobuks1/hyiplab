<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTaskPropositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_task_propositions', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->string('task_id');
            $table->timestamps();
        });

        Schema::table('user_task_propositions', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_task_propositions');
    }
}
