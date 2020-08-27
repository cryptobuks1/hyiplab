<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersSocialMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_social_meta', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->text('s_key')->nullable();
            $table->text('s_value')->nullable();
            $table->timestamps();
        });

        Schema::table('users_social_meta', function(Blueprint $table) {
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
        Schema::dropIfExists('users_social_meta');
    }
}
