<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTplDefaultLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tpl_default_langs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('text')->unique();
            $table->uuid('lang_id');
            $table->timestamps();
        });

        Schema::table('tpl_default_langs', function($table) {
            $table->foreign('lang_id')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tpl_default_langs');
    }
}
