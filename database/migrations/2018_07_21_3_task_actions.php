<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaskActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_actions', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('task_id');
            $table->string('task_scope_id');
            $table->text('source_address');
            $table->timestamps();
        });

        Schema::table('task_actions', function(Blueprint $table) {
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('task_scope_id')->references('id')->on('task_scopes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_actions');
    }
}
